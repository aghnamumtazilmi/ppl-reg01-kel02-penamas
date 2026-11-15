<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\PenyaluranController;

Route::get('/', function () {
    return redirect()->route('penerima.index');
});

// Route CRUD Data Penerima Bantuan (F-02: PBI-004, PBI-005, PBI-006)
Route::resource('penerima', PenerimaController::class);

// Route Modul Penyaluran Bantuan & Bukti Serah Terima (F-09: PBI-025, PBI-026, PBI-027)
Route::get('/penyaluran', [PenyaluranController::class, 'index'])->name('penyaluran.index');
Route::get('/penyaluran/{distribusi}', [PenyaluranController::class, 'show'])->name('penyaluran.show');