<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenerimaController;

Route::get('/', function () {
    return redirect()->route('penamas.penerima.index');
});

// Route CRUD Data Penerima Bantuan (F-02: PBI-004, PBI-005, PBI-006)
Route::get('/penerima', [PenerimaController::class, 'index'])->name('penamas.penerima.index');
Route::get('/penerima-index', [PenerimaController::class, 'index'])->name('penerima.index');
Route::resource('penerima', PenerimaController::class)->except(['index']);

// Placeholder routes untuk menu sidebar master layout PENAMAS kelompok
Route::get('/dashboard', fn() => redirect()->route('penamas.penerima.index'))->name('penamas.dashboard');
Route::get('/pengguna', fn() => 'Menu Pengguna (Placeholder)')->name('penamas.pengguna.index');
Route::get('/paket-bantuan', fn() => 'Menu Paket Bantuan (Placeholder)')->name('penamas.paket-bantuan.index');
Route::get('/stok', fn() => 'Menu Stok (Placeholder)')->name('penamas.stok.index');
Route::get('/stok/mutasi', fn() => 'Menu Mutasi (Placeholder)')->name('penamas.stok.mutasi');
Route::get('/distribusi', fn() => 'Menu Distribusi (Placeholder)')->name('penamas.distribusi.index');
Route::get('/penyaluran', fn() => 'Menu Penyaluran (Placeholder)')->name('penamas.penyaluran.index');
Route::get('/laporan', fn() => 'Menu Laporan (Placeholder)')->name('penamas.laporan.index');
Route::post('/logout', fn() => redirect()->route('penamas.penerima.index'))->name('logout');
