@extends('layouts.app')

@section('title', 'Daftar Persediaan Stok Bantuan')

@section('content')
<div>
    <!-- Breadcrumb & Header Halaman -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-500 mb-1.5">
                <span>Gudang Logistik</span>
                <span>&rsaquo;</span>
                <span class="text-slate-800 font-semibold">PBI-011: Pemantauan Stok Barang</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Persediaan Bantuan Pangan di Gudang</h1>
            <p class="text-sm text-slate-500 mt-0.5">Pantau ketersediaan fisik bahan pangan secara real-time untuk mendukung rencana pembagian bantuan.</p>
        </div>

        <div>
            <a 
                href="{{ route('stok.create') }}" 
                class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Tambah Komoditas Baru</span>
            </a>
        </div>
    </div>

    <!-- 4 Kartu KPI Ringkasan Status Stok -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <!-- Card 1: Total Komoditas -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Total Komoditas</p>
                <p class="text-xl font-bold text-slate-900">{{ $totalJenisBarang }} <span class="text-xs font-normal text-slate-500">jenis</span></p>
            </div>
        </div>

        <!-- Card 2: Stok Tersedia -->
        <div class="bg-white p-4 rounded-2xl border border-emerald-100 bg-emerald-50/20 shadow-sm flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 1118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-emerald-700 font-medium">Stok Tersedia (>10)</p>
                <p class="text-xl font-bold text-emerald-800">{{ $stokTersedia }} <span class="text-xs font-normal text-emerald-600">barang</span></p>
            </div>
        </div>

        <!-- Card 3: Stok Menipis -->
        <div class="bg-white p-4 rounded-2xl border border-amber-100 bg-amber-50/20 shadow-sm flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-amber-700 font-medium">Stok Menipis (1-10)</p>
                <p class="text-xl font-bold text-amber-800">{{ $stokMenipis }} <span class="text-xs font-normal text-amber-600">barang</span></p>
            </div>
        </div>

        <!-- Card 4: Stok Habis -->
        <div class="bg-white p-4 rounded-2xl border border-rose-100 bg-rose-50/20 shadow-sm flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
            </div>
            <div>
                <p class="text-xs text-rose-700 font-medium">Stok Habis (0)</p>
                <p class="text-xl font-bold text-rose-800">{{ $stokHabis }} <span class="text-xs font-normal text-rose-600">barang</span></p>
            </div>
        </div>
    </div>

    <!-- Filter Pencarian & Tabel -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Search Toolbar -->
        <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <form action="{{ route('stok.index') }}" method="GET" class="flex items-center space-x-2 w-full sm:max-w-md">
                <div class="relative flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search }}" 
                        placeholder="Cari nama komoditas pangan..." 
                        class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm bg-slate-50 focus:bg-white transition"
                    >
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <button 
                    type="submit" 
                    class="px-3.5 py-2 rounded-xl text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition"
                >
                    Cari
                </button>
                @if($search)
                    <a 
                        href="{{ route('stok.index') }}" 
                        class="text-xs text-slate-500 hover:text-slate-800 underline px-1 py-1"
                    >
                        Reset
                    </a>
                @endif
            </form>

            <div class="text-xs text-slate-500">
                Menampilkan <span class="font-semibold text-slate-800">{{ $stokList->total() }}</span> data komoditas
            </div>
        </div>

        <!-- Tabel Data Stok -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/75 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Nama Komoditas Pangan</th>
                        <th class="py-3 px-4">Satuan</th>
                        <th class="py-3 px-4 text-right">Jumlah Sisa Stok</th>
                        <th class="py-3 px-4 text-center">Status Ketersediaan</th>
                        <th class="py-3 px-4 text-right">Pembaruan Terakhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($stokList as $index => $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4 text-center text-xs text-slate-400 font-mono">
                                {{ $stokList->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-900">
                                {{ $item->nama_barang }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-xs text-slate-700 font-medium">
                                    {{ $item->satuan }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-slate-900 text-base">
                                {{ number_format($item->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($item->jumlah > 10)
                                    <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Tersedia</span>
                                    </span>
                                @elseif($item->jumlah > 0)
                                    <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        <span>Menipis</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        <span>Habis</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right text-xs text-slate-400 font-mono">
                                {{ $item->updated_at ? $item->updated_at->format('d/m/Y H:i') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="max-w-xs mx-auto flex flex-col items-center">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <p class="font-semibold text-slate-700 text-sm">Belum Ada Data Komoditas</p>
                                    <p class="text-xs text-slate-500 mt-1">
                                        @if($search)
                                            Tidak ditemukan komoditas dengan kata kunci "<strong>{{ $search }}</strong>".
                                        @else
                                            Belum ada komoditas pangan yang didaftarkan di gudang.
                                        @endif
                                    </p>
                                    @if($search)
                                        <a href="{{ route('stok.index') }}" class="mt-3 text-xs text-emerald-600 hover:underline font-semibold">Tampilkan Semua Data</a>
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
            <div class="p-4 border-t border-slate-100">
                {{ $stokList->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
