@extends('layouts.app')
@section('title', 'Review Request — Dak Ghar')
@section('page-title', 'Review Export Request')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-heading">Review: <code class="tracking-code-lg">{{ $exportRequest->tracking_no }}</code></h2>
        <span class="badge {{ $exportRequest->getStatusBadgeClass() }} badge-lg">{{ $exportRequest->getStatusLabel() }}</span>
    </div>
    <a href="{{ route('staff.requests.index') }}" class="btn btn-outline">← All Requests</a>
</div>

<div class="detail-grid">
    <div class="detail-main">
        <div class="info-card">
            <h3 class="info-card-title">👤 Customer</h3>
            <div class="info-grid">
                <div class="info-item"><span class="info-key">Name</span><span class="info-val">{{ $exportRequest->user->name }}</span></div>
                <div class="info-item"><span class="info-key">Email</span><span class="info-val">{{ $exportRequest->user->email }}</span></div>
                <div class="info-item"><span class="info-key">Phone</span><span class="info-val">{{ $exportRequest->user->phone ?? '—' }}</span></div>
            </div>
        </div>

        <div class="info-card">
            <h3 class="info-card-title">📦 Shipment Details</h3>
            <div class="info-grid">
                <div class="info-item"><span class="info-key">Destination</span><span class="info-val">{{ $exportRequest->destination_country }}, {{ $exportRequest->destination_city }}</span></div>
                <div class="info-item"><span class="info-key">Recipient</span><span class="info-val">{{ $exportRequest->recipient_name }}</span></div>
                <div class="info-item"><span class="info-key">Rec. Address</span><span class="info-val">{{ $exportRequest->recipient_address }}</span></div>
                <div class="info-item"><span class="info-key">Goods</span><span class="info-val">{{ $exportRequest->goods_description }}</span></div>
                <div class="info-item"><span class="info-key">Category</span><span class="info-val">{{ ucfirst($exportRequest->goods_category) }}</span></div>
                <div class="info-item"><span class="info-key">Weight</span><span class="info-val">{{ $exportRequest->weight_kg }} kg</span></div>
                <div class="info-item"><span class="info-key">Declared Value</span><span class="info-val">{{ $exportRequest->currency }} {{ number_format($exportRequest->declared_value,2) }}</span></div>
                <div class="info-item"><span class="info-key">Service</span><span class="info-val"><span class="tag tag-{{ $exportRequest->service_type }}">{{ ucfirst($exportRequest->service_type) }}</span></span></div>
            </div>
            @if($exportRequest->notes)
            <div class="notes-box">Notes: {{ $exportRequest->notes }}</div>
            @endif
        </div>

        @if(in_array($exportRequest->status, ['pending','under_review']))
        <div class="action-card">
            <h3 class="info-card-title">⚙ Actions</h3>
            <div class="action-row">
                <form action="{{ route('staff.requests.approve', $exportRequest) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('Approve this shipment?')">✔ Approve & Generate Documents</button>
                </form>
            </div>
            <div class="reject-form">
                <form action="{{ route('staff.requests.reject', $exportRequest) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Rejection Reason *</label>
                        <textarea name="rejection_reason" class="form-input form-textarea" placeholder="Explain why this request is being rejected..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Reject this shipment?')">✖ Reject Request</button>
                </form>
            </div>
        </div>
        @endif

        @if(!in_array($exportRequest->status, ['delivered','rejected','cancelled']))
        <div class="action-card">
            <h3 class="info-card-title">🚚 Update Shipment Status</h3>
            <form action="{{ route('staff.requests.update-status', $exportRequest) }}" method="POST">
                @csrf
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">New Status</label>
                        <select name="status" class="form-input form-select" required>
                            @foreach(['under_review','approved','in_transit','out_for_delivery','delivered','cancelled'] as $s)
                            <option value="{{ $s }}">{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Current Location</label>
                        <input name="location" type="text" class="form-input" placeholder="e.g. Mumbai Airport" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-input form-textarea" placeholder="Update description..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
        @endif
    </div>

    <div class="detail-sidebar">
        <div class="info-card">
            <h3 class="info-card-title">🗺 Tracking Timeline</h3>
            <div class="timeline">
                @forelse($exportRequest->trackings as $track)
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <span class="timeline-status">{{ ucfirst(str_replace('_',' ',$track->status)) }}</span>
                        <span class="timeline-location">📍 {{ $track->location }}</span>
                        <p class="timeline-desc">{{ $track->description }}</p>
                        <span class="timeline-time">{{ $track->created_at->format('d M Y, H:i') }}</span>
                        @if($track->updatedBy)
                        <span class="timeline-by">by {{ $track->updatedBy->name }}</span>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-muted">No updates yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
