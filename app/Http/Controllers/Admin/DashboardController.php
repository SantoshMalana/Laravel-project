<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExportRequest;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'customer')->count(),
            'total_requests' => ExportRequest::count(),
            'in_transit' => ExportRequest::where('status', 'in_transit')->count(),
            'delivered' => ExportRequest::where('status', 'delivered')->count(),
            'pending' => ExportRequest::where('status', 'pending')->count(),
            'revenue' => ExportRequest::whereIn('status', ['approved', 'in_transit', 'out_for_delivery', 'delivered'])->sum('declared_value'),
        ];

        $recentRequests = ExportRequest::with('user')->latest()->take(8)->get();

        $countryStats = ExportRequest::selectRaw('destination_country, COUNT(*) as count')
            ->groupBy('destination_country')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        $monthlyData = ExportRequest::selectRaw("strftime('%m', created_at) as month, COUNT(*) as count")
            ->whereRaw("strftime('%Y', created_at) = ?", [date('Y')])
            ->groupByRaw("strftime('%m', created_at)")
            ->orderByRaw("strftime('%m', created_at)")
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRequests', 'countryStats', 'monthlyData'));
    }
}
