@extends('layouts.app')
@section('title', 'Staff Dashboard — Dak Ghar')
@section('page-title', 'Staff Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-heading">Operations Dashboard</h2>
        <p class="page-sub">Review and process incoming export requests.</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card stat-card-yellow">
        <div class="stat-icon">⏳</div>
        <div class="stat-body"><p class="stat-value">{{ $stats['pending'] }}</p><p class="stat-label">Pending</p></div>
    </div>
    <div class="stat-card stat-card-blue">
        <div class="stat-icon">🔍</div>
        <div class="stat-body"><p class="stat-value">{{ $stats['under_review'] }}</p><p class="stat-label">Under Review</p></div>
    </div>
    <div class="stat-card stat-card-indigo">
        <div class="stat-icon">✈</div>
        <div class="stat-body"><p class="stat-value">{{ $stats['in_transit'] }}</p><p class="stat-label">In Transit</p></div>
    </div>
    <div class="stat-card stat-card-green">
        <div class="stat-icon">✔</div>
        <div class="stat-body"><p class="stat-value">{{ $stats['delivered'] }}</p><p class="stat-label">Delivered</p></div>
    </div>
</div>

<div class="section-card">
    <div class="section-header">
        <h3 class="section-title">⚡ Pending Review Queue</h3>
        <a href="{{ route('staff.requests.index') }}" class="btn btn-outline btn-sm">All Requests</a>
    </div>
    @if($pendingRequests->isEmpty())
        <div class="empty-state"><div class="empty-icon">✅</div><p>All caught up! No pending requests.</p></div>
    @else
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr><th>Tracking No.</th><th>Customer</th><th>Destination</th><th>Weight</th><th>Value</th><th>Status</th><th>Submitted</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($pendingRequests as $req)
                <tr>
                    <td><code class="tracking-code">{{ $req->tracking_no }}</code></td>
                    <td>{{ $req->user->name }}<br><small class="text-muted">{{ $req->user->email }}</small></td>
                    <td>{{ $req->destination_country }}</td>
                    <td>{{ $req->weight_kg }} kg</td>
                    <td>{{ $req->currency }} {{ number_format($req->declared_value,2) }}</td>
                    <td><span class="badge {{ $req->getStatusBadgeClass() }}">{{ $req->getStatusLabel() }}</span></td>
                    <td>{{ $req->created_at->format('d M Y') }}</td>
                    <td><a href="{{ route('staff.requests.show', $req) }}" class="btn btn-primary btn-sm">Review →</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
