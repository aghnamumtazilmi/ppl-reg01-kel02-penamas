<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\PenyaluranController;
use App\Http\Controllers\StokBantuanController;
use App\Http\Controllers\StokMutasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - PENAMAS (Base Layout & Navigation)
|--------------------------------------------------------------------------
| Template dasar antarmuka, autentikasi sesi, dan integrasi modul
| seluruh anggota kelompok.
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

    // 3. Data Penerima (F-02: Zaki)
    Route::resource('penerima', PenerimaController::class);
    Route::get('/data-penerima', fn() => redirect()->route('penerima.index'))->name('penamas.penerima.index');

    // 4. Paket Bantuan (Placeholder - siap diisi PIC Paket Bantuan)
    Route::get('/paket-bantuan', fn() => view('paket-bantuan.index'))->name('penamas.paket-bantuan.index');

    // 5. Stok Bantuan (F-04: Aghna)
    Route::get('/stok', [StokBantuanController::class, 'index'])->name('stok.index');
    Route::get('/stok/daftar', fn() => redirect()->route('stok.index'))->name('penamas.stok.index');
    Route::get('/stok/create', [StokBantuanController::class, 'create'])->name('stok.create');
    Route::get('/stok/tambah', fn() => redirect()->route('stok.create'))->name('penamas.stok.create');
    Route::post('/stok', [StokBantuanController::class, 'store'])->name('stok.store');
    Route::delete('/stok/{id}', [StokBantuanController::class, 'destroy'])->name('stok.destroy');
    Route::get('/stok-bantuan', fn() => redirect()->route('stok.index'));

    // 6. Riwayat Mutasi Stok (F-06: Helmi Arif Zulfikar)
    Route::get('/stok/mutasi', [StokMutasiController::class, 'index'])->name('penamas.stok.mutasi');
    Route::get('/stok/mutasi/masuk', [StokMutasiController::class, 'create'])->name('stok-mutasi.create');
    Route::post('/stok/mutasi/masuk', [StokMutasiController::class, 'store'])->name('stok-mutasi.store');
    Route::get('/stok/mutasi/keluar', [StokMutasiController::class, 'createKeluar'])->name('stok-mutasi.create-keluar');
    Route::post('/stok/mutasi/keluar', [StokMutasiController::class, 'storeKeluar'])->name('stok-mutasi.store-keluar');
    Route::get('/stok-mutasi', fn() => redirect()->route('penamas.stok.mutasi'))->name('stok-mutasi.index');

    // 7. Rencana Distribusi (Placeholder - siap diisi PIC Rencana Distribusi)
    Route::get('/distribusi', fn() => view('distribusi.index'))->name('penamas.distribusi.index');

    // 8. Penyaluran Bantuan (F-09: Nayaka)
    Route::get('/penyaluran', [PenyaluranController::class, 'index'])->name('penyaluran.index');
    Route::get('/daftar-penyaluran', fn() => redirect()->route('penyaluran.index'))->name('penamas.penyaluran.index');
    Route::get('/penyaluran/{distribusi}', [PenyaluranController::class, 'show'])->name('penyaluran.show');
    Route::post('/penyaluran/{distribusi}/realisasi', [PenyaluranController::class, 'storeRealisasi'])->name('penyaluran.realisasi.store');
    Route::post('/penyaluran/{distribusi}/upload-foto', [PenyaluranController::class, 'uploadFoto'])->name('penyaluran.foto.upload');
    Route::delete('/penyaluran/{distribusi}/hapus-foto', [PenyaluranController::class, 'deleteFoto'])->name('penyaluran.foto.delete');
    Route::get('/penyaluran-bansos', fn() => redirect()->route('penyaluran.index'));

    // 9. Laporan (Placeholder - siap diisi PIC Laporan)
    Route::get('/laporan', fn() => view('laporan.index'))->name('penamas.laporan.index');
});
