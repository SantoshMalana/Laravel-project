@extends('layouts.app')
@section('title', 'Admin Dashboard — Dak Ghar')
@section('page-title', 'Analytics Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-heading">Analytics Overview</h2>
        <p class="page-sub">Platform-wide export logistics statistics.</p>
    </div>
</div>

<div class="stats-grid stats-grid-6">
    <div class="stat-card stat-card-blue"><div class="stat-icon">👥</div><div class="stat-body"><p class="stat-value">{{ $stats['total_users'] }}</p><p class="stat-label">Customers</p></div></div>
    <div class="stat-card stat-card-indigo"><div class="stat-icon">📦</div><div class="stat-body"><p class="stat-value">{{ $stats['total_requests'] }}</p><p class="stat-label">Total Requests</p></div></div>
    <div class="stat-card stat-card-yellow"><div class="stat-icon">⏳</div><div class="stat-body"><p class="stat-value">{{ $stats['pending'] }}</p><p class="stat-label">Pending</p></div></div>
    <div class="stat-card stat-card-purple"><div class="stat-icon">✈</div><div class="stat-body"><p class="stat-value">{{ $stats['in_transit'] }}</p><p class="stat-label">In Transit</p></div></div>
    <div class="stat-card stat-card-green"><div class="stat-icon">✔</div><div class="stat-body"><p class="stat-value">{{ $stats['delivered'] }}</p><p class="stat-label">Delivered</p></div></div>
    <div class="stat-card stat-card-gold"><div class="stat-icon">₹</div><div class="stat-body"><p class="stat-value">{{ number_format($stats['revenue']/100000,1) }}L</p><p class="stat-label">Total Value (INR)</p></div></div>
</div>

<div class="admin-grid">
    <!-- Top Countries -->
    <div class="section-card">
        <h3 class="section-title">🌍 Top Destination Countries</h3>
        <div class="country-bars">
            @php $maxCount = $countryStats->max('count') ?: 1; @endphp
            @foreach($countryStats as $c)
            <div class="country-bar-item">
                <span class="country-name">{{ $c->destination_country }}</span>
                <div class="bar-track">
                    <div class="bar-fill" style="width: {{ ($c->count / $maxCount) * 100 }}%"></div>
                </div>
                <span class="country-count">{{ $c->count }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Requests -->
    <div class="section-card">
        <h3 class="section-title">📋 Recent Requests</h3>
        <div class="table-wrapper">
            <table class="data-table">
                <thead><tr><th>Tracking</th><th>Customer</th><th>Destination</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                    @foreach($recentRequests as $req)
                    <tr>
                        <td><code class="tracking-code">{{ $req->tracking_no }}</code></td>
                        <td>{{ $req->user->name }}</td>
                        <td>{{ $req->destination_country }}</td>
                        <td><span class="badge {{ $req->getStatusBadgeClass() }}">{{ $req->getStatusLabel() }}</span></td>
                        <td>{{ $req->created_at->format('d M') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Monthly Chart -->
<div class="section-card">
    <h3 class="section-title">📈 Monthly Export Requests ({{ date('Y') }})</h3>
    <canvas id="monthlyChart" height="80"></canvas>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const raw = @json($monthlyData);
const labels = raw.map(d => months[parseInt(d.month)-1]);
const data   = raw.map(d => d.count);
new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels,
        datasets: [{
            label: 'Export Requests',
            data,
            backgroundColor: 'rgba(99,102,241,0.7)',
            borderColor: 'rgba(99,102,241,1)',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.05)' } },
            x: { ticks: { color: '#94a3b8' }, grid: { display: false } }
        }
    }
});
</script>
@endsection
@endsection
