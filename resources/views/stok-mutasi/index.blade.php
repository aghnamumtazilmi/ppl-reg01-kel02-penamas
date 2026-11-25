@extends('layouts.app')

@section('page-title', 'Riwayat Mutasi Stok')
@section('page-subtitle', 'Catatan log mutasi barang masuk dan keluar persediaan gudang logistik PENAMAS')

@section('page-actions')
    <div style="display:flex; gap:10px; align-items:center;">
        <a href="{{ route('stok-mutasi.create') }}" class="btn btn-primary" style="border-radius: 8px;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>+ Catat Mutasi Masuk</span>
        </a>
        <a href="{{ route('stok-mutasi.create-keluar') }}" class="btn btn-danger" style="border-radius: 8px;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
            <span>&minus; Catat Keluar Manual</span>
        </a>
    </div>
@endsection

@section('content')
<div style="display:flex; flex-direction:column; gap:20px;">

    {{-- Flash Message Notifikasi Sukses --}}
    @if(session('success'))
        <div style="padding:12px 18px; border-radius:10px; background:var(--tag-green-bg); color:var(--tag-green-fg); border:1px solid var(--tag-green-border); font-size:12.5px; display:flex; align-items:flex-start; gap:10px;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:18px; height:18px; flex-shrink:0; margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- ── 4 KOTAK RINGKASAN STATISTIK ── -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
        
        <!-- Card 1: Transaksi Masuk -->
        <div class="stat-card" style="border-radius: 14px;">
            <div class="stat-label">
                <span>Transaksi Masuk</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
            </div>
            <div class="stat-val">{{ number_format($stats['total_transaksi_masuk']) }}</div>
            <div class="stat-footer">
                <span>Pengadaan &amp; donasi fisik</span>
                <span class="stat-chip stat-chip-green">Masuk</span>
            </div>
        </div>

        <!-- Card 2: Volume Total Masuk -->
        <div class="stat-card" style="border-radius: 14px;">
            <div class="stat-label">
                <span>Volume Total Masuk</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div class="stat-val">{{ number_format($stats['total_volume_masuk']) }}</div>
            <div class="stat-footer">
                <span>Akumulasi unit logistik</span>
                <span class="stat-chip stat-chip-blue">Restok</span>
            </div>
        </div>

        <!-- Card 3: Transaksi Keluar -->
        <div class="stat-card" style="border-radius: 14px;">
            <div class="stat-label">
                <span>Transaksi Keluar</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
            </div>
            <div class="stat-val">{{ number_format($stats['total_transaksi_keluar']) }}</div>
            <div class="stat-footer">
                <span>Rusak, susut &amp; bencana</span>
                <span class="stat-chip stat-chip-rose">Keluar</span>
            </div>
        </div>

        <!-- Card 4: Komoditas Gudang -->
        <div class="stat-card" style="border-radius: 14px;">
            <div class="stat-label">
                <span>Komoditas Terdaftar</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div class="stat-val">{{ number_format($stats['total_komoditas']) }}</div>
            <div class="stat-footer">
                <span>Item bahan pangan aktif</span>
                <span class="stat-chip stat-chip-amber">Gudang</span>
            </div>
        </div>

    </div>

    <!-- ── BARIS PENCARIAN & FILTER ── -->
    <div class="card" style="border-radius: 10px; padding: 12px 18px;">
        <form action="{{ route('penamas.stok.mutasi') }}" method="GET" style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
            
            <!-- Kolom Input Search (Lebar) -->
            <div style="flex:1; min-width:260px;">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari berdasarkan nama komoditas atau alasan mutasi..." 
                       class="form-input"
                       style="width:100%; padding:9px 14px; font-size:12.5px; border-radius:8px;">
            </div>

            <!-- Dropdown Komoditas Barang -->
            <div style="min-width:180px;">
                <select name="stok_bantuan_id" class="form-input"
                        style="width:100%; padding:9px 14px; font-size:12.5px; border-radius:8px; cursor:pointer;">
                    <option value="">Semua Komoditas</option>
                    @foreach ($daftarBarang as $barang)
                        <option value="{{ $barang->id }}" {{ request('stok_bantuan_id') == $barang->id ? 'selected' : '' }}>
                            {{ $barang->nama_barang }} ({{ $barang->satuan }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Dropdown Jenis Mutasi -->
            <div style="min-width:160px;">
                <select name="tipe" class="form-input"
                        style="width:100%; padding:9px 14px; font-size:12.5px; border-radius:8px; cursor:pointer;">
                    <option value="">Semua Jenis Mutasi</option>
                    <option value="masuk" {{ request('tipe') === 'masuk' ? 'selected' : '' }}>Masuk (Pengadaan)</option>
                    <option value="keluar" {{ request('tipe') === 'keluar' ? 'selected' : '' }}>Keluar (Rusak/Darurat)</option>
                </select>
            </div>

            <!-- Rentang Tanggal Mulai -->
            <div style="min-width:130px;">
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" title="Dari Tanggal"
                       class="form-input"
                       style="width:100%; padding:8px 10px; font-size:12px; border-radius:8px;">
            </div>

            <!-- Rentang Tanggal Selesai -->
            <div style="min-width:130px;">
                <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" title="Sampai Tanggal"
                       class="form-input"
                       style="width:100%; padding:8px 10px; font-size:12px; border-radius:8px;">
            </div>

            <!-- Tombol Filter -->
            <div>
                <button type="submit" class="btn btn-primary" style="border-radius:8px; padding:9px 18px;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:13px; height:13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Filter</span>
                </button>
            </div>

            @if(request('search') || request('stok_bantuan_id') || request('tipe') || request('tanggal_mulai') || request('tanggal_selesai'))
                <div>
                    <a href="{{ route('penamas.stok.mutasi') }}" class="btn btn-secondary" style="border-radius:8px; padding:9px 14px;">
                        &times; Reset
                    </a>
                </div>
            @endif

        </form>
    </div>

    <!-- ── TABEL DAFTAR MUTASI GUDANG ── -->
    <div class="card" style="border-radius: 12px; padding: 0; overflow: hidden;">
        
        <!-- Header Tabel -->
        <div style="padding:16px 22px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--border);">
            <div>
                <div class="card-title">Daftar Riwayat Mutasi Stok</div>
            </div>
            <div class="card-sub">
                Menampilkan {{ $mutasi->count() }} dari {{ $mutasi->total() }} catatan
            </div>
        </div>

        <!-- Konten Tabel -->
        <div class="table-wrap" style="border: none; border-radius: 0;">
            <table>
                <thead>
                    <tr>
                        <th>KOMODITAS PANGAN</th>
                        <th style="text-align:center;">HAK AKSES / JENIS</th>
                        <th style="text-align:right;">VOLUME / SALDO</th>
                        <th>KETERANGAN &amp; ALASAN</th>
                        <th>PETUGAS PENGINPUT</th>
                        <th>TERDAFTAR PADA</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mutasi as $m)
                        <tr>
                            
                            <!-- Komoditas Barang -->
                            <td>
                                <div style="font-weight:700; color:var(--text-1); font-size:13px;">{{ $m->stokBantuan?->nama_barang ?? '-' }}</div>
                                <div style="font-size:11.5px; color:var(--text-3); margin-top:2px;">Satuan: {{ $m->stokBantuan?->satuan ?? '-' }}</div>
                            </td>

                            <!-- Jenis Mutasi (Badge Bulat dengan Dot) -->
                            <td style="text-align:center; white-space:nowrap;">
                                @if ($m->tipe === 'masuk')
                                    <span style="display:inline-flex; align-items:center; gap:6px; background:var(--tag-green-bg); color:var(--tag-green-fg); border:1px solid var(--tag-green-border); border-radius:9999px; padding:3px 12px; font-size:11.5px; font-weight:600;">
                                        <span style="width:6px; height:6px; border-radius:50%; background:var(--tag-green-fg);"></span>
                                        <span>Masuk</span>
                                    </span>
                                @else
                                    <span style="display:inline-flex; align-items:center; gap:6px; background:var(--tag-red-bg); color:var(--tag-red-fg); border:1px solid var(--tag-red-border); border-radius:9999px; padding:3px 12px; font-size:11.5px; font-weight:600;">
                                        <span style="width:6px; height:6px; border-radius:50%; background:var(--tag-red-fg);"></span>
                                        <span>Keluar</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Volume / Saldo Mutasi -->
                            <td style="text-align:right; font-family:monospace; font-weight:700; font-size:13.5px; white-space:nowrap; {{ $m->tipe === 'masuk' ? 'color:var(--tag-green-fg);' : 'color:var(--tag-red-fg);' }}">
                                {{ $m->tipe === 'masuk' ? '+' : '-' }}{{ number_format($m->jumlah) }}
                                <span style="font-size:11px; font-weight:500; color:var(--text-3); font-family:inherit;">{{ $m->stokBantuan?->satuan }}</span>
                            </td>

                            <!-- Keterangan / Alasan -->
                            <td style="max-width:280px; line-height:1.45;">
                                @if(preg_match('/^\[(.*?)\]\s*(.*)$/s', $m->keterangan ?? '', $matches))
                                    <div style="margin-bottom:4px;">
                                        <span style="display:inline-block; font-size:10.5px; font-weight:600; border-radius:4px; padding:1px 6px; 
                                            {{ str_contains($matches[1], 'Rusak') ? 'background:var(--tag-red-bg); color:var(--tag-red-fg); border:1px solid var(--tag-red-border);' : (str_contains($matches[1], 'Kadaluarsa') ? 'background:var(--tag-amber-bg); color:var(--tag-amber-fg); border:1px solid var(--tag-amber-border);' : 'background:var(--surface-2); color:var(--text-2); border:1px solid var(--border);') }}">
                                            {{ $matches[1] }}
                                        </span>
                                    </div>
                                    <div style="color:var(--text-2); font-size:12px;">{{ $matches[2] }}</div>
                                @else
                                    <div style="color:var(--text-2); font-size:12px;">{{ $m->keterangan ?? '-' }}</div>
                                @endif
                            </td>

                            <!-- Petugas Penginput (Avatar) -->
                            <td style="white-space:nowrap;">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div class="user-ava">
                                        {{ strtoupper(substr($m->user?->name ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:700; color:var(--text-1); font-size:12.5px;">{{ $m->user?->name ?? 'Petugas Gudang' }}</div>
                                        <div style="font-size:11px; color:var(--text-3); text-transform:capitalize; margin-top:1px;">{{ $m->user?->email ?? ($m->user?->role ?? 'Operator') }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Terdaftar Pada -->
                            <td style="white-space:nowrap; color:var(--text-3); font-size:12px;">
                                {{ $m->created_at->format('d M Y, H:i') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:54px 20px;">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:24px; height:24px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                    <h3>Belum Ada Catatan Mutasi Stok</h3>
                                    <p>Catatan pergerakan bahan pangan akan otomatis muncul saat Petugas merekam pengadaan barang masuk atau pengeluaran manual.</p>
                                    <a href="{{ route('stok-mutasi.create') }}" class="btn btn-primary" style="border-radius:8px; margin-top:12px;">
                                        + Catat Mutasi Masuk Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mutasi->hasPages())
            <div style="padding:16px 22px; border-top:1px solid var(--border);">
                {{ $mutasi->links() }}
            </div>
        @endif

    </div>

</div>
@endsection
