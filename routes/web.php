<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Redirect halaman utama ke daftar kelola akun pengguna
Route::get('/', function () {
    return redirect()->route('users.index');
});

// Resource routes untuk Kelola Akun Pengguna (F-01: PBI-001, PBI-002, PBI-003)
Route::resource('users', UserController::class);
