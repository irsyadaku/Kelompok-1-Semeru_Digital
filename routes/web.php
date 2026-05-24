<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('HalamanUtama');
});
Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/berita/detail/{id}', [BeritaController::class, 'show']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Tambahkan ini
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

// Dashboard Pendaki
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Dashboard Admin
Route::get('/admin/dashboard', [AdminController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');
