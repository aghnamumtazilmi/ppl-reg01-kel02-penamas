@extends('layouts.app')

@section('page-title', 'Halaman Ringkasan (Dashboard)')
@section('page-subtitle', 'Ringkasan performa bantuan pangan, kontrol stok gudang, dan pemantauan distribusi Kab. Banyumas')

@section('content')
<div style="display: flex; flex-direction: column; gap: 20px;">

    <!-- ─── PBI-013 & PBI-014: 4 STAT CARDS KRAVIO ─── -->
    <div class="grid grid-4">
        <!-- 1. Total Penerima KPM -->
        <div class="stat-card">
            <div class="stat-label">
                <span>Total Penerima (KPM)</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="stat-val">{{ number_format($totalPenerima ?? 0, 0, ',', '.') }}</div>
            <div class="stat-footer">
                <span class="stat-chip stat-chip-green">{{ number_format($penerimaAktif ?? 0, 0, ',', '.') }} Aktif</span>
                <span>di Kab. Banyumas</span>
            </div>
        </div>

        <!-- 2. Total Paket Bantuan -->
        <div class="stat-card">
            <div class="stat-label">
                <span>Varian Paket Bantuan</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="stat-val">{{ number_format($totalPaket ?? 0, 0, ',', '.') }}</div>
            <div class="stat-footer">
                <span class="stat-chip stat-chip-blue">Terstandarisasi</span>
                <span>Komposisi Terdata</span>
            </div>
        </div>

        <!-- 3. Total Stok Barang di Gudang -->
        <div class="stat-card">
            <div class="stat-label">
                <span>Total Stok Gudang</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div class="stat-val">{{ number_format($totalStok ?? 0, 0, ',', '.') }}</div>
            <div class="stat-footer">
                <span class="stat-chip stat-chip-green">{{ $totalKomoditas ?? 0 }} Komoditas</span>
                <span>Saldo Keseluruhan</span>
            </div>
        </div>

        <!-- 4. Menunggu Review Pimpinan (PBI-014) -->
        <div class="stat-card" style="{{ ($pengajuanMenungguCount ?? 0) > 0 ? 'border-color: var(--tag-amber-border);' : '' }}">
            <div class="stat-label">
                <span style="color: var(--tag-amber-fg); font-weight: 700;">Menunggu Review</span>
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: var(--tag-amber-fg);">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-val" style="color: var(--tag-amber-fg);">{{ $pengajuanMenungguCount ?? 0 }}</div>
            <div class="stat-footer">
                <span class="stat-chip stat-chip-amber">Perlu Tindakan</span>
                <a href="#tabel-review-pimpinan" style="color: var(--tag-amber-fg); font-weight: 600; text-decoration: underline; font-size: 11px;">
                    Lihat Rencana &darr;
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Stok Menipis (PBI-013) -->
    @if(isset($stokMenipis) && $stokMenipis->isNotEmpty())
    <div class="alert alert-warning" style="display: flex; align-items: flex-start; gap: 10px;">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <div>
            <strong>Peringatan Stok Menipis:</strong> Terdapat komoditas pangan dengan persediaan terbatas (&le; 10 unit):
            @foreach($stokMenipis as $item)
                <span style="font-weight: 600; text-decoration: underline;">{{ $item->nama_barang }} ({{ $item->jumlah }} {{ $item->satuan }})</span>{{ !$loop->last ? ', ' : '' }}
            @endforeach
        </div>
    </div>
    @endif

    <!-- ─── PBI-014: TABEL RENCANA MENUNGGU PERSETUJUAN PIMPINAN ─── -->
    <div class="card" id="tabel-review-pimpinan">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
            <div>
                <div class="card-title">Rencana Distribusi Menunggu Persetujuan</div>
                <div class="card-sub">PBI-014 (Khusus Pimpinan) &bull; Pengajuan penyaluran yang membutuhkan verifikasi legalitas</div>
            </div>
            @if(($pengajuanMenungguCount ?? 0) > 0)
                <span class="badge badge-diajukan">{{ $pengajuanMenungguCount }} Rencana Perlu Ditinjau</span>
            @endif
        </div>

        @if(!isset($pengajuanMenunggu) || $pengajuanMenunggu->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon" style="background: var(--tag-green-bg); color: var(--tag-green-fg); margin: 0 auto 12px; display: flex; align-items: center; justify-content: center;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 22px; height: 22px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3>Tidak Ada Rencana Menunggu Persetujuan</h3>
                <p>Seluruh draf rencana distribusi telah diverifikasi atau belum ada pengajuan baru dari Admin.</p>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Kode Distribusi</th>
                            <th>Wilayah Sasaran</th>
                            <th>Paket & Kuota KPM</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Diajukan Oleh</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengajuanMenunggu as $rencana)
                        <tr>
                            <td style="font-family: monospace; font-weight: 700;">{{ $rencana->kode }}</td>
                            <td><strong>Kec. {{ $rencana->wilayah }}</strong></td>
                            <td>
                                <div>{{ $rencana->paketBantuan->nama ?? '-' }}</div>
                                <div style="font-size: 11px; color: var(--text-3);">Kuota: {{ $rencana->jumlah_penerima }} KPM</div>
                            </td>
                            <td style="font-size: 11.5px; color: var(--text-2);">
                                {{ $rencana->tanggal_pengajuan ? $rencana->tanggal_pengajuan->translatedFormat('d M Y, H:i') : '-' }}
                            </td>
                            <td style="font-size: 11.5px; color: var(--text-2);">
                                {{ $rencana->pembuat->name ?? 'Admin Bansos' }}
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('penamas.distribusi.index') }}" class="btn btn-secondary" style="font-size: 11.5px; padding: 4px 10px;">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Tinjau Rencana
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- ─── PBI-015: TABEL 5 AKTIVITAS DISTRIBUSI TERBARU ─── -->
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
            <div>
                <div class="card-title">5 Aktivitas Distribusi & Penyaluran Terbaru</div>
                <div class="card-sub">PBI-015 (Monitoring Program) &bull; Rekam jejak seluruh tahapan bantuan di wilayah Banyumas</div>
            </div>
            <div style="display: flex; gap: 6px;">
                <span class="stat-chip stat-chip-blue">{{ $distribusiDisalurkanCount ?? 0 }} Disalurkan</span>
                <span class="stat-chip stat-chip-green">{{ $distribusiDisetujuiCount ?? 0 }} Siap Salur</span>
            </div>
        </div>

        @if(!isset($aktivitasTerbaru) || $aktivitasTerbaru->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon" style="background: var(--surface-2); color: var(--text-3); margin: 0 auto 12px; display: flex; align-items: center; justify-content: center;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 22px; height: 22px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h3>Belum Ada Aktivitas Distribusi</h3>
                <p>Data jadwal distribusi dan penyerahan bantuan fisik akan otomatis tercatat di tabel ini.</p>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Wilayah Sasaran</th>
                            <th>Paket Bantuan</th>
                            <th style="text-align: center;">Kuota (KPM)</th>
                            <th>Status Terkini</th>
                            <th>Waktu Pembaruan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aktivitasTerbaru as $item)
                        <tr>
                            <td style="font-family: monospace; font-weight: 700;">{{ $item->kode }}</td>
                            <td><strong>Kec. {{ $item->wilayah }}</strong></td>
                            <td>{{ $item->paketBantuan->nama ?? '-' }}</td>
                            <td style="text-align: center; font-weight: 700;">{{ $item->jumlah_penerima }}</td>
                            <td>
                                @if($item->status === 'disalurkan')
                                    <span class="badge badge-disalurkan">Disalurkan</span>
                                @elseif($item->status === 'disetujui')
                                    <span class="badge badge-disetujui">Disetujui</span>
                                @elseif($item->status === 'diajukan')
                                    <span class="badge badge-diajukan">Diajukan</span>
                                @elseif($item->status === 'ditolak')
                                    <span class="badge badge-ditolak">Ditolak</span>
                                @else
                                    <span class="badge badge-draft">Draft</span>
                                @endif
                            </td>
                            <td style="font-size: 11.5px; color: var(--text-3);">
                                {{ $item->updated_at ? $item->updated_at->diffForHumans() : '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
