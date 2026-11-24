<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\PaketBantuanController;
use App\Http\Controllers\StokBantuanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - PENAMAS (Sprint 1 Integration)
|--------------------------------------------------------------------------
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
    Route::get('/pengguna', [UserController::class, 'index'])->name('penamas.pengguna.index');
    Route::get('/pengguna/create', [UserController::class, 'create'])->name('penamas.pengguna.create');
    Route::post('/pengguna', [UserController::class, 'store'])->name('penamas.pengguna.store');
    Route::get('/pengguna/{user}', [UserController::class, 'show'])->name('penamas.pengguna.show');
    Route::get('/pengguna/{user}/edit', [UserController::class, 'edit'])->name('penamas.pengguna.edit');
    Route::put('/pengguna/{user}', [UserController::class, 'update'])->name('penamas.pengguna.update');
    Route::delete('/pengguna/{user}', [UserController::class, 'destroy'])->name('penamas.pengguna.destroy');

    // 3. Resource route Data Penerima Bantuan (F-02: PBI-004, PBI-005, PBI-006)
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
    Route::resource('paket', PaketBantuanController::class); // Alias link singkat

    // 5. Resource route Stok Barang di Gudang (F-04 - PBI-010, PBI-011, PBI-012)
    Route::get('/stok', [StokBantuanController::class, 'index'])->name('stok.index');
    Route::get('/stok-bantuan', [StokBantuanController::class, 'index'])->name('penamas.stok.index');
    Route::get('/stok/create', [StokBantuanController::class, 'create'])->name('stok.create');
    Route::post('/stok', [StokBantuanController::class, 'store'])->name('stok.store');
    Route::delete('/stok/{id}', [StokBantuanController::class, 'destroy'])->name('stok.destroy');

    // 6. Riwayat Mutasi Stok (Placeholder anggota kelompok)
    Route::get('/stok/mutasi', fn() => view('stok.mutasi'))->name('penamas.stok.mutasi');

    // 7. Rencana Distribusi (Placeholder anggota kelompok)
    Route::get('/distribusi', fn() => view('distribusi.index'))->name('penamas.distribusi.index');

    // 8. Penyaluran Bantuan (Placeholder anggota kelompok)
    Route::get('/penyaluran', fn() => view('penyaluran.index'))->name('penamas.penyaluran.index');

    // 9. Laporan (Placeholder anggota kelompok)
    Route::get('/laporan', fn() => view('laporan.index'))->name('penamas.laporan.index');
});
