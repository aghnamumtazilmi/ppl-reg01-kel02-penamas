<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Halaman Ringkasan (Dashboard) - F-05 (PIC: Edwin Salman Hakim)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);
