@extends('layouts.auth')
@section('title', 'Register — Dak Ghar')
@section('content')
<h2 class="auth-heading">Create Account</h2>
<p class="auth-subheading">Join the Dak Ghar Export Portal</p>

<form action="{{ route('register') }}" method="POST" class="auth-form">
    @csrf
    <div class="form-group">
        <label class="form-label" for="name">Full Name</label>
        <input id="name" type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="Your full name" required>
    </div>
    <div class="form-group">
        <label class="form-label" for="email">Email Address</label>
        <input id="email" type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="you@example.com" required>
    </div>
    <div class="form-group">
        <label class="form-label" for="phone">Phone Number</label>
        <input id="phone" type="text" name="phone" class="form-input" value="{{ old('phone') }}" placeholder="+91-98765-43210">
    </div>
    <div class="form-group">
        <label class="form-label" for="address">Address</label>
        <textarea id="address" name="address" class="form-input form-textarea" placeholder="Your full address">{{ old('address') }}</textarea>
    </div>
    <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input id="password" type="password" name="password" class="form-input" placeholder="Min. 8 characters" required>
    </div>
    <div class="form-group">
        <label class="form-label" for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" placeholder="Repeat password" required>
    </div>
    <button type="submit" class="btn btn-primary btn-full">Create Account →</button>
</form>
<p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
@endsection
