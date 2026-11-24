<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaketBantuanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - PENAMAS (Base Layout & Navigation)
|--------------------------------------------------------------------------
| Template dasar antarmuka, autentikasi sesi, dan navigasi modul.
|*/

// Autentikasi Pengguna (Login & Logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman Utama / Root Redirect
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('penamas.paket-bantuan.index')
        : redirect()->route('login');
});

// Seluruh Menu Aplikasi (Dilindungi Autentikasi)
Route::middleware('auth')->group(function () {
    // 1. Dashboard (Placeholder)
    Route::get('/dashboard', fn() => view('dashboard'))->name('penamas.dashboard');

    // 2. Pengguna (Placeholder - siap diisi PIC Kelola Pengguna)
    Route::get('/pengguna', fn() => view('pengguna.index'))->name('penamas.pengguna.index');

    // 3. Data Penerima (Placeholder - siap diisi PIC Penerima)
    Route::get('/penerima', fn() => view('penerima.index'))->name('penamas.penerima.index');

    // 4. Paket Bantuan (F-03 - PIC: Isaf Khiyar Musyaffa)
    Route::resource('paket-bantuan', PaketBantuanController::class)->names([
        'index' => 'penamas.paket-bantuan.index',
        'create' => 'penamas.paket-bantuan.create',
        'store' => 'penamas.paket-bantuan.store',
        'show' => 'penamas.paket-bantuan.show',
        'edit' => 'penamas.paket-bantuan.edit',
        'update' => 'penamas.paket-bantuan.update',
        'destroy' => 'penamas.paket-bantuan.destroy',
    ]);
    Route::resource('paket', PaketBantuanController::class); // Alias link singkat

    // 5. Stok Bantuan (Placeholder - siap diisi PIC Stok Bantuan)
    Route::get('/stok', fn() => view('stok.index'))->name('penamas.stok.index');

    // 6. Riwayat Mutasi Stok (Placeholder - siap diisi PIC Riwayat Mutasi)
    Route::get('/stok/mutasi', fn() => view('stok.mutasi'))->name('penamas.stok.mutasi');

    // 7. Rencana Distribusi (Placeholder - siap diisi PIC Rencana Distribusi)
    Route::get('/distribusi', fn() => view('distribusi.index'))->name('penamas.distribusi.index');

    // 8. Penyaluran Bantuan (Placeholder - siap diisi PIC Penyaluran)
    Route::get('/penyaluran', fn() => view('penyaluran.index'))->name('penamas.penyaluran.index');

    // 9. Laporan (Placeholder - siap diisi PIC Laporan)
    Route::get('/laporan', fn() => view('laporan.index'))->name('penamas.laporan.index');
});
