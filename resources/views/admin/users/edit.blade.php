@extends('layouts.app')
@section('title', 'Edit User — Dak Ghar')
@section('page-title', 'Edit User')
@section('content')
<div class="page-header">
    <h2 class="page-heading">Edit User: {{ $user->name }}</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">← Back</a>
</div>
<div class="form-card">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Full Name *</label>
                <input name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email *</label>
                <input name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required>
            </div>
        </div>
        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Role *</label>
                <select name="role" class="form-input form-select" required>
                    @foreach(['customer','staff','admin'] as $r)
                        <option value="{{ $r }}" {{ old('role',$user->role)===$r?'selected':'' }}>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Phone</label>
                <input name="phone" type="text" class="form-input" value="{{ old('phone', $user->phone) }}">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-input form-textarea">{{ old('address', $user->address) }}</textarea>
        </div>
        <div class="form-actions">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>
@endsection
