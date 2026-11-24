<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\PaketBantuanController;
use App\Http\Controllers\StokBantuanController;
use App\Http\Controllers\StokMutasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - PENAMAS (Sprint 1 Integration)
|--------------------------------------------------------------------------
| Template antarmuka terpadu Kravio UI, autentikasi sesi, dan integrasi
| seluruh modul anggota kelompok Sprint 1.
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

    // 1. Dashboard (PIC: Edwin Salman Hakim)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('penamas.dashboard');
    Route::get('/ringkasan', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Resource route utama fitur Kelola Pengguna (F-01 - PIC: Riyan Saefuloh)
    Route::resource('users', UserController::class);
    Route::get('/pengguna', [UserController::class, 'index'])->name('penamas.pengguna.index');
    Route::get('/pengguna/create', [UserController::class, 'create'])->name('penamas.pengguna.create');
    Route::post('/pengguna', [UserController::class, 'store'])->name('penamas.pengguna.store');
    Route::get('/pengguna/{user}', [UserController::class, 'show'])->name('penamas.pengguna.show');
    Route::get('/pengguna/{user}/edit', [UserController::class, 'edit'])->name('penamas.pengguna.edit');
    Route::put('/pengguna/{user}', [UserController::class, 'update'])->name('penamas.pengguna.update');
    Route::delete('/pengguna/{user}', [UserController::class, 'destroy'])->name('penamas.pengguna.destroy');

    // 3. Resource route Data Penerima Bantuan (F-02 - PIC: Zaki)
    Route::resource('penerima', PenerimaController::class);
    Route::get('/data-penerima', [PenerimaController::class, 'index'])->name('penamas.penerima.index');

    // 4. Resource route Paket Bantuan (F-03 - PIC: Isaf Khiyar Musyaffa)
    Route::resource('paket-bantuan', PaketBantuanController::class)->names([
        'index' => 'penamas.paket-bantuan.index',
        'create' => 'penamas.paket-bantuan.create',
        'store' => 'penamas.paket-bantuan.store',
        'show' => 'penamas.paket-bantuan.show',
        'edit' => 'penamas.paket-bantuan.edit',
        'update' => 'penamas.paket-bantuan.update',
        'destroy' => 'penamas.paket-bantuan.destroy',
    ]);
    Route::resource('paket', PaketBantuanController::class);

    // 5. Stok Bantuan (F-04: Kelola Stok Barang di Gudang - Aghna Mumtaz Ilmi)
    Route::get('/stok', [StokBantuanController::class, 'index'])->name('penamas.stok.index');
    Route::get('/stok/create', [StokBantuanController::class, 'create'])->name('penamas.stok.create');
    Route::post('/stok', [StokBantuanController::class, 'store'])->name('penamas.stok.store');
    Route::delete('/stok/{id}', [StokBantuanController::class, 'destroy'])->name('penamas.stok.destroy');

    // Aliases kompatibilitas rute stok
    Route::get('/stok-bantuan', fn() => redirect()->route('penamas.stok.index'));
    Route::get('/stok/daftar', fn() => redirect()->route('penamas.stok.index'));
    Route::get('/stok/tambah', fn() => redirect()->route('penamas.stok.create'));
    Route::get('/stok-legacy', [StokBantuanController::class, 'index'])->name('stok.index');
    Route::get('/stok-legacy/create', [StokBantuanController::class, 'create'])->name('stok.create');
    Route::post('/stok-legacy', [StokBantuanController::class, 'store'])->name('stok.store');
    Route::delete('/stok-legacy/{id}', [StokBantuanController::class, 'destroy'])->name('stok.destroy');

    // 6. Riwayat Mutasi Stok (F-05 / F-06 - PIC: Helmi Arif Zulfikar)
    Route::get('/stok/mutasi', [StokMutasiController::class, 'index'])->name('penamas.stok.mutasi');
    Route::get('/stok-mutasi', [StokMutasiController::class, 'index'])->name('stok-mutasi.index');
    Route::get('/stok/mutasi/masuk', [StokMutasiController::class, 'create'])->name('stok-mutasi.create');
    Route::post('/stok/mutasi/masuk', [StokMutasiController::class, 'store'])->name('stok-mutasi.store');
    Route::get('/stok/mutasi/keluar', [StokMutasiController::class, 'createKeluar'])->name('stok-mutasi.create-keluar');
    Route::post('/stok/mutasi/keluar', [StokMutasiController::class, 'storeKeluar'])->name('stok-mutasi.store-keluar');

    // 7. Rencana Distribusi (Placeholder Sprint 1)
    Route::get('/distribusi', fn() => view('distribusi.index'))->name('penamas.distribusi.index');

    // 8. Penyaluran Bantuan (Sprint 2 Placeholder)
    Route::get('/penyaluran', fn() => view('penyaluran.index'))->name('penamas.penyaluran.index');
    Route::get('/daftar-penyaluran', fn() => redirect()->route('penamas.penyaluran.index'))->name('penyaluran.index');

    // 9. Laporan (Placeholder Sprint 1)
    Route::get('/laporan', fn() => view('laporan.index'))->name('penamas.laporan.index');
});
