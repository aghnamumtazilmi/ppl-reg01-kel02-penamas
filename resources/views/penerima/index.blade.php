@extends('layouts.app')

@section('page-title', 'Data Penerima Bantuan (KPM)')
@section('page-subtitle', 'Daftar Keluarga Penerima Manfaat dikelompokkan berdasarkan wilayah kecamatan')

@section('page-actions')
    <a href="{{ route('penerima.create') }}" class="btn btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>Tambah Penerima Baru</span>
    </a>
@endsection

@section('content')
<!-- Data Table Card (dengan Toolbar Pencarian & Filter Wilayah) -->
<div class="card">
    <div class="card-header" style="flex-wrap: wrap; gap: 12px; align-items: center; justify-content: space-between; padding: 12px 16px;">
        <div>
            <span class="card-title" style="font-size: 13.5px; font-weight: 700;">Daftar Penerima Bantuan</span>
            <div style="font-size: 11.5px; color: var(--text-3); margin-top: 2px;">Menampilkan {{ $penerima->count() }} dari {{ $penerima->total() }} warga terdaftar</div>
        </div>

        <!-- Form Filter & Pencarian -->
        <form action="{{ route('penerima.index') }}" method="GET" class="flex items-center gap-2" style="margin: 0; flex-wrap: wrap;">
            <div style="width: 240px;">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari NIK 16 digit atau nama..." 
                       class="form-input"
                       style="padding: 6px 10px; font-size: 12px;">
            </div>
            <div style="width: 180px;">
                <select name="kecamatan" class="form-select" style="padding: 6px 10px; font-size: 12px;">
                    <option value="">Semua Kecamatan</option>
                    @foreach($daftarKecamatan as $kec)
                        <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                    @endforeach
                </select>
            </div>
            <div style="width: 140px;">
                <select name="status" class="form-select" style="padding: 6px 10px; font-size: 12px;">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm" style="padding: 6px 12px;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 13px; height: 13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <span>Filter</span>
            </button>
            @if(request()->filled('search') || request()->filled('kecamatan') || request()->filled('status'))
                <a href="{{ route('penerima.index') }}" class="btn btn-secondary btn-sm" style="padding: 6px 10px;" title="Reset filter">
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
                    <th>NIK & Nama Penerima</th>
                    <th>Alamat & Wilayah</th>
                    <th>Kontak (No. HP)</th>
                    <th>Status</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penerima as $p)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: var(--text-1); font-size: 13px;">{{ $p->nama }}</div>
                        <div style="font-family: monospace; font-size: 11.5px; color: var(--text-3);">NIK: {{ $p->nik }}</div>
                    </td>
                    <td>
                        <div style="font-size: 12.5px; color: var(--text-1);">{{ $p->alamat }}</div>
                        <div style="font-size: 11.5px; color: var(--text-3);">Kec. {{ $p->kecamatan }} &bull; Kel. {{ $p->kelurahan }}</div>
                    </td>
                    <td style="color: var(--text-2); font-size: 12px;">
                        {{ $p->no_hp ?? '-' }}
                    </td>
                    <td>
                        <span class="badge {{ $p->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <a href="{{ route('penerima.edit', $p->id) }}" class="btn btn-secondary btn-xs">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            <span>Ubah Data</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <h3>Tidak Ada Data Penerima Bantuan</h3>
                            <p>Data penerima tidak ditemukan sesuai kriteria pencarian atau filter wilayah.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($penerima->hasPages())
    <div class="p-4" style="border-top: 1px solid var(--border);">
        {{ $penerima->links() }}
    </div>
    @endif
</div>
@endsection
