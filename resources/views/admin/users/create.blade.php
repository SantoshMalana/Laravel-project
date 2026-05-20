@extends('layouts.app')
@section('title', 'Create User — Dak Ghar')
@section('page-title', 'Create User')
@section('content')
<div class="page-header">
    <h2 class="page-heading">Create New User</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">← Back</a>
</div>
<div class="form-card">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Full Name *</label>
                <input name="name" type="text" class="form-input" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email *</label>
                <input name="email" type="email" class="form-input" value="{{ old('email') }}" required>
            </div>
        </div>
        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Role *</label>
                <select name="role" class="form-input form-select" required>
                    @foreach(['customer','staff','admin'] as $r)
                        <option value="{{ $r }}" {{ old('role')===$r?'selected':'' }}>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Phone</label>
                <input name="phone" type="text" class="form-input" value="{{ old('phone') }}">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-input form-textarea">{{ old('address') }}</textarea>
        </div>
        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Password *</label>
                <input name="password" type="password" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Confirm Password *</label>
                <input name="password_confirmation" type="password" class="form-input" required>
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Create User</button>
        </div>
    </form>
</div>
@endsection
