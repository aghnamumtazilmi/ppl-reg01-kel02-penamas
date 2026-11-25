<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - PENAMAS
|--------------------------------------------------------------------------
| Fitur F-01: Kelola Akun Pengguna (Sprint 1)
| PIC: Riyan Saefuloh
|
| PBI-001: Register & Role (POST /api/users)
| PBI-002: Ubah Data & Hak Akses (PUT /api/users/{id})
| PBI-003: Hapus Akun (DELETE /api/users/{id})
| Tambahan:
| - Daftar Pengguna + Filter & Search (GET /api/users)
| - Detail Pengguna (GET /api/users/{id})
|--------------------------------------------------------------------------
*/

Route::apiResource('users', UserController::class);

