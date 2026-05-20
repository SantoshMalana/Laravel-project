@extends('layouts.app')
@section('title', 'Manage Users — Dak Ghar')
@section('page-title', 'User Management')

@section('content')
<div class="page-header">
    <div><h2 class="page-heading">All Users</h2></div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Add User</a>
</div>

<div class="filter-bar">
    <form method="GET" class="filter-form">
        <input name="search" type="text" class="form-input filter-search" placeholder="Search name or email..." value="{{ request('search') }}">
        <select name="role" class="form-input form-select filter-select">
            <option value="">All Roles</option>
            @foreach(['admin','staff','customer'] as $r)
                <option value="{{ $r }}" {{ request('role')===$r?'selected':'' }}>{{ ucfirst($r) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Reset</a>
    </form>
</div>

<div class="table-wrapper">
    <table class="data-table">
        <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Phone</th><th>Joined</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td><div class="user-row"><div class="user-avatar-sm">{{ strtoupper(substr($user->name,0,1)) }}</div>{{ $user->name }}</div></td>
                <td>{{ $user->email }}</td>
                <td><span class="badge-role badge-role-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                <td>{{ $user->phone ?? '—' }}</td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
                <td class="action-cell">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-ghost btn-sm">Edit</a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination-wrap">{{ $users->withQueryString()->links() }}</div>
@endsection
