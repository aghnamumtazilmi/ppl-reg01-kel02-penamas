@extends('layouts.app')

@section('title', 'Daftar Pengguna')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Kelola Akun Pengguna</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola data pengguna sistem, penetapan hak akses/role (Pimpinan, Admin, Petugas), dan status akun.</p>
        </div>
        <div>
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengguna Baru
            </a>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('users.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <!-- Search -->
            <div class="sm:col-span-7">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email pengguna..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                </div>
            </div>

            <!-- Role Filter -->
            <div class="sm:col-span-3">
                <select name="role" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition text-slate-700">
                    <option value="">Semua Peran (Role)</option>
                    <option value="pimpinan" {{ request('role') === 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="petugas" {{ request('role') === 'petugas' ? 'selected' : '' }}>Petugas Lapangan</option>
                </select>
            </div>

            <!-- Submit Button & Reset -->
            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full py-2 px-3 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-medium text-sm transition">
                    Cari
                </button>
                @if (request()->hasAny(['search', 'role']))
                    <a href="{{ route('users.index') }}" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition" title="Reset filter">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 font-semibold border-b border-slate-200 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6">Pengguna</th>
                        <th class="py-3.5 px-4">Hak Akses (Role)</th>
                        <th class="py-3.5 px-4 hidden md:table-cell">Terdaftar Sejak</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-50/70 transition">
                            <!-- User info -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white text-sm
                                        @if($user->role === 'pimpinan') bg-purple-600
                                        @elseif($user->role === 'admin') bg-indigo-600
                                        @else bg-emerald-600 @endif shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900 leading-snug">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Role Badge -->
                            <td class="py-4 px-4">
                                @if ($user->role === 'pimpinan')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                        Pimpinan
                                    </span>
                                @elseif ($user->role === 'admin')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                        Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Petugas Lapangan
                                    </span>
                                @endif
                            </td>

                            <!-- Created date -->
                            <td class="py-4 px-4 text-xs text-slate-500 hidden md:table-cell">
                                {{ $user->created_at ? $user->created_at->isoFormat('D MMMM Y') : '-' }}
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4 sm:px-6 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Edit Button (PBI-002) -->
                                    <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        Ubah Data
                                    </a>

                                    <!-- Delete Button (PBI-003) -->
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengguna {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-rose-700 bg-rose-50 hover:bg-rose-100 transition">
                                            <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center">
                                <div class="max-w-sm mx-auto text-slate-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="font-medium text-slate-600">Belum ada data pengguna</p>
                                    <p class="text-xs text-slate-400 mt-1">Tidak ditemukan pengguna yang cocok dengan kriteria pencarian.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

