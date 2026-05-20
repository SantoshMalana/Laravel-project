<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ExportRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending' => ExportRequest::where('status', 'pending')->count(),
            'under_review' => ExportRequest::where('status', 'under_review')->count(),
            'in_transit' => ExportRequest::where('status', 'in_transit')->count(),
            'delivered' => ExportRequest::where('status', 'delivered')->count(),
        ];

        $pendingRequests = ExportRequest::with('user')
            ->whereIn('status', ['pending', 'under_review'])
            ->latest()
            ->take(10)
            ->get();

        return view('staff.dashboard', compact('stats', 'pendingRequests'));
    }
}
