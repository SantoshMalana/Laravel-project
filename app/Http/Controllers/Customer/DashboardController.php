<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\ExportRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total' => ExportRequest::where('user_id', $user->id)->count(),
            'pending' => ExportRequest::where('user_id', $user->id)->where('status', 'pending')->count(),
            'in_transit' => ExportRequest::where('user_id', $user->id)->where('status', 'in_transit')->count(),
            'delivered' => ExportRequest::where('user_id', $user->id)->where('status', 'delivered')->count(),
        ];

        $recentRequests = ExportRequest::where('user_id', $user->id)
            ->with('latestTracking')
            ->latest()
            ->take(5)
            ->get();

        $notifications = AppNotification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact('stats', 'recentRequests', 'notifications'));
    }
}
