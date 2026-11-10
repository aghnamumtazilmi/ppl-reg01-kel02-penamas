@extends('layouts.app')

@section('title', 'Ubah Data Pengguna')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Breadcrumb & Title -->
    <div>
        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700 mb-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar Pengguna
        </a>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Ubah Data & Hak Akses Pengguna</h1>
        <p class="text-sm text-slate-500 mt-1">Perbarui data profil atau sesuaikan peran/hak akses akun pengguna (PBI-002).</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 bg-slate-50 border @error('name') border-rose-300 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                @error('name')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">
                    Alamat Email (Username Login) <span class="text-rose-500">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 bg-slate-50 border @error('email') border-rose-300 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                @error('email')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Selection (PBI-002) -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Ubah Hak Akses / Peran (Role) <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- Petugas -->
                    <label class="relative flex flex-col p-4 border rounded-xl cursor-pointer hover:bg-slate-50 transition border-slate-200 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/50 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500/20">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-semibold text-slate-900">Petugas</span>
                            <input type="radio" name="role" value="petugas" {{ old('role', $user->role) === 'petugas' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 border-slate-300 focus:ring-emerald-500">
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed">Penyaluran lapangan & input bukti fisik serah terima.</p>
                    </label>

                    <!-- Admin -->
                    <label class="relative flex flex-col p-4 border rounded-xl cursor-pointer hover:bg-slate-50 transition border-slate-200 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50/50 has-[:checked]:ring-2 has-[:checked]:ring-indigo-500/20">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-semibold text-slate-900">Administrator</span>
                            <input type="radio" name="role" value="admin" {{ old('role', $user->role) === 'admin' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-slate-300 focus:ring-indigo-500">
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed">Kelola master data, paket bantuan, & draf distribusi.</p>
                    </label>

                    <!-- Pimpinan -->
                    <label class="relative flex flex-col p-4 border rounded-xl cursor-pointer hover:bg-slate-50 transition border-slate-200 has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50/50 has-[:checked]:ring-2 has-[:checked]:ring-purple-500/20">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-semibold text-slate-900">Pimpinan</span>
                            <input type="radio" name="role" value="pimpinan" {{ old('role', $user->role) === 'pimpinan' ? 'checked' : '' }} class="w-4 h-4 text-purple-600 border-slate-300 focus:ring-purple-500">
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed">Persetujuan (*approval*) draf distribusi & pantau laporan.</p>
                    </label>
                </div>
                @error('role')
                    <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Change (Optional) -->
            <div class="pt-4 border-t border-slate-100">
                <div class="mb-3">
                    <p class="text-sm font-semibold text-slate-700">Ubah Kata Sandi (Opsional)</p>
                    <p class="text-xs text-slate-400">Kosongkan jika Anda tidak ingin mengganti kata sandi pengguna ini.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-medium text-slate-600 mb-1">Kata Sandi Baru</label>
                        <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" class="w-full px-4 py-2 bg-slate-50 border @error('password') border-rose-300 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                        @error('password')
                            <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-medium text-slate-600 mb-1">Ulangi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi kata sandi baru" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-sm transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

