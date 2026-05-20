@extends('layouts.app')
@section('title', 'New Export Request — Dak Ghar')
@section('page-title', 'New Export Request')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-heading">New Export Request</h2>
        <p class="page-sub">Fill in the details below to submit your shipment.</p>
    </div>
    <a href="{{ route('customer.export-requests.index') }}" class="btn btn-outline">← Back</a>
</div>

<div class="form-card">
    <form action="{{ route('customer.export-requests.store') }}" method="POST">
        @csrf

        <div class="form-section">
            <h3 class="form-section-title">📍 Destination Details</h3>
            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label" for="destination_country">Destination Country *</label>
                    <input id="destination_country" name="destination_country" type="text" class="form-input" value="{{ old('destination_country') }}" placeholder="e.g. United Kingdom" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="destination_city">Destination City</label>
                    <input id="destination_city" name="destination_city" type="text" class="form-input" value="{{ old('destination_city') }}" placeholder="e.g. London">
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">👤 Recipient Details</h3>
            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label" for="recipient_name">Recipient Name *</label>
                    <input id="recipient_name" name="recipient_name" type="text" class="form-input" value="{{ old('recipient_name') }}" placeholder="Full name" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="recipient_phone">Recipient Phone</label>
                    <input id="recipient_phone" name="recipient_phone" type="text" class="form-input" value="{{ old('recipient_phone') }}" placeholder="+44-...">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="recipient_address">Recipient Address *</label>
                <textarea id="recipient_address" name="recipient_address" class="form-input form-textarea" placeholder="Full delivery address" required>{{ old('recipient_address') }}</textarea>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">📦 Goods Details</h3>
            <div class="form-group">
                <label class="form-label" for="goods_description">Goods Description *</label>
                <textarea id="goods_description" name="goods_description" class="form-input form-textarea" placeholder="Describe the goods in detail" required>{{ old('goods_description') }}</textarea>
            </div>
            <div class="form-row-3">
                <div class="form-group">
                    <label class="form-label" for="goods_category">Category *</label>
                    <select id="goods_category" name="goods_category" class="form-input form-select" required>
                        <option value="">Select...</option>
                        @foreach(['documents','electronics','textiles','handicrafts','food','medicine','others'] as $cat)
                            <option value="{{ $cat }}" {{ old('goods_category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="weight_kg">Weight (kg) *</label>
                    <input id="weight_kg" name="weight_kg" type="number" step="0.001" min="0.001" max="30" class="form-input" value="{{ old('weight_kg') }}" placeholder="e.g. 2.500" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="declared_value">Declared Value *</label>
                    <div class="input-prefix-group">
                        <select name="currency" class="form-input form-select-mini">
                            <option value="INR" {{ old('currency','INR')==='INR'?'selected':'' }}>INR</option>
                            <option value="USD" {{ old('currency')==='USD'?'selected':'' }}>USD</option>
                            <option value="EUR" {{ old('currency')==='EUR'?'selected':'' }}>EUR</option>
                            <option value="GBP" {{ old('currency')==='GBP'?'selected':'' }}>GBP</option>
                        </select>
                        <input id="declared_value" name="declared_value" type="number" step="0.01" min="1" class="form-input" value="{{ old('declared_value') }}" placeholder="0.00" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">🚚 Service Type</h3>
            <div class="service-options">
                @foreach([
                    ['express','⚡ Express','1–3 business days','Premium speed'],
                    ['standard','📬 Standard','5–7 business days','Best value'],
                    ['economy','🌿 Economy','10–15 business days','Most affordable'],
                ] as [$val, $label, $days, $desc])
                <label class="service-card {{ old('service_type','standard')===$val ? 'selected' : '' }}">
                    <input type="radio" name="service_type" value="{{ $val }}" {{ old('service_type','standard')===$val ? 'checked' : '' }}>
                    <span class="service-icon">{{ explode(' ', $label)[0] }}</span>
                    <span class="service-name">{{ ltrim(strstr($label, ' ')) }}</span>
                    <span class="service-days">{{ $days }}</span>
                    <span class="service-desc">{{ $desc }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">📝 Additional Notes</h3>
            <div class="form-group">
                <textarea name="notes" class="form-input form-textarea" placeholder="Any special instructions, fragile items, customs notes...">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('customer.export-requests.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit Export Request →</button>
        </div>
    </form>
</div>

@section('scripts')
<script>
document.querySelectorAll('.service-card').forEach(card => {
    card.addEventListener('click', () => {
        document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
    });
});
</script>
@endsection
@endsection
