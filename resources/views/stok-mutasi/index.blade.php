@extends('layouts.app')

@section('page-title', 'Riwayat Mutasi Stok')
@section('page-subtitle', 'Catatan log mutasi barang masuk dan keluar persediaan gudang logistik PENAMAS')

@section('page-actions')
    <div style="display:flex; gap:10px; align-items:center;">
        <a href="{{ route('stok-mutasi.create') }}" 
           style="display:inline-flex; align-items:center; gap:6px; background:#18181b; color:#ffffff; font-weight:600; font-size:12.5px; padding:9px 16px; border-radius:8px; text-decoration:none; transition:all .15s ease; border:1px solid #18181b;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px; height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>Catat Mutasi Masuk</span>
        </a>
        <a href="{{ route('stok-mutasi.create-keluar') }}" 
           style="display:inline-flex; align-items:center; gap:6px; background:#ffffff; color:#dc2626; font-weight:600; font-size:12.5px; padding:9px 16px; border-radius:8px; text-decoration:none; transition:all .15s ease; border:1px solid #fecaca;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px; height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
            <span>Catat Keluar Manual</span>
        </a>
    </div>
@endsection

@section('content')
<div style="display:flex; flex-direction:column; gap:20px;">

    {{-- Flash Message Notifikasi Sukses --}}
    @if(session('success'))
        <div style="padding:12px 18px; border-radius:10px; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; font-size:12.5px; display:flex; align-items:flex-start; gap:10px;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:18px; height:18px; flex-shrink:0; margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- ── 4 KOTAK RINGKASAN STATISTIK (Sesuai Desain Screenshot) ── -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
        
        <!-- Card 1: Mutasi Masuk -->
        <div style="background:#ffffff; border:1px solid #e4e4e7; border-radius:12px; padding:18px 22px; display:flex; flex-direction:column; justify-content:space-between; box-shadow:0 1px 2px rgba(0,0,0,0.02);">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:13px; font-weight:500; color:#71717a;">Mutasi Masuk</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px; height:16px; color:#a1a1aa;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
            </div>
            <div style="font-size:30px; font-weight:800; color:#18181b; margin:10px 0 12px; letter-spacing:-0.02em;">
                {{ number_format($stats['total_transaksi_masuk']) }}
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; font-size:11.5px;">
                <span style="color:#a1a1aa;">Pengadaan &amp; donasi fisik</span>
                <span style="background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; border-radius:6px; padding:2px 10px; font-weight:600; font-size:11px;">
                    Masuk
                </span>
            </div>
        </div>

        <!-- Card 2: Volume Total Masuk -->
        <div style="background:#ffffff; border:1px solid #e4e4e7; border-radius:12px; padding:18px 22px; display:flex; flex-direction:column; justify-content:space-between; box-shadow:0 1px 2px rgba(0,0,0,0.02);">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:13px; font-weight:500; color:#71717a;">Total Volume Masuk</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px; height:16px; color:#a1a1aa;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div style="font-size:30px; font-weight:800; color:#18181b; margin:10px 0 12px; letter-spacing:-0.02em;">
                {{ number_format($stats['total_volume_masuk']) }}
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; font-size:11.5px;">
                <span style="color:#a1a1aa;">Akumulasi unit logistik</span>
                <span style="background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; border-radius:6px; padding:2px 10px; font-weight:600; font-size:11px;">
                    Restok
                </span>
            </div>
        </div>

        <!-- Card 3: Mutasi Keluar -->
        <div style="background:#ffffff; border:1px solid #e4e4e7; border-radius:12px; padding:18px 22px; display:flex; flex-direction:column; justify-content:space-between; box-shadow:0 1px 2px rgba(0,0,0,0.02);">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:13px; font-weight:500; color:#71717a;">Mutasi Keluar</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px; height:16px; color:#a1a1aa;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
            </div>
            <div style="font-size:30px; font-weight:800; color:#18181b; margin:10px 0 12px; letter-spacing:-0.02em;">
                {{ number_format($stats['total_transaksi_keluar']) }}
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; font-size:11.5px;">
                <span style="color:#a1a1aa;">Pengeluaran logistik</span>
                <span style="background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; border-radius:6px; padding:2px 10px; font-weight:600; font-size:11px;">
                    Keluar
                </span>
            </div>
        </div>

        <!-- Card 4: Komoditas Pangan -->
        <div style="background:#ffffff; border:1px solid #e4e4e7; border-radius:12px; padding:18px 22px; display:flex; flex-direction:column; justify-content:space-between; box-shadow:0 1px 2px rgba(0,0,0,0.02);">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:13px; font-weight:500; color:#71717a;">Komoditas Pangan</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px; height:16px; color:#a1a1aa;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div style="font-size:30px; font-weight:800; color:#18181b; margin:10px 0 12px; letter-spacing:-0.02em;">
                {{ number_format($stats['total_komoditas']) }}
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; font-size:11.5px;">
                <span style="color:#a1a1aa;">Item bahan pangan aktif</span>
                <span style="background:#fffbeb; color:#b45309; border:1px solid #fde68a; border-radius:6px; padding:2px 10px; font-weight:600; font-size:11px;">
                    Gudang
                </span>
            </div>
        </div>

    </div>

    <!-- ── BARIS PENCARIAN & FILTER (Sesuai Desain Screenshot) ── -->
    <div style="background:#ffffff; border:1px solid #e4e4e7; border-radius:10px; padding:12px 18px; box-shadow:0 1px 2px rgba(0,0,0,0.02);">
        <form action="{{ route('penamas.stok.mutasi') }}" method="GET" style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
            
            <!-- Kolom Input Search (Lebar) -->
            <div style="flex:1; min-width:260px;">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari berdasarkan nama komoditas atau alasan mutasi..." 
                       style="width:100%; padding:9px 14px; border:1px solid #e4e4e7; border-radius:8px; font-size:12.5px; color:#18181b; outline:none; background:#ffffff; transition:border .15s ease;">
            </div>

            <!-- Dropdown Komoditas Barang -->
            <div style="min-width:180px;">
                <select name="stok_bantuan_id" 
                        style="width:100%; padding:9px 14px; border:1px solid #e4e4e7; border-radius:8px; font-size:12.5px; color:#52525b; background:#ffffff; outline:none; cursor:pointer;">
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
                <select name="tipe" 
                        style="width:100%; padding:9px 14px; border:1px solid #e4e4e7; border-radius:8px; font-size:12.5px; color:#52525b; background:#ffffff; outline:none; cursor:pointer;">
                    <option value="">Semua Jenis Mutasi</option>
                    <option value="masuk" {{ request('tipe') === 'masuk' ? 'selected' : '' }}>Masuk (Pengadaan)</option>
                    <option value="keluar" {{ request('tipe') === 'keluar' ? 'selected' : '' }}>Keluar (Rusak/Darurat)</option>
                </select>
            </div>

            <!-- Rentang Tanggal Mulai -->
            <div style="min-width:130px;">
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" title="Dari Tanggal"
                       style="width:100%; padding:8px 10px; border:1px solid #e4e4e7; border-radius:8px; font-size:12px; color:#52525b; background:#ffffff; outline:none;">
            </div>

            <!-- Rentang Tanggal Selesai -->
            <div style="min-width:130px;">
                <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" title="Sampai Tanggal"
                       style="width:100%; padding:8px 10px; border:1px solid #e4e4e7; border-radius:8px; font-size:12px; color:#52525b; background:#ffffff; outline:none;">
            </div>

            <!-- Tombol Filter Hitam Sesuai Screenshot -->
            <div>
                <button type="submit" 
                        style="display:inline-flex; align-items:center; gap:6px; background:#18181b; color:#ffffff; font-weight:600; font-size:12.5px; padding:9px 18px; border-radius:8px; border:none; cursor:pointer; transition:background .15s ease;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:13px; height:13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Filter</span>
                </button>
            </div>

            @if(request('search') || request('stok_bantuan_id') || request('tipe') || request('tanggal_mulai') || request('tanggal_selesai'))
                <div>
                    <a href="{{ route('penamas.stok.mutasi') }}" 
                       style="display:inline-flex; align-items:center; gap:4px; background:#f4f4f5; color:#52525b; font-weight:600; font-size:12px; padding:9px 14px; border-radius:8px; text-decoration:none; border:1px solid #e4e4e7;">
                        &times; Reset
                    </a>
                </div>
            @endif

        </form>
    </div>

    <!-- ── TABEL DAFTAR MUTASI GUDANG (Sesuai Desain Screenshot) ── -->
    <div style="background:#ffffff; border:1px solid #e4e4e7; border-radius:12px; overflow:hidden; box-shadow:0 1px 2px rgba(0,0,0,0.02);">
        
        <!-- Header Tabel Sesuai Screenshot -->
        <div style="padding:16px 22px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #f4f4f5;">
            <div style="font-size:14.5px; font-weight:700; color:#18181b;">
                Daftar Riwayat Mutasi Stok
            </div>
            <div style="font-size:12px; color:#a1a1aa;">
                Menampilkan {{ $mutasi->count() }} dari {{ $mutasi->total() }} catatan
            </div>
        </div>

        <!-- Konten Tabel -->
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:12.5px; text-align:left;">
                <thead>
                    <tr style="border-bottom:1px solid #e4e4e7; background:#ffffff;">
                        <th style="padding:14px 22px; font-size:11px; font-weight:700; color:#71717a; text-transform:uppercase; letter-spacing:0.05em;">KOMODITAS PANGAN</th>
                        <th style="padding:14px 22px; font-size:11px; font-weight:700; color:#71717a; text-transform:uppercase; letter-spacing:0.05em; text-align:center;">JENIS MUTASI</th>
                        <th style="padding:14px 22px; font-size:11px; font-weight:700; color:#71717a; text-transform:uppercase; letter-spacing:0.05em; text-align:right;">VOLUME / SALDO</th>
                        <th style="padding:14px 22px; font-size:11px; font-weight:700; color:#71717a; text-transform:uppercase; letter-spacing:0.05em;">KETERANGAN &amp; ALASAN</th>
                        <th style="padding:14px 22px; font-size:11px; font-weight:700; color:#71717a; text-transform:uppercase; letter-spacing:0.05em;">PETUGAS PENGINPUT</th>
                        <th style="padding:14px 22px; font-size:11px; font-weight:700; color:#71717a; text-transform:uppercase; letter-spacing:0.05em;">WAKTU PENCATATAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mutasi as $m)
                        <tr style="border-bottom:1px solid #f4f4f5; transition:background .1s ease;">
                            
                            <!-- Komoditas Barang -->
                            <td style="padding:16px 22px;">
                                <div style="font-weight:700; color:#18181b; font-size:13px;">{{ $m->stokBantuan?->nama_barang ?? '-' }}</div>
                                <div style="font-size:11.5px; color:#a1a1aa; margin-top:2px;">Satuan: {{ $m->stokBantuan?->satuan ?? '-' }}</div>
                            </td>

                            <!-- Jenis Mutasi (Badge Bulat dengan Dot Sesuai Screenshot) -->
                            <td style="padding:16px 22px; text-align:center; white-space:nowrap;">
                                @if ($m->tipe === 'masuk')
                                    <span style="display:inline-flex; align-items:center; gap:6px; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; border-radius:9999px; padding:3px 12px; font-size:11.5px; font-weight:600;">
                                        <span style="width:6px; height:6px; border-radius:50%; background:#16a34a;"></span>
                                        <span>Masuk</span>
                                    </span>
                                @else
                                    <span style="display:inline-flex; align-items:center; gap:6px; background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; border-radius:9999px; padding:3px 12px; font-size:11.5px; font-weight:600;">
                                        <span style="width:6px; height:6px; border-radius:50%; background:#dc2626;"></span>
                                        <span>Keluar</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Volume / Saldo Mutasi -->
                            <td style="padding:16px 22px; text-align:right; font-family:monospace; font-weight:700; font-size:13.5px; white-space:nowrap; {{ $m->tipe === 'masuk' ? 'color:#15803d;' : 'color:#dc2626;' }}">
                                {{ $m->tipe === 'masuk' ? '+' : '-' }}{{ number_format($m->jumlah) }}
                                <span style="font-size:11px; font-weight:500; color:#71717a; font-family:inherit;">{{ $m->stokBantuan?->satuan }}</span>
                            </td>

                            <!-- Keterangan / Alasan -->
                            <td style="padding:16px 22px; max-width:280px; line-height:1.45;">
                                @if(preg_match('/^\[(.*?)\]\s*(.*)$/s', $m->keterangan ?? '', $matches))
                                    <div style="margin-bottom:4px;">
                                        <span style="display:inline-block; font-size:10.5px; font-weight:600; border-radius:4px; padding:1px 6px; 
                                            {{ str_contains($matches[1], 'Rusak') ? 'background:#fef2f2; color:#b91c1c; border:1px solid #fecaca;' : (str_contains($matches[1], 'Kadaluarsa') ? 'background:#fffbeb; color:#b45309; border:1px solid #fde68a;' : 'background:#f4f4f5; color:#52525b; border:1px solid #e4e4e7;') }}">
                                            {{ $matches[1] }}
                                        </span>
                                    </div>
                                    <div style="color:#52525b; font-size:12px;">{{ $matches[2] }}</div>
                                @else
                                    <div style="color:#52525b; font-size:12px;">{{ $m->keterangan ?? '-' }}</div>
                                @endif
                            </td>

                            <!-- Petugas Penginput (Avatar Bulat Hitam Sesuai Screenshot) -->
                            <td style="padding:16px 22px; white-space:nowrap;">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div style="width:32px; height:32px; border-radius:50%; background:#18181b; color:#ffffff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; flex-shrink:0;">
                                        {{ strtoupper(substr($m->user?->name ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:700; color:#18181b; font-size:12.5px;">{{ $m->user?->name ?? 'Petugas Gudang' }}</div>
                                        <div style="font-size:11px; color:#a1a1aa; text-transform:capitalize; margin-top:1px;">{{ $m->user?->email ?? ($m->user?->role ?? 'Operator') }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Terdaftar Pada / Tanggal Waktu Sesuai Screenshot -->
                            <td style="padding:16px 22px; white-space:nowrap; color:#71717a; font-size:12px;">
                                {{ $m->created_at->format('d M Y, H:i') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:54px 20px; text-align:center; color:#a1a1aa;">
                                <div style="width:52px; height:52px; border-radius:50%; background:#f4f4f5; display:flex; align-items:center; justify-content:center; margin:0 auto 12px; color:#a1a1aa;">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:26px; height:26px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                                <div style="font-size:14px; font-weight:700; color:#18181b; margin-bottom:4px;">Belum Ada Catatan Mutasi Stok</div>
                                <p style="font-size:12px; color:#71717a; max-width:400px; margin:0 auto 16px;">
                                    Catatan pergerakan bahan pangan akan otomatis muncul saat Petugas merekam pengadaan barang masuk atau pengeluaran manual.
                                </p>
                                <a href="{{ route('stok-mutasi.create') }}" 
                                   style="display:inline-flex; align-items:center; gap:6px; background:#18181b; color:#ffffff; font-weight:600; font-size:12px; padding:9px 18px; border-radius:8px; text-decoration:none;">
                                    + Catat Mutasi Masuk Sekarang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mutasi->hasPages())
            <div style="padding:16px 22px; border-top:1px solid #f4f4f5; background:#ffffff;">
                {{ $mutasi->links() }}
            </div>
        @endif

    </div>

</div>
@endsection
