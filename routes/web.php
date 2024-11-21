<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Halaman Utama (Welcome Page)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard Redirect Berdasarkan Role
Route::get('/dashboard', function () {
    // Mengambil role pengguna
    $role = Auth::user()->roles->pluck('name')->first();

    // Redirect berdasarkan role
    return match ($role) {
        'superadmin' => redirect()->route('superadmin.dashboard'),
        'admin' => redirect()->route('admin.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        default => abort(403, 'Unauthorized - Role not found')
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes Protected dengan Authentication dan Role-based Dashboards
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Berdasarkan Role
    Route::view('/student/dashboard', 'student.dashboard')->name('student.dashboard');
    Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/superadmin/dashboard', 'superadmin.dashboard')->name('superadmin.dashboard');

    // Profile Management
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

// Route untuk autentikasi (default dari Laravel Breeze)
require __DIR__.'/auth.php';
