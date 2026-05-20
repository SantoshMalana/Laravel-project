@extends('layouts.app')
@section('title', 'My Dashboard — Dak Ghar')
@section('page-title', 'My Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-heading">Welcome back, {{ auth()->user()->name }}! 👋</h2>
        <p class="page-sub">Track and manage your international export shipments.</p>
    </div>
    <a href="{{ route('customer.export-requests.create') }}" class="btn btn-primary">+ New Export</a>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card stat-card-blue">
        <div class="stat-icon">📦</div>
        <div class="stat-body">
            <p class="stat-value">{{ $stats['total'] }}</p>
            <p class="stat-label">Total Shipments</p>
        </div>
    </div>
    <div class="stat-card stat-card-yellow">
        <div class="stat-icon">⏳</div>
        <div class="stat-body">
            <p class="stat-value">{{ $stats['pending'] }}</p>
            <p class="stat-label">Pending Review</p>
        </div>
    </div>
    <div class="stat-card stat-card-indigo">
        <div class="stat-icon">✈</div>
        <div class="stat-body">
            <p class="stat-value">{{ $stats['in_transit'] }}</p>
            <p class="stat-label">In Transit</p>
        </div>
    </div>
    <div class="stat-card stat-card-green">
        <div class="stat-icon">✔</div>
        <div class="stat-body">
            <p class="stat-value">{{ $stats['delivered'] }}</p>
            <p class="stat-label">Delivered</p>
        </div>
    </div>
</div>

<!-- Notifications -->
@if($notifications->count())
<div class="section-card">
    <h3 class="section-title">🔔 Notifications</h3>
    <div class="notification-list">
        @foreach($notifications as $notif)
        <div class="notif-item notif-{{ $notif->type }}">
            <div class="notif-body">
                <strong>{{ $notif->title }}</strong>
                <p>{{ $notif->message }}</p>
            </div>
            <span class="notif-time">{{ $notif->created_at->diffForHumans() }}</span>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Recent Shipments -->
<div class="section-card">
    <div class="section-header">
        <h3 class="section-title">Recent Shipments</h3>
        <a href="{{ route('customer.export-requests.index') }}" class="btn btn-outline btn-sm">View All</a>
    </div>
    @if($recentRequests->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <p>No shipments yet. <a href="{{ route('customer.export-requests.create') }}">Create your first export request</a>.</p>
        </div>
    @else
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tracking No.</th>
                    <th>Destination</th>
                    <th>Weight</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentRequests as $req)
                <tr>
                    <td><code class="tracking-code">{{ $req->tracking_no }}</code></td>
                    <td>{{ $req->destination_country }}</td>
                    <td>{{ $req->weight_kg }} kg</td>
                    <td><span class="tag tag-{{ $req->service_type }}">{{ ucfirst($req->service_type) }}</span></td>
                    <td><span class="badge {{ $req->getStatusBadgeClass() }}">{{ $req->getStatusLabel() }}</span></td>
                    <td>{{ $req->created_at->format('d M Y') }}</td>
                    <td><a href="{{ route('customer.export-requests.show', $req) }}" class="btn btn-ghost btn-sm">View →</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
