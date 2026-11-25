@extends('layouts.app')

@section('page-title', 'Paket Bantuan')
@section('page-subtitle', 'Kelola standarisasi jenis paket dan rincian komponen komoditas bantuan pangan')

@section('page-actions')
    <div style="display: flex; align-items: center; gap: 8px;">
        <form action="{{ route('penamas.paket-bantuan.index') }}" method="GET" style="display: flex; gap: 6px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama paket/barang..." class="form-input" style="padding: 6px 12px; font-size: 12px; min-width: 220px;">
            @if(request('search'))
                <a href="{{ route('penamas.paket-bantuan.index') }}" class="btn btn-ghost btn-sm" title="Reset pencarian">✕</a>
            @endif
            <button type="submit" class="btn btn-secondary btn-sm">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Cari
            </button>
        </form>
        <a href="{{ route('penamas.paket-bantuan.create') }}" class="btn btn-primary btn-sm">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Paket
        </a>
    </div>
@endsection

@section('content')
<!-- Stat Cards -->
<div class="grid grid-3 mb-4">
    <div class="stat-card">
        <div class="stat-label">
            <span>Total Jenis Paket</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <div class="stat-val">{{ number_format($totalPaket) }}</div>
        <div class="stat-footer">
            <span class="stat-chip stat-chip-blue">Terdaftar</span>
            <span>Standar Bantuan PPL</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <span>Total Komponen Barang</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div class="stat-val">{{ number_format($totalKomponenItem) }}</div>
        <div class="stat-footer">
            <span class="stat-chip stat-chip-green">Komoditas</span>
            <span>Rincian item paket</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">
            <span>Integritas Distribusi</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <div class="stat-val" style="font-size: 16px; font-weight: 700; color: #15803d; padding-top: 4px;">Terproteksi</div>
        <div class="stat-footer">
            <span class="stat-chip stat-chip-green">Proteksi Aktif</span>
            <span>Cegah hapus paket terpakai</span>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Daftar Paket Bantuan Pangan</div>
            <div class="card-sub">Standarisasi isi dan takaran paket bantuan untuk penyaluran masyarakat</div>
        </div>
        @if(request('search'))
            <span class="badge badge-diajukan">Filter: "{{ request('search') }}"</span>
        @endif
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width: 48px; text-align: center;">No</th>
                    <th style="min-width: 180px;">Nama & Deskripsi Paket</th>
                    <th style="min-width: 320px;">Rincian Komponen Barang & Takaran</th>
                    <th style="width: 170px; text-align: center;">Status Penggunaan</th>
                    <th style="width: 140px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($paketList as $index => $paket)
                    <tr>
                        <td style="text-align: center; color: var(--text-3); font-weight: 600;">
                            {{ $paketList->firstItem() + $index }}
                        </td>
                        <td>
                            <div style="font-weight: 600; font-size: 13px; color: var(--text-1); margin-bottom: 2px;">
                                {{ $paket->nama }}
                            </div>
                            <div style="font-size: 11.5px; color: var(--text-3); line-height: 1.4;">
                                {{ $paket->deskripsi ?: 'Tidak ada keterangan tambahan.' }}
                            </div>
                        </td>
                        <td>
                            @if($paket->komponen->isNotEmpty())
                                <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                    @foreach($paket->komponen as $item)
                                        <span class="stat-chip stat-chip-blue" style="font-size: 11px; padding: 2px 7px;">
                                            <strong>{{ $item->nama_barang }}</strong>: {{ rtrim(rtrim(number_format($item->jumlah, 2, ',', '.'), '0'), ',') }} {{ $item->satuan }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="badge badge-ditolak" style="font-size: 11px;">Belum ada komponen barang</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($paket->distribusi_count > 0)
                                <span class="badge badge-disetujui" title="Paket ini sudah terdaftar dalam jadwal/riwayat rencana distribusi">
                                    {{ $paket->distribusi_count }}x Distribusi
                                </span>
                            @else
                                <span class="badge badge-draft" title="Belum pernah digunakan di rencana distribusi manapun">
                                    Belum Dipakai
                                </span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <div style="display: inline-flex; align-items: center; gap: 6px;">
                                <a href="{{ route('penamas.paket-bantuan.edit', $paket) }}" class="btn btn-secondary btn-xs" title="Ubah Rincian Paket">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Ubah
                                </a>

                                <form action="{{ route('penamas.paket-bantuan.destroy', $paket) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket bantuan \'{{ addslashes($paket->nama) }}\'?\n\nCatatan: Paket yang sudah terpakai pada riwayat rencana distribusi tidak dapat dihapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" title="Hapus Paket Bantuan" {{ $paket->distribusi_count > 0 ? 'disabled style=opacity:0.45;cursor:not-allowed;' : '' }}>
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                                <h3>Belum Ada Paket Bantuan</h3>
                                <p>{{ request('search') ? 'Tidak ditemukan paket bantuan dengan kata kunci tersebut.' : 'Silakan klik tombol Tambah Paket untuk membuat paket bantuan pangan baru.' }}</p>
                                @if(!request('search'))
                                    <div style="margin-top: 12px;">
                                        <a href="{{ route('penamas.paket-bantuan.create') }}" class="btn btn-primary btn-sm">+ Buat Paket Sekarang</a>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($paketList->hasPages())
        <div style="padding: 12px 16px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
            <div style="font-size: 11.5px; color: var(--text-3);">
                Menampilkan {{ $paketList->firstItem() }} - {{ $paketList->lastItem() }} dari {{ $paketList->total() }} paket
            </div>
            <div>
                {{ $paketList->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
