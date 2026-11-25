@extends('layouts.app')

@section('title', 'Kelola Paket Bantuan')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-emerald-700 via-teal-700 to-emerald-800 rounded-2xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-100 text-xs font-semibold backdrop-blur-xs mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                    Master Data Dasar &bull; Dinsospermades Kab. Banyumas
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Kelola Paket Bantuan (F-03)
                </h1>
                <p class="text-emerald-100 text-sm mt-1 max-w-2xl">
                    Standardisasi jenis paket bantuan pangan dan rincian komponen komoditas barang bagi Keluarga Penerima Manfaat (KPM).
                </p>
            </div>

            <!-- Identitas PIC Pengembang -->
            <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/10 text-right self-start md:self-auto">
                <p class="text-xs text-emerald-200">PIC Sprint 1</p>
                <p class="text-sm font-bold text-white">Isaf Khiyar Musyaffa</p>
                <p class="text-[11px] text-emerald-100 mt-0.5">Fitur F-03 (PBI-007, 008, 009)</p>
            </div>
        </div>
    </div>

    <!-- Action Bar & Filter -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <!-- Kotak Pencarian -->
        <form method="GET" action="{{ route('paket.index') }}" class="flex-1 max-w-md flex items-center gap-2">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ $search ?? '' }}" 
                       placeholder="Cari nama paket atau jenis barang..." 
                       class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
            </div>
            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm transition">
                Cari
            </button>
            @if(!empty($search))
                <a href="{{ route('paket.index') }}" class="px-3 py-2 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 text-sm font-semibold transition">
                    Reset
                </a>
            @endif
        </form>

        <!-- Tombol Tambah Paket (PBI-007) -->
        <a href="{{ route('paket.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md shadow-emerald-600/20 transition self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Paket Bantuan Baru
        </a>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500">Total Varian Paket</p>
                <p class="text-xl font-extrabold text-slate-900">{{ $totalPaket }} Paket</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500">Total Item Komponen Terdaftar</p>
                <p class="text-xl font-extrabold text-slate-900">{{ $totalKomponenItem }} Komponen</p>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Paket Bantuan -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        @if($paketList->isEmpty())
            <div class="py-16 px-4 text-center">
                <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">Belum Ada Data Paket Bantuan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Klik tombol "Tambah Paket Bantuan Baru" di atas untuk membuat standarisasi paket pertama Anda.
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 text-xs uppercase font-bold border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-6 py-4">Nama Paket & Deskripsi</th>
                            <th scope="col" class="px-6 py-4">Rincian Komponen Barang</th>
                            <th scope="col" class="px-6 py-4 text-center">Status Pemakaian</th>
                            <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($paketList as $paket)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Nama & Deskripsi -->
                            <td class="px-6 py-4 align-top max-w-xs">
                                <div class="font-bold text-slate-900 text-base flex items-center gap-2">
                                    {{ $paket->nama }}
                                </div>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                    {{ $paket->deskripsi ?: 'Tidak ada deskripsi tambahan.' }}
                                </p>
                            </td>

                            <!-- Komponen Barang -->
                            <td class="px-6 py-4 align-top">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($paket->komponen as $item)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            {{ $item->nama_barang }}: <span class="font-bold">{{ (float)$item->jumlah }} {{ $item->satuan }}</span>
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400 italic">Belum ada rincian komponen</span>
                                    @endforelse
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1.5">
                                    Total {{ $paket->komponen->count() }} jenis barang
                                </p>
                            </td>

                            <!-- Status Penggunaan di Distribusi -->
                            <td class="px-6 py-4 align-top text-center">
                                @if($paket->distribusi_count > 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800" title="Paket sudah terhubung ke jadwal distribusi">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $paket->distribusi_count }} Distribusi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                        Belum Terpakai
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi (Edit PBI-008 & Hapus PBI-009) -->
                            <td class="px-6 py-4 align-top text-right space-x-1 whitespace-nowrap">
                                <!-- Tombol Edit (PBI-008) -->
                                <a href="{{ route('paket.edit', $paket->id) }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Ubah
                                </a>

                                <!-- Tombol Hapus (PBI-009) -->
                                <form action="{{ route('paket.destroy', $paket->id) }}" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket bantuan {{ $paket->nama }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold text-xs transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($paketList->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $paketList->links() }}
                </div>
            @endif
        @endif
    </div>

</div>
@endsection
