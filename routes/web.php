<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - PENAMAS
|--------------------------------------------------------------------------
| Fitur F-01: Kelola Akun Pengguna (Sprint 1)
| PIC: Riyan Saefuloh
|*/

// Autentikasi Pengguna (Login & Logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman Utama / Root Redirect
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('penamas.dashboard')
        : redirect()->route('login');
});

// Seluruh Menu Aplikasi (Dilindungi Autentikasi)
Route::middleware('auth')->group(function () {
    // 1. Dashboard
    Route::get('/dashboard', fn() => view('dashboard'))->name('penamas.dashboard');

    // 2. Resource route utama fitur Kelola Pengguna (PIC: Riyan Saefuloh)
    Route::resource('users', UserController::class);

    // Alias route penamas.pengguna.* agar kompatibel dengan layout & navigasi
    Route::get('/pengguna', [UserController::class, 'index'])->name('penamas.pengguna.index');
    Route::get('/pengguna/create', [UserController::class, 'create'])->name('penamas.pengguna.create');
    Route::post('/pengguna', [UserController::class, 'store'])->name('penamas.pengguna.store');
    Route::get('/pengguna/{user}', [UserController::class, 'show'])->name('penamas.pengguna.show');
    Route::get('/pengguna/{user}/edit', [UserController::class, 'edit'])->name('penamas.pengguna.edit');
    Route::put('/pengguna/{user}', [UserController::class, 'update'])->name('penamas.pengguna.update');
    Route::delete('/pengguna/{user}', [UserController::class, 'destroy'])->name('penamas.pengguna.destroy');

    // 3. Data Penerima (Placeholder anggota kelompok)
    Route::get('/penerima', fn() => view('penerima.index'))->name('penamas.penerima.index');

    // 4. Paket Bantuan (Placeholder anggota kelompok)
    Route::get('/paket-bantuan', fn() => view('paket-bantuan.index'))->name('penamas.paket-bantuan.index');

    // 5. Stok Bantuan (Placeholder anggota kelompok)
    Route::get('/stok', fn() => view('stok.index'))->name('penamas.stok.index');

    // 6. Riwayat Mutasi Stok (Placeholder anggota kelompok)
    Route::get('/stok/mutasi', fn() => view('stok.mutasi'))->name('penamas.stok.mutasi');

    // 7. Rencana Distribusi (Placeholder anggota kelompok)
    Route::get('/distribusi', fn() => view('distribusi.index'))->name('penamas.distribusi.index');

    // 8. Penyaluran Bantuan (Placeholder anggota kelompok)
    Route::get('/penyaluran', fn() => view('penyaluran.index'))->name('penamas.penyaluran.index');

    // 9. Laporan (Placeholder anggota kelompok)
    Route::get('/laporan', fn() => view('laporan.index'))->name('penamas.laporan.index');
});
