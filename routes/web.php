<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman Utama (Welcome Page)
Route::get('/', function () {
    return view('welcome');
});

// Dashboard Redirect Berdasarkan Role
Route::get('/dashboard', function () {
    $user = auth()->user();

    // Redirect berdasarkan role
    if ($user->roles()->where('name', 'superadmin')->exists()) {
        return redirect('/superadmin/dashboard');
    } elseif ($user->roles()->where('name', 'admin')->exists()) {
        return redirect('/admin/dashboard');
    } elseif ($user->roles()->where('name', 'student')->exists()) {
        return redirect('/student/dashboard');
    }

    abort(403, 'Unauthorized - Role not found');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes Protected dengan Authentication
Route::middleware('auth')->group(function () {
    // Student Dashboard
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');

    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Superadmin Dashboard
    Route::get('/superadmin/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('superadmin.dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk autentikasi (default dari Laravel Breeze)
require __DIR__ . '/auth.php';