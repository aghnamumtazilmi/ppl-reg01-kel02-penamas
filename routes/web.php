<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\PenyaluranController;
use App\Http\Controllers\StokBantuanController;
use App\Http\Controllers\StokMutasiController;

Route::get('/', function () {
    return redirect()->route('stok.index');
});

// Route CRUD Data Penerima Bantuan (F-02: PBI-004, PBI-005, PBI-006)
Route::resource('penerima', PenerimaController::class);

// Route Modul Master Stok Barang di Gudang (F-04: PBI-010, PBI-011, PBI-012)
Route::get('/stok', [StokBantuanController::class, 'index'])->name('stok.index');
Route::get('/stok/create', [StokBantuanController::class, 'create'])->name('stok.create');
Route::post('/stok', [StokBantuanController::class, 'store'])->name('stok.store');
Route::delete('/stok/{id}', [StokBantuanController::class, 'destroy'])->name('stok.destroy');

// Route Mutasi Stok Gudang (F-06: PBI-016, PBI-017, PBI-018)
Route::get('stok-mutasi/keluar/create', [StokMutasiController::class, 'createKeluar'])->name('stok-mutasi.create-keluar');
Route::post('stok-mutasi/keluar', [StokMutasiController::class, 'storeKeluar'])->name('stok-mutasi.store-keluar');
Route::resource('stok-mutasi', StokMutasiController::class);

// Route Modul Penyaluran Bantuan & Bukti Serah Terima (F-09: PBI-025, PBI-026, PBI-027)
Route::get('/penyaluran', [PenyaluranController::class, 'index'])->name('penyaluran.index');
Route::get('/penyaluran/{distribusi}', [PenyaluranController::class, 'show'])->name('penyaluran.show');
Route::post('/penyaluran/{distribusi}/realisasi', [PenyaluranController::class, 'storeRealisasi'])->name('penyaluran.realisasi.store');
Route::post('/penyaluran/{distribusi}/upload-foto', [PenyaluranController::class, 'uploadFoto'])->name('penyaluran.foto.upload');
Route::delete('/penyaluran/{distribusi}/hapus-foto', [PenyaluranController::class, 'deleteFoto'])->name('penyaluran.foto.delete');
