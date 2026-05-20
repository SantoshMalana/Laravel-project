<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dak Ghar Export Portal — Streamline your international shipments with India Post">
    <title>@yield('title', 'Dak Ghar Export Portal')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="app-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">✉</div>
            <div class="brand-text">
                <span class="brand-name">Dak Ghar</span>
                <span class="brand-sub">Export Portal</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            @if(auth()->user()->isCustomer())
                <div class="nav-group-label">Main</div>
                <a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">⊞</span> Dashboard
                </a>
                <a href="{{ route('customer.export-requests.index') }}" class="nav-link {{ request()->routeIs('customer.export-requests.*') ? 'active' : '' }}">
                    <span class="nav-icon">📦</span> My Shipments
                </a>
                <a href="{{ route('customer.export-requests.create') }}" class="nav-link {{ request()->routeIs('customer.export-requests.create') ? 'active' : '' }}">
                    <span class="nav-icon">＋</span> New Export
                </a>
            @elseif(auth()->user()->isStaff() || auth()->user()->isAdmin())
                <div class="nav-group-label">Operations</div>
                <a href="{{ route('staff.dashboard') }}" class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">⊞</span> Dashboard
                </a>
                <a href="{{ route('staff.requests.index') }}" class="nav-link {{ request()->routeIs('staff.requests.*') ? 'active' : '' }}">
                    <span class="nav-icon">📋</span> All Requests
                </a>
            @endif

            @if(auth()->user()->isAdmin())
                <div class="nav-group-label">Administration</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">📊</span> Analytics
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span class="nav-icon">👥</span> Users
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-details">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="user-role badge-role-{{ auth()->user()->role }}">{{ ucfirst(auth()->user()->role) }}</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn" title="Logout">⏻</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <header class="topbar">
            <button class="menu-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">☰</button>
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            <div class="topbar-right">
                <span class="topbar-time" id="topbar-clock"></span>
            </div>
        </header>

        <main class="page-content">
            @if(session('success'))
                <div class="alert alert-success">✔ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">✖ {{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script>
    function tick() {
        const el = document.getElementById('topbar-clock');
        if (el) el.textContent = new Date().toLocaleTimeString('en-IN', {hour:'2-digit',minute:'2-digit'});
    }
    tick(); setInterval(tick, 1000);
</script>
@yield('scripts')
</body>
</html>
