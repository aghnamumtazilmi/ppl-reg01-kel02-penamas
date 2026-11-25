@extends('layouts.app')

@section('page-title', 'Pengelolaan Pengguna')
@section('page-subtitle', 'Kelola akun petugas, pimpinan, dan administrator sistem PENAMAS')

@section('page-actions')
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        <span>Tambah Pengguna</span>
    </a>
@endsection

@section('content')
<!-- Quick Stats Cards (4 Cards) -->
<div class="grid grid-4 mb-4">
    <div class="stat-card">
        <div class="stat-label">
            <span>Total Pengguna</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
        </div>
        <div class="stat-val">{{ $stats['total'] ?? $users->total() }}</div>
        <div class="stat-footer">
            <span>Semua akun terdaftar</span>
            <span class="stat-chip stat-chip-blue">Total</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <span>Administrator</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
        </div>
        <div class="stat-val">{{ $stats['admin'] ?? 0 }}</div>
        <div class="stat-footer">
            <span>Kendali sistem penuh</span>
            <span class="stat-chip stat-chip-blue">Admin</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <span>Petugas Lapangan</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
        </div>
        <div class="stat-val">{{ $stats['petugas'] ?? 0 }}</div>
        <div class="stat-footer">
            <span>Penyalur bantuan pangan</span>
            <span class="stat-chip stat-chip-green">Petugas</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <span>Pimpinan</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
        </div>
        <div class="stat-val">{{ $stats['pimpinan'] ?? 0 }}</div>
        <div class="stat-footer">
            <span>Validasi & pengawasan</span>
            <span class="stat-chip stat-chip-amber">Pimpinan</span>
        </div>
    </div>
</div>

<!-- Data Table Card (dengan Toolbar Pencarian & Filter Terpadu) -->
<div class="card">
    <div class="card-header" style="flex-wrap: wrap; gap: 12px; align-items: center; justify-content: space-between; padding: 12px 16px;">
        <div>
            <span class="card-title" style="font-size: 13.5px; font-weight: 700;">Daftar Pengguna Sistem</span>
            <div style="font-size: 11.5px; color: var(--text-3); margin-top: 2px;">Menampilkan {{ $users->count() }} dari {{ $users->total() }} akun terdaftar</div>
        </div>

        <!-- Form Filter & Pencarian Terpadu -->
        <form method="GET" action="{{ route('users.index') }}" class="flex items-center gap-2" style="margin: 0; flex-wrap: wrap;">
            <div style="width: 240px;">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari berdasarkan nama atau email..." 
                       class="form-input"
                       style="padding: 6px 10px; font-size: 12px;">
            </div>
            <div style="width: 175px;">
                <select name="role" class="form-select" style="padding: 6px 10px; font-size: 12px;">
                    <option value="">Semua Peran / Role</option>
                    <option value="pimpinan" {{ request('role') == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm" style="padding: 6px 12px;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 13px; height: 13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <span>Filter</span>
            </button>
            @if(request()->filled('search') || request()->filled('role'))
                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm" style="padding: 6px 10px;" title="Reset filter">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 13px; height: 13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    <span>Reset</span>
                </a>
            @endif
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Hak Akses / Peran</th>
                    <th>Terdaftar Sejak</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                @php
                    $currentId = auth()->id() ?? ($authUser->id ?? null);
                    $currentEmail = auth()->user()?->email ?? ($authUser->email ?? null);
                    $currentName = auth()->user()?->name ?? ($authUser->name ?? null);
                    
                    $isSelf = ($currentId && $user->id === $currentId) 
                           || ($currentEmail && $user->email === $currentEmail) 
                           || ($currentName && $user->name === $currentName);
                    
                    $isPimpinan = ($user->role === 'pimpinan');
                @endphp
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="user-ava">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            <div>
                                <div style="font-weight: 600; color: var(--text-1); font-size: 13px; display: flex; align-items: center;">
                                    {{ $user->name }}
                                    @if($isSelf)
                                        <span class="badge badge-aktif" style="margin-left: 6px; font-size: 10px;">Anda</span>
                                    @endif
                                </div>
                                <div style="font-size: 11.5px; color: var(--text-3);">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td style="color: var(--text-2); font-size: 12px;">
                        {{ $user->created_at?->format('d M Y, H:i') ?? '-' }}
                    </td>
                    <td style="text-align: right;">
                        <div class="flex items-center justify-between gap-2" style="justify-content: flex-end;">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-secondary btn-xs">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                <span>Edit</span>
                            </a>
                            @if($isSelf)
                                <span class="badge" style="background: var(--surface-2); color: var(--text-3); border: 1px solid var(--border); font-size: 11px; padding: 4px 8px;" title="Akun Anda yang sedang aktif tidak dapat dihapus">Akun Anda</span>
                            @elseif($isPimpinan)
                                <span class="badge" style="background: var(--tag-amber-bg); color: var(--tag-amber-fg); border: 1px solid var(--tag-amber-border); font-size: 11px; padding: 4px 8px;" title="Akun Pimpinan dilindungi sistem dan tidak dapat dihapus">Terproteksi</span>
                            @else
                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengguna {{ $user->name }}?')" style="margin: 0; display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                            <h3>Tidak Ada Pengguna Ditemukan</h3>
                            <p>Data akun pengguna tidak ditemukan sesuai kriteria filter.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="p-4" style="border-top: 1px solid var(--border);">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
