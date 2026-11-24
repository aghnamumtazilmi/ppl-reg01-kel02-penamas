@extends('layouts.app')

@section('page-title', 'Halaman Ringkasan (Dashboard)')
@section('page-subtitle', 'Ringkasan performa, kontrol stok gudang, dan pemantauan bantuan pangan masyarakat Kabupaten Banyumas')
@section('title', 'Halaman Ringkasan (Dashboard)')

@section('content')
<div class="space-y-8">

    <!-- Header Section Dashboard -->
    <div class="bg-gradient-to-r from-emerald-700 via-teal-700 to-emerald-800 rounded-2xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
        <!-- Dekorasi latar belakang -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-20 -top-10 w-40 h-40 bg-emerald-400/10 rounded-full blur-xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-100 text-xs font-semibold backdrop-blur-xs mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                    Sistem Terintegrasi &bull; Dinsospermades Kab. Banyumas
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Halaman Ringkasan (Dashboard)
                </h1>
                <p class="text-emerald-100 text-sm mt-1 max-w-2xl">
                    Pemantauan operasional bantuan pangan masyarakat, kontrol persediaan gudang, serta status persetujuan rencana distribusi secara langsung.
                </p>
            </div>

            <!-- Identitas PIC Pengembang & Tanggal -->
            <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/10 text-right self-start md:self-auto">
                <p class="text-xs text-emerald-200">PIC Sprint 1</p>
                <p class="text-sm font-bold text-white">Edwin Salman Hakim</p>
                <p class="text-[11px] text-emerald-100 mt-0.5">Fitur F-05 (PBI-013, 014, 015)</p>
            </div>
        </div>
    </div>

    <!-- ─── PBI-013 & PBI-014: KOTAK RINGKASAN ANGKA (STATISTIK UTAMA) ─── -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Ringkasan Angka Indikator Bantuan (PBI-013)
            </h2>
            <span class="text-xs text-slate-500 font-medium">Sinkronisasi Otomatis Basis Data</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Kartu 1: Total Penerima Manfaat (KPM) -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl p-5 border border-slate-200/80 dark:border-zinc-700 shadow-xs hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-zinc-400">Penerima (KPM)</span>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-extrabold text-slate-900 dark:text-white" id="stat-total-penerima">{{ number_format($totalPenerima ?? 0, 0, ',', '.') }}</div>
                    <div class="mt-1 flex items-center text-xs text-slate-500 dark:text-zinc-400 gap-1.5">
                        <span class="inline-flex items-center text-emerald-600 dark:text-emerald-400 font-semibold">
                            &bull; {{ number_format($penerimaAktif ?? 0, 0, ',', '.') }} Aktif
                        </span>
                        <span>di Kab. Banyumas</span>
                    </div>
                </div>
            </div>

            <!-- Kartu 2: Total Paket Bantuan -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl p-5 border border-slate-200/80 dark:border-zinc-700 shadow-xs hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-zinc-400">Paket Bantuan</span>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-extrabold text-slate-900 dark:text-white" id="stat-total-paket">{{ number_format($totalPaket ?? 0, 0, ',', '.') }}</div>
                    <div class="mt-1 text-xs text-slate-500 dark:text-zinc-400">
                        Varian paket terstandarisasi
                    </div>
                </div>
            </div>

            <!-- Kartu 3: Total Stok Gudang -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl p-5 border border-slate-200/80 dark:border-zinc-700 shadow-xs hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-zinc-400">Stok Barang Gudang</span>
                    <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-extrabold text-slate-900 dark:text-white" id="stat-total-stok">{{ number_format($totalStok ?? 0, 0, ',', '.') }}</div>
                    <div class="mt-1 text-xs text-slate-500 dark:text-zinc-400">
                        Total unit dari {{ $totalKomoditas ?? 0 }} komoditas
                    </div>
                </div>
            </div>

            <!-- Kartu 4 (PBI-014): Rencana Menunggu Persetujuan (Pimpinan) -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl p-5 border {{ ($pengajuanMenungguCount ?? 0) > 0 ? 'border-amber-300 ring-2 ring-amber-100 dark:ring-amber-900/30' : 'border-slate-200/80 dark:border-zinc-700' }} shadow-xs hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-700 dark:text-amber-400">Menunggu Review</span>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-extrabold text-amber-900 dark:text-amber-300" id="stat-menunggu-review">{{ $pengajuanMenungguCount ?? 0 }}</div>
                    <div class="mt-1 flex items-center justify-between">
                        <span class="text-xs text-slate-500 dark:text-zinc-400">Pengajuan Pimpinan</span>
                        <a href="#tabel-pengajuan-menunggu" class="text-xs font-bold text-amber-700 dark:text-amber-400 hover:text-amber-800 underline">
                            Tinjau &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert / Peringatan Stok Menipis (jika ada barang dengan stok <= 10) -->
    @if(isset($stokMenipis) && $stokMenipis->isNotEmpty())
    <div class="p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 text-amber-900 dark:text-amber-200 flex items-start gap-3 shadow-xs">
        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <div class="flex-1">
            <h4 class="text-sm font-bold">Peringatan: Stok Komoditas Menipis</h4>
            <p class="text-xs text-amber-800 dark:text-amber-300 mt-0.5">
                Beberapa komoditas pangan memiliki jumlah persediaan terbatas (&le; 10): 
                @foreach($stokMenipis as $item)
                    <span class="font-bold underline">{{ $item->nama_barang }} ({{ $item->jumlah }} {{ $item->satuan }})</span>{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </p>
        </div>
    </div>
    @endif

    <!-- ─── PBI-014: DAFTAR RENCANA BANTUAN MENUNGGU PERSETUJUAN PIMPINAN ─── -->
    <div id="tabel-pengajuan-menunggu" class="bg-white dark:bg-zinc-800 rounded-2xl border border-slate-200 dark:border-zinc-700 shadow-xs overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-100 dark:border-zinc-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 text-[11px] font-bold rounded-md bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">
                        PBI-014 (Khusus Pimpinan)
                    </span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Rencana Distribusi Menunggu Persetujuan</h3>
                </div>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">
                    Daftar rencana penyaluran yang diajukan oleh Admin dan membutuhkan verifikasi/approval Pimpinan Linjamsos.
                </p>
            </div>
            
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                {{ $pengajuanMenungguCount ?? 0 }} Rencana Perlu Ditinjau
            </span>
        </div>

        @if(!isset($pengajuanMenunggu) || $pengajuanMenunggu->isEmpty())
            <div class="py-12 px-4 text-center">
                <div class="w-12 h-12 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-slate-800 dark:text-white">Tidak Ada Rencana Menunggu Persetujuan</h4>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1 max-w-sm mx-auto">
                    Semua draf rencana distribusi telah ditinjau atau belum ada pengajuan baru dari Admin.
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-zinc-300">
                    <thead class="bg-slate-50 dark:bg-zinc-700/50 text-slate-700 dark:text-zinc-200 text-xs uppercase font-bold border-b border-slate-200 dark:border-zinc-700">
                        <tr>
                            <th scope="col" class="px-6 py-3.5">Kode Distribusi</th>
                            <th scope="col" class="px-6 py-3.5">Wilayah Sasaran</th>
                            <th scope="col" class="px-6 py-3.5">Paket & Sasaran</th>
                            <th scope="col" class="px-6 py-3.5">Tanggal Diajukan</th>
                            <th scope="col" class="px-6 py-3.5">Diajukan Oleh</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Aksi Cepat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-zinc-700">
                        @foreach($pengajuanMenunggu as $rencana)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-zinc-700/30 transition">
                            <td class="px-6 py-4 font-bold text-slate-900 dark:text-white font-mono text-xs">
                                {{ $rencana->kode }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800 dark:text-zinc-200">
                                Kec. {{ $rencana->wilayah }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-900 dark:text-white">{{ $rencana->paketBantuan->nama ?? '-' }}</span>
                                <div class="text-xs text-slate-500 dark:text-zinc-400">Kuota: {{ $rencana->jumlah_penerima }} KPM</div>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-600 dark:text-zinc-400">
                                {{ $rencana->tanggal_pengajuan ? $rencana->tanggal_pengajuan->translatedFormat('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-600 dark:text-zinc-400">
                                {{ $rencana->pembuat->name ?? 'Admin Bansos' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('penamas.distribusi.index') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-amber-600 hover:bg-amber-700 text-white font-semibold text-xs transition cursor-pointer shadow-xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
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

    <!-- ─── PBI-015: TABEL RINGKAS 5 AKTIVITAS DISTRIBUSI & PENYALURAN TERBARU ─── -->
    <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-slate-200 dark:border-zinc-700 shadow-xs overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-100 dark:border-zinc-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 text-[11px] font-bold rounded-md bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                        PBI-015 (Monitoring Program)
                    </span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">5 Aktivitas Distribusi & Penyaluran Terbaru</h3>
                </div>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1">
                    Jejak rekam status terkini seluruh program bantuan pangan masyarakat di wilayah Banyumas.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                    {{ $distribusiDisalurkanCount ?? 0 }} Telah Disalurkan
                </span>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                    {{ $distribusiDisetujuiCount ?? 0 }} Siap Salur
                </span>
            </div>
        </div>

        @if(!isset($aktivitasTerbaru) || $aktivitasTerbaru->isEmpty())
            <div class="py-12 px-4 text-center">
                <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-zinc-700 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-slate-800 dark:text-white">Belum Ada Aktivitas Distribusi</h4>
                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-1 max-w-sm mx-auto">
                    Data distribusi dan realisasi penyerahan bantuan pangan akan otomatis tercatat di sini.
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-zinc-300">
                    <thead class="bg-slate-50 dark:bg-zinc-700/50 text-slate-700 dark:text-zinc-200 text-xs uppercase font-bold border-b border-slate-200 dark:border-zinc-700">
                        <tr>
                            <th scope="col" class="px-6 py-3.5">Kode</th>
                            <th scope="col" class="px-6 py-3.5">Wilayah Sasaran</th>
                            <th scope="col" class="px-6 py-3.5">Paket Bantuan</th>
                            <th scope="col" class="px-6 py-3.5 text-center">Kuota (KPM)</th>
                            <th scope="col" class="px-6 py-3.5">Status Terkini</th>
                            <th scope="col" class="px-6 py-3.5">Waktu Update</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-zinc-700">
                        @foreach($aktivitasTerbaru as $item)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-zinc-700/30 transition">
                            <td class="px-6 py-4 font-bold text-slate-900 dark:text-white font-mono text-xs">
                                {{ $item->kode }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800 dark:text-zinc-200">
                                Kec. {{ $item->wilayah }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->paketBantuan->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-slate-900 dark:text-white">
                                {{ $item->jumlah_penerima }}
                            </td>
                            <td class="px-6 py-4">
                                @if($item->status === 'disalurkan')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        Disalurkan
                                    </span>
                                @elseif($item->status === 'disetujui')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                        Disetujui
                                    </span>
                                @elseif($item->status === 'diajukan')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                                        Diajukan
                                    </span>
                                @elseif($item->status === 'ditolak')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-800 dark:bg-zinc-700 dark:text-zinc-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500 dark:text-zinc-400">
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
