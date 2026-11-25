@extends('layouts.app')

@section('page-title', 'Stok Bantuan')
@section('page-subtitle', 'Pantau persediaan dan ketersediaan komoditas bantuan pangan di gudang logistik')

@section('page-actions')
    <a href="{{ route('penamas.stok.create') }}" class="btn btn-primary" style="border-radius: 8px;">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>Tambah Komoditas</span>
    </a>
@endsection

@section('content')
<!-- 4 Kartu KPI Ringkasan Status Stok -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
    <!-- Card 1: Total Komoditas -->
    <div class="stat-card" style="border-radius: 14px;">
        <div class="stat-label">
            <span>Total Komoditas</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <div class="stat-val">{{ $totalJenisBarang }}</div>
        <div class="stat-footer">
            <span>{{ $totalJenisBarang }} jenis terdaftar</span>
        </div>
    </div>

    <!-- Card 2: Stok Tersedia -->
    <div class="stat-card" style="border-radius: 14px;">
        <div class="stat-label">
            <span>Stok Tersedia</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-val" style="color: var(--tag-green-fg);">{{ $stokTersedia }}</div>
        <div class="stat-footer">
            <span>Siap disalurkan</span>
            <span class="stat-chip stat-chip-green" style="border-radius: 6px;">Tersedia</span>
        </div>
    </div>

    <!-- Card 3: Stok Menipis -->
    <div class="stat-card" style="border-radius: 14px;">
        <div class="stat-label">
            <span>Stok Menipis</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div class="stat-val" style="color: var(--tag-amber-fg);">{{ $stokMenipis }}</div>
        <div class="stat-footer">
            <span>Perlu pengadaan</span>
            <span class="stat-chip stat-chip-amber" style="border-radius: 6px;">Menipis</span>
        </div>
    </div>

    <!-- Card 4: Stok Habis -->
    <div class="stat-card" style="border-radius: 14px;">
        <div class="stat-label">
            <span>Stok Habis</span>
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
        </div>
        <div class="stat-val" style="color: var(--tag-red-fg);">{{ $stokHabis }}</div>
        <div class="stat-footer">
            <span>Segera restock</span>
            <span class="stat-chip stat-chip-rose" style="border-radius: 6px;">Habis</span>
        </div>
    </div>
</div>

<!-- Card Tabel & Pencarian -->
<div class="card" style="border-radius: 14px; padding: 20px;">
    <!-- Toolbar Pencarian -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
        <div>
            <div class="card-title">Daftar Komoditas Logistik Gudang</div>
            <div class="card-sub">Menampilkan {{ $stokList->total() }} jenis komoditas bahan pangan</div>
        </div>
        <form action="{{ route('penamas.stok.index') }}" method="GET" style="display: flex; gap: 8px; align-items: center; margin: 0;">
            <input 
                type="text" 
                name="search" 
                value="{{ $search }}" 
                placeholder="Cari nama komoditas..." 
                class="form-input" 
                style="padding: 6px 12px; font-size: 12px; width: 220px; border-radius: 8px;"
            >
            <button type="submit" class="btn btn-secondary btn-sm" style="border-radius: 8px;">Cari</button>
            @if($search)
                <a href="{{ route('penamas.stok.index') }}" class="btn btn-ghost btn-sm" style="border-radius: 8px;">Reset</a>
            @endif
        </form>
    </div>

    <!-- Tabel Data Stok (Container mandiri di dalam Card) -->
    <div class="table-wrap" style="border: 1px solid var(--border); border-radius: 10px; overflow: hidden;">
        <table>
            <thead>
                <tr>
                    <th style="width: 48px; text-align: center;">No</th>
                    <th>Nama Komoditas Pangan</th>
                    <th>Satuan</th>
                    <th style="text-align: right;">Jumlah Sisa Stok</th>
                    <th style="text-align: center;">Status Ketersediaan</th>
                    <th style="text-align: right;">Pembaruan Terakhir</th>
                    <th style="text-align: center; width: 80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stokList as $index => $item)
                    <tr>
                        <td style="text-align: center; color: var(--text-3); font-size: 11px;">
                            {{ $stokList->firstItem() + $index }}
                        </td>
                        <td style="font-weight: 600; color: var(--text-1);">
                            {{ $item->nama_barang }}
                        </td>
                        <td>
                            <span class="badge badge-draft" style="border-radius: 6px;">{{ $item->satuan }}</span>
                        </td>
                        <td style="text-align: right; font-weight: 700; font-size: 13.5px; color: var(--text-1);">
                            {{ number_format($item->jumlah, 0, ',', '.') }}
                        </td>
                        <td style="text-align: center;">
                            @if($item->jumlah > 10)
                                <span class="badge badge-disetujui" style="border-radius: 6px;">Tersedia</span>
                            @elseif($item->jumlah > 0)
                                <span class="badge badge-diajukan" style="border-radius: 6px;">Menipis</span>
                            @else
                                <span class="badge badge-ditolak" style="border-radius: 6px;">Habis</span>
                            @endif
                        </td>
                        <td style="text-align: right; color: var(--text-3); font-size: 11.5px;">
                            {{ $item->updated_at ? $item->updated_at->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td style="text-align: center;">
                            <button 
                                type="button" 
                                class="btn btn-danger btn-xs" 
                                title="Hapus Komoditas"
                                style="padding: 4px 6px; border-radius: 6px;"
                                onclick="openDeleteModal('{{ route('penamas.stok.destroy', $item->id) }}', '{{ addslashes($item->nama_barang) }}')"
                            >
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 48px 16px;">
                            <div class="empty-state">
                                <p style="font-weight: 600; color: var(--text-2); margin-bottom: 4px;">Belum Ada Data Komoditas</p>
                                <p style="font-size: 12px; color: var(--text-3);">
                                    @if($search)
                                        Tidak ditemukan komoditas dengan kata kunci "<strong>{{ $search }}</strong>".
                                    @else
                                        Belum ada komoditas pangan yang didaftarkan di gudang.
                                    @endif
                                </p>
                                @if($search)
                                    <div style="margin-top: 10px;">
                                        <a href="{{ route('penamas.stok.index') }}" class="btn btn-secondary btn-xs">Tampilkan Semua Data</a>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    @if($stokList->hasPages())
        <div style="margin-top: 16px; padding-top: 12px; border-top: 1px solid var(--border);">
            {{ $stokList->links() }}
        </div>
    @endif
</div>

<!-- Modal Dialog Verifikasi Hapus Komoditas -->
<div 
    id="deleteModal" 
    style="display: none; position: fixed; inset: 0; z-index: 100; align-items: center; justify-content: center; background: rgba(0, 0, 0, 0.45); backdrop-filter: blur(4px); padding: 16px;"
    onclick="if(event.target === this) closeDeleteModal();"
>
    <div 
        class="card" 
        style="max-width: 440px; width: 100%; border-radius: 16px; padding: 24px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1); border: 1px solid var(--border);"
    >
        <!-- Icon Warning & Judul -->
        <div style="display: flex; gap: 14px; align-items: flex-start; margin-bottom: 16px;">
            <div style="width: 42px; height: 42px; border-radius: 10px; background: var(--tag-red-bg); border: 1px solid var(--tag-red-border); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 20px; height: 20px; color: var(--tag-red-fg);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div>
                <h3 style="font-size: 15px; font-weight: 700; color: var(--text-1); margin: 0 0 4px 0;">Konfirmasi Hapus Komoditas</h3>
                <p style="font-size: 12.5px; color: var(--text-2); margin: 0; line-height: 1.5;">
                    Apakah Anda yakin ingin menghapus komoditas <strong id="modalNamaBarang" style="color: var(--text-1);"></strong> dari persediaan gudang?
                </p>
            </div>
        </div>

        <div style="padding: 10px 12px; background: var(--surface-2); border: 1px solid var(--border); border-radius: 8px; margin-bottom: 20px; font-size: 11.5px; color: var(--text-3); display: flex; align-items: center; gap: 6px;">
            <svg style="width: 14px; height: 14px; flex-shrink: 0; color: #ef4444;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <span>Tindakan ini tidak dapat dibatalkan jika komoditas telah dihapus.</span>
        </div>

        <!-- Tombol Aksi Modal -->
        <div style="display: flex; justify-content: flex-end; gap: 8px;">
            <button 
                type="button" 
                class="btn btn-secondary" 
                style="border-radius: 8px; padding: 7px 14px;"
                onclick="closeDeleteModal()"
            >
                Batal
            </button>
            <form id="deleteForm" method="POST" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="btn btn-danger" 
                    style="border-radius: 8px; padding: 7px 16px;"
                >
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 13px; height: 13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Ya, Hapus</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(actionUrl, namaBarang) {
        document.getElementById('deleteForm').action = actionUrl;
        document.getElementById('modalNamaBarang').textContent = namaBarang;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    // Tutup modal jika tombol Escape ditekan
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endsection
