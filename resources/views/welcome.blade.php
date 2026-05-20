<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dak Ghar — Export & Logistics Portal</title>
    <meta name="description" content="India Post Dak Ghar Export Portal — Streamline your international shipments">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .hero{min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:40px;position:relative;overflow:hidden;background:#0f172a}
        .hero-orb{position:absolute;border-radius:50%;filter:blur(100px);opacity:.25;pointer-events:none}
        .hero-orb-1{width:500px;height:500px;background:#6366f1;top:-150px;left:-150px;animation:float1 10s ease-in-out infinite}
        .hero-orb-2{width:400px;height:400px;background:#f59e0b;bottom:-120px;right:-120px;animation:float2 12s ease-in-out infinite}
        @keyframes float1{0%,100%{transform:translate(0,0)}50%{transform:translate(40px,40px)}}
        @keyframes float2{0%,100%{transform:translate(0,0)}50%{transform:translate(-30px,-30px)}}
        .hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(99,102,241,.15);border:1px solid rgba(99,102,241,.3);border-radius:30px;padding:6px 16px;font-size:.8rem;font-weight:600;color:#a5b4fc;margin-bottom:24px}
        .hero-title{font-size:3.5rem;font-weight:800;line-height:1.1;margin-bottom:16px;max-width:700px}
        .hero-title span{background:linear-gradient(135deg,#f59e0b,#6366f1);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
        .hero-sub{color:#94a3b8;font-size:1.1rem;max-width:500px;line-height:1.7;margin-bottom:36px}
        .hero-btns{display:flex;gap:16px;flex-wrap:wrap;justify-content:center;margin-bottom:60px}
        .features{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;max-width:900px;width:100%;position:relative;z-index:1}
        .feature-card{background:rgba(30,41,59,.7);backdrop-filter:blur(10px);border:1px solid rgba(51,65,85,.8);border-radius:16px;padding:24px;text-align:left}
        .feature-icon{font-size:2rem;margin-bottom:12px;display:block}
        .feature-title{font-weight:700;margin-bottom:6px}
        .feature-desc{color:#94a3b8;font-size:.875rem;line-height:1.6}
        @media(max-width:700px){.hero-title{font-size:2.2rem}.features{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="hero">
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>

    <div class="hero-badge">✉ India Post — Official Export Portal</div>

    <h1 class="hero-title">
        Dak Ghar<br><span>Export & Logistics</span>
    </h1>

    <p class="hero-sub">
        The official digital platform for managing international export shipments through India Post. Fast, secure, and paperless.
    </p>

    <div class="hero-btns">
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard →</a>
            @elseif(auth()->user()->isStaff())
                <a href="{{ route('staff.dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard →</a>
            @else
                <a href="{{ route('customer.dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard →</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Sign In →</a>
            <a href="{{ route('register') }}" class="btn btn-outline btn-lg">Register</a>
        @endauth
    </div>

    <div class="features">
        <div class="feature-card">
            <span class="feature-icon">📦</span>
            <h3 class="feature-title">Export Requests</h3>
            <p class="feature-desc">Submit and manage international export requests with full documentation support.</p>
        </div>
        <div class="feature-card">
            <span class="feature-icon">📡</span>
            <h3 class="feature-title">Live Tracking</h3>
            <p class="feature-desc">Real-time shipment status updates with detailed timeline from origin to destination.</p>
        </div>
        <div class="feature-card">
            <span class="feature-icon">📄</span>
            <h3 class="feature-title">Auto Documents</h3>
            <p class="feature-desc">Auto-generate customs invoices, manifests, and packing lists on approval.</p>
        </div>
    </div>
</div>
</body>
</html>
