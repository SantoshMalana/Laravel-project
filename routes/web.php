<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\ExportRequestController as CustomerExportController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboard;
use App\Http\Controllers\Staff\ExportRequestController as StaffExportController;
use Illuminate\Support\Facades\Route;

// ─── Home ─────────────────────────────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            default => redirect()->route('customer.dashboard'),
        };
    }

    return view('welcome');
});

// ─── Auth ─────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Customer ─────────────────────────────────────────────────────────────────
Route::prefix('customer')->name('customer.')->middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');
    Route::get('/requests', [CustomerExportController::class, 'index'])->name('export-requests.index');
    Route::get('/requests/new', [CustomerExportController::class, 'create'])->name('export-requests.create');
    Route::post('/requests', [CustomerExportController::class, 'store'])->name('export-requests.store');
    Route::get('/requests/{exportRequest}', [CustomerExportController::class, 'show'])->name('export-requests.show');
});

// ─── Staff ────────────────────────────────────────────────────────────────────
Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:staff,admin'])->group(function () {
    Route::get('/dashboard', [StaffDashboard::class, 'index'])->name('dashboard');
    Route::get('/requests', [StaffExportController::class, 'index'])->name('requests.index');
    Route::get('/requests/{exportRequest}', [StaffExportController::class, 'show'])->name('requests.show');
    Route::post('/requests/{exportRequest}/approve', [StaffExportController::class, 'approve'])->name('requests.approve');
    Route::post('/requests/{exportRequest}/reject', [StaffExportController::class, 'reject'])->name('requests.reject');
    Route::post('/requests/{exportRequest}/status', [StaffExportController::class, 'updateStatus'])->name('requests.update-status');
});

// ─── Admin ────────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class);
});
