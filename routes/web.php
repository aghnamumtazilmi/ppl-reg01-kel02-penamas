<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StokBantuanController;

Route::get('/', function () {
    return redirect()->route('stok.index');
});

// PBI-011: Pemantauan Daftar Sisa Stok Barang di Gudang
Route::get('/stok', [StokBantuanController::class, 'index'])->name('stok.index');

// PBI-010: Pencatatan Komoditas Pangan Baru di Gudang
Route::get('/stok/create', [StokBantuanController::class, 'create'])->name('stok.create');
Route::post('/stok', [StokBantuanController::class, 'store'])->name('stok.store');
