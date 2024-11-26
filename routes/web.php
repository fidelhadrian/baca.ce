<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Root Route (Welcome Page)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Public Registration Routes
Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);

// Dashboard Route with Role-based Redirection
Route::get('/dashboard', function () {
    $user = Auth::user();

    // Check if a user is authenticated
    if (!$user) {
        return redirect()->route('login');
    }

    switch ($user->role->name) {
        case 'superadmin':
            return redirect()->route('superadmin.dashboard');
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'student':
            return redirect()->route('student.dashboard');
        default:
            abort(403, 'Unauthorized');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes (Auth Middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Superadmin Routes
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('1_superadmin.dashboard');
    })->name('dashboard');
    // Add superadmin specific routes here
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('2_admin.dashboard');
    })->name('dashboard');
    // Add admin specific routes here
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', function () {
        return view('3_student.dashboard');
    })->name('dashboard');
    Route::get('/books', function () {
        return view('student.books.index'); // Assuming you have a view for listing books
    })->name('books.index');
    // Add student specific routes here
});

// Visitor Attendance Route (POST Request for barcode scan)
Route::post('/visitors/store', [VisitorController::class, 'store'])->name('visitors.store');

// Include Authentication Routes
require __DIR__.'/auth.php';
