@extends('layouts.app')
@section('title', 'My Shipments — Dak Ghar')
@section('page-title', 'My Shipments')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-heading">My Shipments</h2>
        <p class="page-sub">Track all your export requests in one place.</p>
    </div>
    <a href="{{ route('customer.export-requests.create') }}" class="btn btn-primary">+ New Export</a>
</div>

<!-- Filters -->
<div class="filter-bar">
    <form method="GET" class="filter-form">
        <input name="search" type="text" class="form-input filter-search" placeholder="Search tracking, country, recipient..." value="{{ request('search') }}">
        <select name="status" class="form-input form-select filter-select">
            <option value="">All Status</option>
            @foreach(['pending','under_review','approved','in_transit','out_for_delivery','delivered','rejected','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('customer.export-requests.index') }}" class="btn btn-outline">Reset</a>
    </form>
</div>

@if($requests->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">📭</div>
        <h3>No shipments found</h3>
        <p>Try a different filter or <a href="{{ route('customer.export-requests.create') }}">create a new export</a>.</p>
    </div>
@else
<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>Tracking No.</th>
                <th>Destination</th>
                <th>Recipient</th>
                <th>Weight</th>
                <th>Value</th>
                <th>Service</th>
                <th>Status</th>
                <th>Submitted</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $req)
            <tr>
                <td><code class="tracking-code">{{ $req->tracking_no }}</code></td>
                <td>{{ $req->destination_country }}<br><small class="text-muted">{{ $req->destination_city }}</small></td>
                <td>{{ $req->recipient_name }}</td>
                <td>{{ $req->weight_kg }} kg</td>
                <td>{{ $req->currency }} {{ number_format($req->declared_value, 2) }}</td>
                <td><span class="tag tag-{{ $req->service_type }}">{{ ucfirst($req->service_type) }}</span></td>
                <td><span class="badge {{ $req->getStatusBadgeClass() }}">{{ $req->getStatusLabel() }}</span></td>
                <td>{{ $req->created_at->format('d M Y') }}</td>
                <td><a href="{{ route('customer.export-requests.show', $req) }}" class="btn btn-ghost btn-sm">View →</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pagination-wrap">{{ $requests->withQueryString()->links() }}</div>
@endif
@endsection
