<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingTiketController;
use App\Http\Controllers\BeritaController;

// ============================================================
// HALAMAN PUBLIK (semua orang bisa akses)
// ============================================================

Route::get('/', function () {
    return view('HalamanUtama');
});

Route::get('/berita', function () {
    return view('DaftarBerita');
})->name('DaftarBerita');

Route::get('/berita/detail/{id}', [BeritaController::class, 'show'])->name('berita.detail');

Route::get('/alur-booking', function () {
    return view('AlurBooking');
})->name('AlurBooking');

Route::get('/tips', function () {
    return view('Tips');
})->name('Tips');

// ============================================================
// GUEST ONLY (hanya bisa diakses sebelum login)
// ============================================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

// ============================================================
// PENDAKI (wajib login, role: pendaki)
// ============================================================

Route::middleware(['auth', 'role:pendaki'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Booking & Pembayaran
    Route::get('/booking', [BookingTiketController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookingTiketController::class, 'store'])->name('booking.store');
    Route::get('/pembayaran/{id}', [BookingTiketController::class, 'pembayaran'])->name('pembayaran');
    Route::post('/pembayaran/{id}/konfirmasi', [BookingTiketController::class, 'konfirmasiBayar'])->name('pembayaran.konfirmasi');
    Route::get('/pembayaran/{id}/sukses', [BookingTiketController::class, 'sukses'])->name('pembayaran.sukses');
    Route::post('/pembayaran/{id}/upload', [BookingTiketController::class, 'uploadBukti'])->name('pembayaran.upload');

    // Riwayat
    Route::get('/riwayat-transaksi', [BookingTiketController::class, 'riwayat'])->name('riwayat.transaksi');

    // Fitur Hapus/Batalkan Transaksi
    Route::delete('/booking/{id}', [BookingTiketController::class, 'destroy'])->name('booking.destroy');

    // Fitur Profil
    Route::get('/profil', [BookingTiketController::class, 'profile'])->name('profile.index');
    Route::put('/profil', [BookingTiketController::class, 'profileUpdate'])->name('profile.update');
});

// ============================================================
// ADMIN (wajib login, role: admin)
// ============================================================

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/booking', [AdminController::class, 'booking'])->name('booking');
    Route::get('/berita', [AdminController::class, 'berita'])->name('berita');
    Route::get('/tips', [AdminController::class, 'tips'])->name('tips');
    Route::get('/kuota', [AdminController::class, 'kuota'])->name('kuota');

    Route::get('/verifikasi', [AdminController::class, 'daftarVerifikasi'])->name('verifikasi');
    Route::post('/verifikasi/{id}/terima', [AdminController::class, 'terimaPembayaran'])->name('terima');
    Route::post('/verifikasi/{id}/tolak', [AdminController::class, 'tolakPembayaran'])->name('tolak');
});

// ============================================================
// LOGOUT
// ============================================================

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
