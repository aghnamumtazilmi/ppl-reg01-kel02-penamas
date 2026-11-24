@extends('layouts.app')

@section('page-title', 'Stok Bantuan Pangan di Gudang')
@section('page-subtitle', 'Pantau ketersediaan fisik bahan pangan secara real-time di gudang logistik')

@section('page-actions')
    <a href="{{ route('stok.create') }}" class="btn btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>Tambah Komoditas Baru</span>
    </a>
@endsection

@section('content')
<!-- 4 KPI Stat Cards -->
<div class="grid grid-4 mb-4">
    <div class="stat-card">
        <div class="stat-label">
            <span>Total Komoditas</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <div class="stat-val">{{ $totalJenisBarang }}</div>
        <div class="stat-footer">
            <span>Jenis komoditas pangan</span>
            <span class="stat-chip stat-chip-blue">Total</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <span>Stok Tersedia (>10)</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-val">{{ $stokTersedia }}</div>
        <div class="stat-footer">
            <span>Siap disalurkan</span>
            <span class="stat-chip stat-chip-green">Aman</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <span>Stok Menipis (1-10)</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div class="stat-val">{{ $stokMenipis }}</div>
        <div class="stat-footer">
            <span>Perlu restock segera</span>
            <span class="stat-chip stat-chip-amber">Perhatian</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <span>Stok Habis (0)</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-val">{{ $stokHabis }}</div>
        <div class="stat-footer">
            <span>Gudang kosong</span>
            <span class="stat-chip stat-chip-rose">Kosong</span>
        </div>
    </div>
</div>

<!-- Data Table Card (dengan Toolbar Pencarian Terpadu) -->
<div class="card">
    <div class="card-header" style="flex-wrap: wrap; gap: 12px; align-items: center; justify-content: space-between; padding: 12px 16px;">
        <div>
            <span class="card-title" style="font-size: 13.5px; font-weight: 700;">Daftar Persediaan Stok Barang</span>
            <div style="font-size: 11.5px; color: var(--text-3); margin-top: 2px;">Menampilkan {{ $stokList->count() }} dari {{ $stokList->total() }} item komoditas</div>
        </div>

        <!-- Form Filter & Pencarian -->
        <form action="{{ route('stok.index') }}" method="GET" class="flex items-center gap-2" style="margin: 0; flex-wrap: wrap;">
            <div style="width: 250px;">
                <input type="text" 
                       name="search" 
                       value="{{ $search }}" 
                       placeholder="Cari nama komoditas pangan..." 
                       class="form-input"
                       style="padding: 6px 10px; font-size: 12px;">
            </div>
            <button type="submit" class="btn btn-primary btn-sm" style="padding: 6px 12px;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 13px; height: 13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <span>Cari</span>
            </button>
            @if($search)
                <a href="{{ route('stok.index') }}" class="btn btn-secondary btn-sm" style="padding: 6px 10px;" title="Reset filter">
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
                    <th>Nama Komoditas</th>
                    <th>Kategori</th>
                    <th>Jumlah Fisik</th>
                    <th>Satuan</th>
                    <th>Status Persediaan</th>
                    <th>Terakhir Diperbarui</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stokList as $item)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: var(--text-1); font-size: 13px;">{{ $item->nama_barang }}</div>
                    </td>
                    <td>
                        <span style="font-size: 11.5px; color: var(--text-2);">{{ $item->kategori ?? 'Bahan Pokok' }}</span>
                    </td>
                    <td>
                        <span style="font-weight: 700; font-size: 13.5px; color: var(--text-1);">
                            {{ number_format($item->jumlah, 0, ',', '.') }}
                        </span>
                    </td>
                    <td style="color: var(--text-2); font-size: 12px;">
                        {{ $item->satuan }}
                    </td>
                    <td>
                        @if($item->jumlah > 10)
                            <span class="badge badge-aktif">Tersedia</span>
                        @elseif($item->jumlah > 0)
                            <span class="badge badge-diajukan">Menipis</span>
                        @else
                            <span class="badge badge-ditolak">Habis</span>
                        @endif
                    </td>
                    <td style="color: var(--text-2); font-size: 12px;">
                        {{ $item->updated_at ? $item->updated_at->format('d M Y, H:i') : '-' }}
                    </td>
                    <td style="text-align: right;">
                        <form action="{{ route('stok.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komoditas {{ $item->nama_barang }} dari gudang?')" style="margin: 0; display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <h3>Belum Ada Data Komoditas</h3>
                            <p>
                                @if($search)
                                    Tidak ditemukan komoditas dengan kata kunci "{{ $search }}".
                                @else
                                    Belum ada persediaan komoditas bahan pangan yang terdaftar di gudang.
                                @endif
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($stokList->hasPages())
    <div class="p-4" style="border-top: 1px solid var(--border);">
        {{ $stokList->links() }}
    </div>
    @endif
</div>
@endsection
