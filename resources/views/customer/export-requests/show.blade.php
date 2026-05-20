@extends('layouts.app')
@section('title', 'Shipment #'.$exportRequest->tracking_no.' — Dak Ghar')
@section('page-title', 'Shipment Details')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-heading">Shipment <code class="tracking-code-lg">{{ $exportRequest->tracking_no }}</code></h2>
        <span class="badge {{ $exportRequest->getStatusBadgeClass() }} badge-lg">{{ $exportRequest->getStatusLabel() }}</span>
    </div>
    <a href="{{ route('customer.export-requests.index') }}" class="btn btn-outline">← My Shipments</a>
</div>

<div class="detail-grid">
    <!-- Left Column -->
    <div class="detail-main">
        <!-- Info Cards -->
        <div class="info-card">
            <h3 class="info-card-title">📍 Shipment Details</h3>
            <div class="info-grid">
                <div class="info-item"><span class="info-key">From</span><span class="info-val">{{ $exportRequest->origin }}</span></div>
                <div class="info-item"><span class="info-key">To</span><span class="info-val">{{ $exportRequest->destination_country }}{{ $exportRequest->destination_city ? ', '.$exportRequest->destination_city : '' }}</span></div>
                <div class="info-item"><span class="info-key">Recipient</span><span class="info-val">{{ $exportRequest->recipient_name }}</span></div>
                <div class="info-item"><span class="info-key">Rec. Address</span><span class="info-val">{{ $exportRequest->recipient_address }}</span></div>
                <div class="info-item"><span class="info-key">Rec. Phone</span><span class="info-val">{{ $exportRequest->recipient_phone ?? '—' }}</span></div>
                <div class="info-item"><span class="info-key">Service</span><span class="info-val"><span class="tag tag-{{ $exportRequest->service_type }}">{{ ucfirst($exportRequest->service_type) }}</span></span></div>
            </div>
        </div>

        <div class="info-card">
            <h3 class="info-card-title">📦 Goods Information</h3>
            <div class="info-grid">
                <div class="info-item"><span class="info-key">Description</span><span class="info-val">{{ $exportRequest->goods_description }}</span></div>
                <div class="info-item"><span class="info-key">Category</span><span class="info-val">{{ ucfirst($exportRequest->goods_category) }}</span></div>
                <div class="info-item"><span class="info-key">Weight</span><span class="info-val">{{ $exportRequest->weight_kg }} kg</span></div>
                <div class="info-item"><span class="info-key">Declared Value</span><span class="info-val">{{ $exportRequest->currency }} {{ number_format($exportRequest->declared_value, 2) }}</span></div>
            </div>
            @if($exportRequest->notes)
            <div class="notes-box">
                <strong>Notes:</strong> {{ $exportRequest->notes }}
            </div>
            @endif
            @if($exportRequest->rejection_reason)
            <div class="notes-box notes-danger">
                <strong>Rejection Reason:</strong> {{ $exportRequest->rejection_reason }}
            </div>
            @endif
        </div>

        <!-- Documents -->
        @if($exportRequest->documents->count())
        <div class="info-card">
            <h3 class="info-card-title">📄 Documents</h3>
            <div class="doc-list">
                @foreach($exportRequest->documents as $doc)
                <div class="doc-item">
                    <span class="doc-icon">📑</span>
                    <div class="doc-info">
                        <span class="doc-name">{{ $doc->getTypeLabel() }}</span>
                        <span class="doc-date">Generated {{ $doc->generated_at?->format('d M Y H:i') }}</span>
                    </div>
                    @if($doc->file_path)
                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-outline btn-sm">Download</a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Tracking Timeline -->
    <div class="detail-sidebar">
        <div class="info-card">
            <h3 class="info-card-title">🗺 Tracking Timeline</h3>
            @if($exportRequest->trackings->isEmpty())
                <p class="text-muted">No tracking updates yet.</p>
            @else
            <div class="timeline">
                @foreach($exportRequest->trackings as $track)
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <span class="timeline-status">{{ ucfirst(str_replace('_',' ',$track->status)) }}</span>
                        <span class="timeline-location">📍 {{ $track->location }}</span>
                        <p class="timeline-desc">{{ $track->description }}</p>
                        <span class="timeline-time">{{ $track->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="info-card">
            <h3 class="info-card-title">📅 Key Dates</h3>
            <div class="date-list">
                <div class="date-item"><span>Submitted</span><strong>{{ $exportRequest->created_at->format('d M Y') }}</strong></div>
                @if($exportRequest->approved_at)
                <div class="date-item"><span>Approved</span><strong>{{ $exportRequest->approved_at->format('d M Y') }}</strong></div>
                @endif
                @if($exportRequest->dispatched_at)
                <div class="date-item"><span>Dispatched</span><strong>{{ $exportRequest->dispatched_at->format('d M Y') }}</strong></div>
                @endif
                @if($exportRequest->delivered_at)
                <div class="date-item"><span>Delivered</span><strong>{{ $exportRequest->delivered_at->format('d M Y') }}</strong></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
