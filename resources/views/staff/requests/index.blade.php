@extends('layouts.app')
@section('title', 'Manage Requests — Dak Ghar')
@section('page-title', 'All Export Requests')

@section('content')
<div class="page-header">
    <h2 class="page-heading">All Export Requests</h2>
</div>

<div class="filter-bar">
    <form method="GET" class="filter-form">
        <input name="search" type="text" class="form-input filter-search" placeholder="Search tracking, customer, country..." value="{{ request('search') }}">
        <select name="status" class="form-input form-select filter-select">
            <option value="">All Status</option>
            @foreach(['pending','under_review','approved','in_transit','out_for_delivery','delivered','rejected','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('staff.requests.index') }}" class="btn btn-outline">Reset</a>
    </form>
</div>

<div class="section-card">
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tracking No.</th>
                    <th>Customer</th>
                    <th>Destination</th>
                    <th>Weight</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                <tr>
                    <td><code class="tracking-code">{{ $req->tracking_no }}</code></td>
                    <td>
                        {{ $req->user->name }}
                        <br><small class="text-muted">{{ $req->user->email }}</small>
                    </td>
                    <td>{{ $req->destination_country }}</td>
                    <td>{{ $req->weight_kg }} kg</td>
                    <td><span class="tag tag-{{ $req->service_type }}">{{ ucfirst($req->service_type) }}</span></td>
                    <td><span class="badge {{ $req->getStatusBadgeClass() }}">{{ $req->getStatusLabel() }}</span></td>
                    <td>{{ $req->created_at->format('d M Y') }}</td>
                    <td><a href="{{ route('staff.requests.show', $req) }}" class="btn btn-ghost btn-sm">Review →</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted" style="padding:32px">No requests found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrap">{{ $requests->withQueryString()->links() }}</div>
</div>
@endsection
