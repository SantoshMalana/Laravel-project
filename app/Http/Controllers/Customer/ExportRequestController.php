<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\TrackingHelper;
use App\Http\Controllers\Controller;
use App\Models\ExportRequest;
use App\Models\ShipmentTracking;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ExportRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ExportRequest::where('user_id', auth()->id())->with('latestTracking')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('tracking_no', 'like', '%'.$request->search.'%')
                    ->orWhere('destination_country', 'like', '%'.$request->search.'%')
                    ->orWhere('recipient_name', 'like', '%'.$request->search.'%');
            });
        }

        $requests = $query->paginate(10);

        return view('customer.export-requests.index', compact('requests'));
    }

    public function create()
    {
        return view('customer.export-requests.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'destination_country' => 'required|string|max:100',
            'destination_city' => 'nullable|string|max:100',
            'recipient_name' => 'required|string|max:150',
            'recipient_address' => 'required|string|max:500',
            'recipient_phone' => 'nullable|string|max:25',
            'goods_description' => 'required|string|max:1000',
            'goods_category' => 'required|in:documents,electronics,textiles,handicrafts,food,medicine,others',
            'weight_kg' => 'required|numeric|min:0.001|max:30',
            'declared_value' => 'required|numeric|min:1',
            'currency' => 'required|string|max:10',
            'service_type' => 'required|in:express,standard,economy',
            'notes' => 'nullable|string|max:500',
        ]);

        $data['user_id'] = auth()->id();
        $data['tracking_no'] = TrackingHelper::generate();
        $data['origin'] = 'India';
        $data['status'] = 'pending';

        $exportRequest = ExportRequest::create($data);

        ShipmentTracking::create([
            'export_request_id' => $exportRequest->id,
            'status' => 'pending',
            'location' => 'Origin Post Office',
            'description' => 'Export request submitted. Awaiting staff review.',
            'updated_by' => null,
        ]);

        NotificationService::send(
            auth()->id(),
            'Export Request Submitted',
            "Your export request #{$exportRequest->tracking_no} has been submitted successfully.",
            'success',
            route('customer.export-requests.show', $exportRequest)
        );

        return redirect()->route('customer.export-requests.show', $exportRequest)
            ->with('success', 'Export request submitted successfully! Tracking No: '.$exportRequest->tracking_no);
    }

    public function show(ExportRequest $exportRequest)
    {
        Gate::authorize('view', $exportRequest);
        $exportRequest->load(['trackings.updatedBy', 'documents', 'user']);

        return view('customer.export-requests.show', compact('exportRequest'));
    }
}
