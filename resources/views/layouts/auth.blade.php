<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dak Ghar Export Portal')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-body">
    <div class="auth-bg">
        <div class="auth-orb auth-orb-1"></div>
        <div class="auth-orb auth-orb-2"></div>
        <div class="auth-orb auth-orb-3"></div>
    </div>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-brand">
                <div class="auth-brand-icon">✉</div>
                <h1 class="auth-brand-name">Dak Ghar</h1>
                <p class="auth-brand-sub">Export &amp; Logistics Portal</p>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
                </div>
            @endif
            @yield('content')
        </div>
        <p class="auth-footer">© {{ date('Y') }} India Post — Dak Ghar Export Portal. All rights reserved.</p>
    </div>
</body>
</html>
