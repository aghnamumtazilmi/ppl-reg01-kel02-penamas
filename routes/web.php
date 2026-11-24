<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StokBantuanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - PENAMAS (Base Layout & Navigation)
|--------------------------------------------------------------------------
| Template dasar antarmuka, autentikasi sesi, dan placeholder navigasi
| untuk seluruh modul anggota kelompok.
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

    // 2. Pengguna (Placeholder - siap diisi PIC Kelola Pengguna)
    Route::get('/pengguna', fn() => view('pengguna.index'))->name('penamas.pengguna.index');

    // 3. Data Penerima (Placeholder - siap diisi PIC Penerima)
    Route::get('/penerima', fn() => view('penerima.index'))->name('penamas.penerima.index');

    // 4. Paket Bantuan (Placeholder - siap diisi PIC Paket Bantuan)
    Route::get('/paket-bantuan', fn() => view('paket-bantuan.index'))->name('penamas.paket-bantuan.index');

    // 5. Stok Bantuan (F-04: Kelola Stok Barang di Gudang - Aghna Mumtaz Ilmi)
    Route::get('/stok', [StokBantuanController::class, 'index'])->name('penamas.stok.index');
    Route::get('/stok/create', [StokBantuanController::class, 'create'])->name('penamas.stok.create');
    Route::post('/stok', [StokBantuanController::class, 'store'])->name('penamas.stok.store');
    Route::delete('/stok/{id}', [StokBantuanController::class, 'destroy'])->name('penamas.stok.destroy');

    // Aliases kompatibilitas rute legacy
    Route::get('/stok-legacy', fn() => redirect()->route('penamas.stok.index'))->name('stok.index');
    Route::get('/stok-legacy/create', fn() => redirect()->route('penamas.stok.create'))->name('stok.create');

    // 6. Riwayat Mutasi Stok (Placeholder - siap diisi PIC Riwayat Mutasi)
    Route::get('/stok/mutasi', fn() => view('stok.mutasi'))->name('penamas.stok.mutasi');

    // 7. Rencana Distribusi (Placeholder - siap diisi PIC Rencana Distribusi)
    Route::get('/distribusi', fn() => view('distribusi.index'))->name('penamas.distribusi.index');

    // 8. Penyaluran Bantuan (Placeholder - siap diisi PIC Penyaluran)
    Route::get('/penyaluran', fn() => view('penyaluran.index'))->name('penamas.penyaluran.index');

    // 9. Laporan (Placeholder - siap diisi PIC Laporan)
    Route::get('/laporan', fn() => view('laporan.index'))->name('penamas.laporan.index');
});
