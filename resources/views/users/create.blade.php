@extends('layouts.app')

@section('page-title', 'Tambah Pengguna Baru')
@section('page-subtitle', 'Daftarkan akun petugas, administrator, atau pimpinan baru ke sistem PENAMAS')

@section('page-actions')
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        <span>Kembali ke Daftar</span>
    </a>
@endsection

@section('content')
<div class="card p-6" style="max-width: 680px; margin: 0 auto; width: 100%;">
    <div style="padding-bottom: 16px; margin-bottom: 22px; border-bottom: 1px solid var(--border);">
        <span class="card-title" style="display: block; font-size: 14px; font-weight: 700; color: var(--text-1);">Formulir Pendaftaran Pengguna</span>
        <p style="font-size: 12px; color: var(--text-3); margin-top: 3px;">Lengkapi data akun untuk memberikan hak akses ke dalam sistem.</p>
    </div>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <!-- Nama Lengkap -->
        <div class="form-group">
            <label for="name" class="form-label">
                Nama Lengkap <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}" 
                   placeholder="Contoh: Riyan Saefuloh" 
                   required
                   class="form-input">
            @error('name')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Alamat Email -->
        <div class="form-group">
            <label for="email" class="form-label">
                Alamat Email <span style="color: #ef4444;">*</span>
            </label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   placeholder="nama@penamas.test" 
                   required
                   class="form-input">
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Peran / Role -->
        <div class="form-group">
            <label for="role" class="form-label">
                Peran / Hak Akses (Role) <span style="color: #ef4444;">*</span>
            </label>
            <select id="role" name="role" class="form-select" required>
                <option value="">-- Pilih Peran Pengguna --</option>
                <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas Lapangan (Penyalur)</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator (Pengelola Sistem & Stok)</option>
                <option value="pimpinan" {{ old('role') == 'pimpinan' ? 'selected' : '' }}>Pimpinan (Persetujuan & Laporan)</option>
            </select>
            @error('role')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Kata Sandi -->
        <div class="form-group">
            <label for="password" class="form-label">
                Kata Sandi <span style="color: #ef4444;">*</span>
            </label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   placeholder="Minimal 8 karakter" 
                   required
                   class="form-input">
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Konfirmasi Kata Sandi -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">
                Konfirmasi Kata Sandi <span style="color: #ef4444;">*</span>
            </label>
            <input type="password" 
                   id="password_confirmation" 
                   name="password_confirmation" 
                   placeholder="Ketik ulang kata sandi" 
                   required
                   class="form-input">
        </div>

        <!-- Tombol Aksi (Rata Kanan: Batal di kiri, Simpan Pengguna di pojok kanan) -->
        <div class="flex items-center gap-3 mt-6" style="padding-top: 10px; justify-content: flex-end;">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <span>Batal</span>
            </a>
            <button type="submit" class="btn btn-primary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                <span>Simpan Pengguna</span>
            </button>
        </div>
    </form>
</div>
@endsection
