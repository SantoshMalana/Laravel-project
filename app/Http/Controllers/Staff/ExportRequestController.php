<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ExportRequest;
use App\Models\ShipmentTracking;
use App\Services\DocumentService;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class ExportRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ExportRequest::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('tracking_no', 'like', '%'.$request->search.'%')
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', '%'.$request->search.'%'))
                    ->orWhere('destination_country', 'like', '%'.$request->search.'%');
            });
        }

        $requests = $query->paginate(15);

        return view('staff.requests.index', compact('requests'));
    }

    public function show(ExportRequest $exportRequest)
    {
        $exportRequest->load(['user', 'trackings.updatedBy', 'documents']);

        return view('staff.requests.show', compact('exportRequest'));
    }

    public function approve(ExportRequest $exportRequest, DocumentService $documentService)
    {
        $exportRequest->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        ShipmentTracking::create([
            'export_request_id' => $exportRequest->id,
            'status' => 'approved',
            'location' => 'Post Office — Processing Center',
            'description' => 'Shipment approved by staff. Documents being prepared.',
            'updated_by' => auth()->id(),
        ]);

        $documentService->generateAll($exportRequest);

        NotificationService::send(
            $exportRequest->user_id,
            'Export Request Approved!',
            "Your shipment #{$exportRequest->tracking_no} has been approved. Documents are ready.",
            'success',
            route('customer.export-requests.show', $exportRequest)
        );

        return back()->with('success', 'Export request approved and documents generated.');
    }

    public function reject(Request $request, ExportRequest $exportRequest)
    {
        $request->validate(['rejection_reason' => 'required|string|max:500']);

        $exportRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        ShipmentTracking::create([
            'export_request_id' => $exportRequest->id,
            'status' => 'rejected',
            'location' => 'Post Office',
            'description' => 'Shipment rejected. Reason: '.$request->rejection_reason,
            'updated_by' => auth()->id(),
        ]);

        NotificationService::send(
            $exportRequest->user_id,
            'Export Request Rejected',
            "Your shipment #{$exportRequest->tracking_no} was rejected. Reason: {$request->rejection_reason}",
            'danger',
            route('customer.export-requests.show', $exportRequest)
        );

        return back()->with('success', 'Export request rejected.');
    }

    public function updateStatus(Request $request, ExportRequest $exportRequest)
    {
        $data = $request->validate([
            'status' => 'required|in:under_review,approved,in_transit,out_for_delivery,delivered,cancelled',
            'location' => 'required|string|max:200',
            'description' => 'required|string|max:500',
        ]);

        $exportRequest->update(['status' => $data['status']]);

        ShipmentTracking::create([
            'export_request_id' => $exportRequest->id,
            'status' => $data['status'],
            'location' => $data['location'],
            'description' => $data['description'],
            'updated_by' => auth()->id(),
        ]);

        if ($data['status'] === 'delivered') {
            $exportRequest->update(['delivered_at' => now()]);
        }
        if ($data['status'] === 'in_transit') {
            $exportRequest->update(['dispatched_at' => now()]);
        }

        NotificationService::send(
            $exportRequest->user_id,
            'Shipment Status Updated',
            "Your shipment #{$exportRequest->tracking_no} status: ".ucfirst(str_replace('_', ' ', $data['status'])),
            'info',
            route('customer.export-requests.show', $exportRequest)
        );

        return back()->with('success', 'Shipment status updated.');
    }
}
