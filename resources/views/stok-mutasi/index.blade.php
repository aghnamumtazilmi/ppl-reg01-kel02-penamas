@extends('layouts.app')

@section('page-title', 'Riwayat Mutasi Stok')
@section('page-subtitle', 'Buku besar audit mutasi barang masuk (restok/donatur) dan keluar (rusak/darurat/penyaluran)')

@section('page-actions')
    <div style="display:flex; gap:8px; align-items:center;">
        <a href="{{ route('stok-mutasi.create') }}" class="btn btn-primary btn-sm" style="display:inline-flex; align-items:center; gap:6px;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px; height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>+ Catat Mutasi Masuk</span>
        </a>
        <a href="{{ route('stok-mutasi.create-keluar') }}" class="btn btn-danger btn-sm" style="display:inline-flex; align-items:center; gap:6px; background:#dc2626; color:#fff; border-color:#b91c1c;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px; height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
            <span>&minus; Catat Keluar Manual</span>
        </a>
    </div>
@endsection

@section('content')
<div style="display:flex; flex-direction:column; gap:20px;">

    {{-- Flash Message Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success" style="padding:12px 16px; border-radius:8px; background:var(--tag-green-bg); color:var(--tag-green-fg); border:1px solid var(--tag-green-border); font-size:12.5px; display:flex; align-items:flex-start; gap:8px;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px; height:16px; flex-shrink:0; margin-top:2px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- ── 4 KOTAK RINGKASAN STATISTIK (Kravio Stat Cards) ── -->
    <div class="grid-4">
        <!-- Stat 1: Total Transaksi Masuk -->
        <div class="stat-card">
            <div class="stat-label">
                <span>Transaksi Masuk</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
            </div>
            <div class="stat-value" style="color:var(--tag-green-fg);">
                {{ number_format($stats['total_transaksi_masuk']) }}
                <span style="font-size:13px; font-weight:400; color:var(--text-3);">kali</span>
            </div>
            <div class="stat-footer">
                <span class="stat-chip stat-chip-green">&uarr; Restok &amp; Donasi</span>
            </div>
        </div>

        <!-- Stat 2: Volume Total Masuk -->
        <div class="stat-card">
            <div class="stat-label">
                <span>Volume Total Masuk</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div class="stat-value" style="color:#2563eb;">
                {{ number_format($stats['total_volume_masuk']) }}
                <span style="font-size:13px; font-weight:400; color:var(--text-3);">unit</span>
            </div>
            <div class="stat-footer">
                <span class="stat-chip stat-chip-blue">Akumulasi Seluruh Barang</span>
            </div>
        </div>

        <!-- Stat 3: Total Transaksi Keluar -->
        <div class="stat-card">
            <div class="stat-label">
                <span>Transaksi Keluar</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
            </div>
            <div class="stat-value" style="color:#dc2626;">
                {{ number_format($stats['total_transaksi_keluar']) }}
                <span style="font-size:13px; font-weight:400; color:var(--text-3);">kali</span>
            </div>
            <div class="stat-footer">
                <span class="stat-chip stat-chip-rose">&darr; Rusak / Darurat / Salur</span>
            </div>
        </div>

        <!-- Stat 4: Jenis Komoditas Pangan -->
        <div class="stat-card">
            <div class="stat-label">
                <span>Komoditas Gudang</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div class="stat-value">
                {{ number_format($stats['total_komoditas']) }}
                <span style="font-size:13px; font-weight:400; color:var(--text-3);">item</span>
            </div>
            <div class="stat-footer">
                <span class="stat-chip stat-chip-amber">Tersedia di Gudang</span>
            </div>
        </div>
    </div>

    <!-- ── FORM FILTER & PENCARIAN RIWAYAT ── -->
    <div class="card" style="padding:16px;">
        <div style="margin-bottom:12px; display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h4 style="font-size:13.5px; font-weight:700; color:var(--text-1); margin:0;">Filter &amp; Audit Mutasi Stok</h4>
                <p style="font-size:11.5px; color:var(--text-3); margin-top:2px;">Saring data berdasarkan rentang tanggal, komoditas barang, atau jenis mutasi.</p>
            </div>
            @if(request('search') || request('stok_bantuan_id') || request('tipe') || request('tanggal_mulai') || request('tanggal_selesai'))
                <a href="{{ route('penamas.stok.mutasi') }}" class="btn btn-secondary btn-xs" style="text-decoration:none;">
                    &times; Reset Filter
                </a>
            @endif
        </div>

        <form action="{{ route('penamas.stok.mutasi') }}" method="GET">
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:12px; align-items:end;">
                
                <!-- Pencarian Kata Kunci -->
                <div>
                    <label class="form-label" style="font-size:11px; margin-bottom:4px;">Cari Barang / Keterangan</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama atau alasan..." class="form-input" style="padding:7px 10px; font-size:12px;">
                </div>

                <!-- Komoditas Barang -->
                <div>
                    <label class="form-label" style="font-size:11px; margin-bottom:4px;">Komoditas Barang</label>
                    <select name="stok_bantuan_id" class="form-select" style="padding:7px 10px; font-size:12px;">
                        <option value="">-- Semua Komoditas --</option>
                        @foreach ($daftarBarang as $barang)
                            <option value="{{ $barang->id }}" {{ request('stok_bantuan_id') == $barang->id ? 'selected' : '' }}>
                                {{ $barang->nama_barang }} ({{ $barang->satuan }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jenis Mutasi -->
                <div>
                    <label class="form-label" style="font-size:11px; margin-bottom:4px;">Jenis Mutasi</label>
                    <select name="tipe" class="form-select" style="padding:7px 10px; font-size:12px;">
                        <option value="">Semua (Masuk/Keluar)</option>
                        <option value="masuk" {{ request('tipe') === 'masuk' ? 'selected' : '' }}>Masuk (Pengadaan)</option>
                        <option value="keluar" {{ request('tipe') === 'keluar' ? 'selected' : '' }}>Keluar (Penyaluran/Lainnya)</option>
                    </select>
                </div>

                <!-- Dari Tanggal -->
                <div>
                    <label class="form-label" style="font-size:11px; margin-bottom:4px;">Dari Tanggal</label>
                    <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="form-input" style="padding:6px 10px; font-size:12px;">
                </div>

                <!-- Sampai Tanggal -->
                <div>
                    <label class="form-label" style="font-size:11px; margin-bottom:4px;">Sampai Tanggal</label>
                    <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="form-input" style="padding:6px 10px; font-size:12px;">
                </div>

                <!-- Tombol Submit Filter -->
                <div>
                    <button type="submit" class="btn btn-primary btn-sm" style="width:100%; justify-content:center; padding:7px 12px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:13px; height:13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        <span>Terapkan Filter</span>
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- ── TABEL DATA MUTASI KELUAR-MASUK ── -->
    <div class="card" style="overflow:hidden;">
        <div class="table-card-header" style="padding:14px 16px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h3 class="card-title" style="font-size:13.5px; font-weight:700;">Daftar Riwayat Keluar-Masuk Barang</h3>
                <p class="card-sub" style="font-size:11.5px; color:var(--text-3); margin-top:2px;">Buku besar riwayat pergerakan stok pangan dengan jejak audit petugas.</p>
            </div>
            <div style="font-size:11.5px; color:var(--text-3);">
                Total: <strong>{{ $mutasi->total() }}</strong> catatan
            </div>
        </div>

        <div class="table-wrap">
            <table style="width:100%; border-collapse:collapse; font-size:12.5px;">
                <thead>
                    <tr style="background:var(--surface-2); border-bottom:1px solid var(--border); text-align:left;">
                        <th style="padding:10px 14px; font-weight:700; color:var(--text-2); font-size:11px; text-transform:uppercase;">Tanggal &amp; Waktu</th>
                        <th style="padding:10px 14px; font-weight:700; color:var(--text-2); font-size:11px; text-transform:uppercase;">Komoditas Barang</th>
                        <th style="padding:10px 14px; font-weight:700; color:var(--text-2); font-size:11px; text-transform:uppercase; text-align:center;">Jenis Mutasi</th>
                        <th style="padding:10px 14px; font-weight:700; color:var(--text-2); font-size:11px; text-transform:uppercase; text-align:right;">Jumlah</th>
                        <th style="padding:10px 14px; font-weight:700; color:var(--text-2); font-size:11px; text-transform:uppercase;">Keterangan / Alasan</th>
                        <th style="padding:10px 14px; font-weight:700; color:var(--text-2); font-size:11px; text-transform:uppercase;">Petugas Penginput</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mutasi as $m)
                        <tr style="border-bottom:1px solid var(--border); transition:background .1s;">
                            <!-- Tanggal & Waktu -->
                            <td style="padding:11px 14px; white-space:nowrap;">
                                <div style="font-weight:600; color:var(--text-1);">{{ $m->created_at->format('d M Y') }}</div>
                                <div style="font-size:11px; color:var(--text-3);">{{ $m->created_at->format('H:i') }} WIB</div>
                            </td>

                            <!-- Komoditas Barang -->
                            <td style="padding:11px 14px;">
                                <div style="font-weight:700; color:var(--text-1);">{{ $m->stokBantuan?->nama_barang ?? '-' }}</div>
                                <div style="font-size:11px; color:var(--text-3);">Satuan: {{ $m->stokBantuan?->satuan ?? '-' }}</div>
                            </td>

                            <!-- Jenis Mutasi (Badge) -->
                            <td style="padding:11px 14px; text-align:center; white-space:nowrap;">
                                @if ($m->tipe === 'masuk')
                                    <span class="badge badge-disetujui" style="display:inline-flex; align-items:center; gap:4px;">
                                        &uarr; Masuk
                                    </span>
                                @else
                                    <span class="badge badge-ditolak" style="display:inline-flex; align-items:center; gap:4px;">
                                        &darr; Keluar
                                    </span>
                                @endif
                            </td>

                            <!-- Jumlah Mutasi -->
                            <td style="padding:11px 14px; text-align:right; font-family:monospace; font-weight:700; font-size:13px; white-space:nowrap; {{ $m->tipe === 'masuk' ? 'color:var(--tag-green-fg);' : 'color:#dc2626;' }}">
                                {{ $m->tipe === 'masuk' ? '+' : '-' }}{{ number_format($m->jumlah) }}
                                <span style="font-size:11px; font-weight:400; color:var(--text-3);">{{ $m->stokBantuan?->satuan }}</span>
                            </td>

                            <!-- Keterangan / Alasan -->
                            <td style="padding:11px 14px; max-width:280px; font-size:12px; line-height:1.4;">
                                @if(preg_match('/^\[(.*?)\]\s*(.*)$/s', $m->keterangan ?? '', $matches))
                                    <div style="margin-bottom:3px;">
                                        <span class="badge {{ str_contains($matches[1], 'Rusak') ? 'badge-ditolak' : (str_contains($matches[1], 'Kadaluarsa') ? 'badge-diajukan' : 'badge-draft') }}">
                                            {{ $matches[1] }}
                                        </span>
                                    </div>
                                    <div style="color:var(--text-2);">{{ $matches[2] }}</div>
                                @else
                                    <div style="color:var(--text-2);">{{ $m->keterangan ?? '-' }}</div>
                                @endif
                            </td>

                            <!-- Petugas Penginput -->
                            <td style="padding:11px 14px; white-space:nowrap;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div style="width:26px; height:26px; border-radius:50%; background:var(--active-bg); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:10.5px; color:var(--text-1);">
                                        {{ strtoupper(substr($m->user?->name ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600; color:var(--text-1); font-size:12px;">{{ $m->user?->name ?? 'Petugas Gudang' }}</div>
                                        <div style="font-size:10.5px; color:var(--text-3); text-transform:capitalize;">{{ $m->user?->role ?? 'Operator' }}</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:22px; height:22px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                    <h3>Belum Ada Catatan Mutasi Stok</h3>
                                    <p>Data mutasi keluar-masuk barang logistik akan muncul di sini saat Petugas mencatat pengadaan baru atau pengeluaran manual.</p>
                                    <div style="margin-top:14px;">
                                        <a href="{{ route('stok-mutasi.create') }}" class="btn btn-primary btn-sm">
                                            + Catat Barang Masuk Sekarang
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mutasi->hasPages())
            <div style="padding:12px 16px; border-top:1px solid var(--border); background:var(--surface-2);">
                {{ $mutasi->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
