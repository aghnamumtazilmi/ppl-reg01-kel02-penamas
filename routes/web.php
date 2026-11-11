<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenerimaController;

Route::get('/', function () {
    return redirect()->route('penerima.create');
});

// Route CRUD Data Penerima Bantuan (F-02: PBI-004, PBI-005, PBI-006)
Route::resource('penerima', PenerimaController::class);