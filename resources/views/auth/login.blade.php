@extends('layouts.auth')
@section('title', 'Login — Dak Ghar')
@section('content')
<h2 class="auth-heading">Welcome back</h2>
<p class="auth-subheading">Sign in to your account</p>

<form action="{{ route('login') }}" method="POST" class="auth-form">
    @csrf
    <div class="form-group">
        <label class="form-label" for="email">Email Address</label>
        <input id="email" type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
    </div>
    <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input id="password" type="password" name="password" class="form-input" placeholder="••••••••" required>
    </div>
    <div class="form-check-row">
        <label class="form-check">
            <input type="checkbox" name="remember"> Remember me
        </label>
    </div>
    <button type="submit" class="btn btn-primary btn-full">Sign In →</button>
</form>

<p class="auth-switch">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>

<div class="demo-creds">
    <p class="demo-title">Demo Credentials</p>
    <div class="demo-grid">
        <div><strong>Admin</strong><br>admin@dakghar.in</div>
        <div><strong>Staff</strong><br>staff@dakghar.in</div>
        <div><strong>Customer</strong><br>customer@dakghar.in</div>
    </div>
    <p class="demo-pass">Password: <code>password</code></p>
</div>
@endsection
