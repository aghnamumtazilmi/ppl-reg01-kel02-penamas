<?php

use App\Http\Controllers\PaketBantuanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('paket.index');
});

// Fitur F-03: Kelola Paket Bantuan (PIC: Isaf Khiyar Musyaffa)
Route::resource('paket', PaketBantuanController::class);
