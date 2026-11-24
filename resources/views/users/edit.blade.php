@extends('layouts.app')

@section('page-title', 'Ubah Data Pengguna')
@section('page-subtitle', 'Perbarui informasi profil dan hak akses peran akun pengguna')

@section('page-actions')
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        <span>Kembali ke Daftar</span>
    </a>
@endsection

@section('content')
<div class="card p-6" style="max-width: 680px; margin: 0 auto; width: 100%;">
    <!-- Info Singkat Akun Saat Ini -->
    <div style="display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 8px; background: var(--surface-2); border: 1px solid var(--border); margin-bottom: 20px;">
        <div class="user-ava" style="width: 32px; height: 32px; font-size: 13px;">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <div style="font-size: 11px; color: var(--text-3); text-transform: uppercase; font-weight: 600; letter-spacing: 0.04em;">Sedang Mengubah Akun:</div>
            <div style="font-size: 13px; font-weight: 600; color: var(--text-1);">{{ $user->name }} <span style="font-weight: 400; color: var(--text-2); font-size: 12px;">({{ $user->email }})</span></div>
        </div>
    </div>

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        <!-- Nama Lengkap -->
        <div class="form-group">
            <label for="name" class="form-label">
                Nama Lengkap <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', $user->name) }}" 
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
                   value="{{ old('email', $user->email) }}" 
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
                <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas Lapangan (Penyalur)</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator (Pengelola Sistem & Stok)</option>
                <option value="pimpinan" {{ old('role', $user->role) == 'pimpinan' ? 'selected' : '' }}>Pimpinan (Persetujuan & Laporan)</option>
            </select>
            @error('role')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Kata Sandi Baru -->
        <div class="form-group">
            <label for="password" class="form-label">
                Kata Sandi Baru <span style="color: var(--text-3); font-weight: 400;">(Kosongkan jika tidak ingin mengubah kata sandi)</span>
            </label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   placeholder="Minimal 8 karakter jika diubah" 
                   class="form-input">
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Konfirmasi Kata Sandi Baru -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">
                Konfirmasi Kata Sandi Baru
            </label>
            <input type="password" 
                   id="password_confirmation" 
                   name="password_confirmation" 
                   placeholder="Ulangi kata sandi baru" 
                   class="form-input">
        </div>

        <!-- Tombol Aksi (Rata Kanan: Batal di kiri, Simpan Perubahan di pojok kanan) -->
        <div class="flex items-center gap-3 mt-6" style="padding-top: 10px; justify-content: flex-end;">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <span>Batal</span>
            </a>
            <button type="submit" class="btn btn-primary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
@endsection
