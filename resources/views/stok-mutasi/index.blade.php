<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Mutasi Keluar-Masuk Stok Gudang - PENAMAS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen antialiased flex flex-col">

    <!-- Reusable Left Sidebar (Sticky & Tetap di Sisi Kiri) -->
    @include('stok-mutasi.partials.sidebar', ['active' => 'mutasi'])

    <!-- Kontainer Halaman Utama di Sebelah Kanan Sidebar -->
    <div class="md:pl-64 lg:pl-72 flex flex-col min-h-screen bg-slate-50 transition-all duration-300">

        <!-- Top Navigation Bar (Sticky Header dengan Tombol Kembali & Aksi Cepat) -->
        <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200/90 px-4 sm:px-8 py-3.5 flex items-center justify-between shadow-xs">
            <div class="flex items-center space-x-3">
                <!-- Tombol Toggle Sidebar untuk Mobile / Tablet -->
                <button type="button" 
                        onclick="toggleSidebar()" 
                        class="md:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Tombol Kembali ke Halaman Sebelumnya / Menu Master Stok -->
                <a href="{{ route('stok.index') }}" 
                   class="inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-blue-700 text-xs font-bold transition shadow-2xs group"
                   title="Kembali ke Master Stok Barang">
                    <svg class="w-4 h-4 text-slate-500 group-hover:text-blue-600 group-hover:-translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>&larr; Kembali ke Master Stok</span>
                </a>

                <!-- Breadcrumbs -->
                <nav class="hidden lg:flex items-center space-x-2 text-xs text-slate-400 pl-2">
                    <span>/</span>
                    <span>Logistik Gudang</span>
                    <span>/</span>
                    <span class="text-slate-800 font-bold">Buku Mutasi Keluar-Masuk</span>
                </nav>
            </div>

            <!-- Tombol Aksi Cepat Masuk & Keluar -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('stok-mutasi.create') }}"
                   class="inline-flex items-center space-x-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-sm hover:shadow transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="hidden sm:inline">+ Catat Barang Masuk</span>
                    <span class="sm:hidden">+ Masuk</span>
                </a>

                <a href="{{ route('stok-mutasi.create-keluar') }}"
                   class="inline-flex items-center space-x-1.5 px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl text-xs shadow-sm hover:shadow transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/>
                    </svg>
                    <span class="hidden sm:inline">&minus; Catat Keluar Manual</span>
                    <span class="sm:hidden">&minus; Keluar</span>
                </a>
            </div>
        </header>

        <!-- Area Konten Utama -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">

            <!-- Banner Header Halaman -->
            <div class="bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 text-white rounded-2xl p-6 sm:p-8 shadow-xl border border-slate-800 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-xs font-semibold text-blue-200 mb-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Logistik & Inventaris Gudang Dinsospermades Kab. Banyumas</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                        Buku Mutasi Keluar-Masuk Barang
                    </h1>
                    <p class="text-slate-300 text-xs sm:text-sm mt-1.5 max-w-2xl leading-relaxed">
                        Audit resmi riwayat sirkulasi bahan pangan di gudang logistik: pencatatan restok pengadaan dinas, donasi sembako, dan pengeluaran darurat bencana atau barang rusak.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('stok.index') }}"
                       class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold backdrop-blur-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span>Lihat Stok Komoditas</span>
                    </a>
                </div>
            </div>

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl text-emerald-900 text-sm flex items-start space-x-3 shadow-sm animate-fade-in">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="text-xs text-emerald-800 mt-0.5 leading-relaxed">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- KPI Ringkasan Statistik Mutasi -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
                    <div class="flex items-center justify-between text-slate-400 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Transaksi Masuk</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                            &uarr;
                        </div>
                    </div>
                    <span class="text-2xl font-extrabold text-slate-900 block">
                        {{ number_format($stats['total_transaksi_masuk']) }}
                        <span class="text-xs font-normal text-slate-500">kali</span>
                    </span>
                    <span class="text-[11px] text-emerald-600 font-semibold mt-1 inline-flex items-center">
                        Dari Pengadaan & Donatur
                    </span>
                </div>

                <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
                    <div class="flex items-center justify-between text-slate-400 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Volume Masuk</span>
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                            +
                        </div>
                    </div>
                    <span class="text-2xl font-extrabold text-blue-700 block">
                        {{ number_format($stats['total_volume_masuk']) }}
                        <span class="text-xs font-normal text-slate-500">unit</span>
                    </span>
                    <span class="text-[11px] text-slate-500 font-medium mt-1 block">
                        Akumulasi barang bertambah
                    </span>
                </div>

                <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
                    <div class="flex items-center justify-between text-slate-400 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Transaksi Keluar</span>
                        <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                            &darr;
                        </div>
                    </div>
                    <span class="text-2xl font-extrabold text-rose-700 block">
                        {{ number_format($stats['total_transaksi_keluar']) }}
                        <span class="text-xs font-normal text-slate-500">kali</span>
                    </span>
                    <span class="text-[11px] text-slate-500 font-medium mt-1 block">
                        Penyaluran / Rusak / Darurat
                    </span>
                </div>

                <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
                    <div class="flex items-center justify-between text-slate-400 mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Komoditas Terdaftar</span>
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                            📦
                        </div>
                    </div>
                    <span class="text-2xl font-extrabold text-slate-900 block">
                        {{ number_format($stats['total_komoditas']) }}
                        <span class="text-xs font-normal text-slate-500">komoditas</span>
                    </span>
                    <span class="text-[11px] text-blue-600 font-semibold mt-1 block">
                        Tersedia di Gudang
                    </span>
                </div>
            </div>

            <!-- Kontainer Tabel & Filter Riwayat -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/90 overflow-hidden">

                <!-- Header Bar Filter -->
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                        <div>
                            <h2 class="font-extrabold text-slate-900 text-base">Filter Riwayat & Audit Mutasi</h2>
                            <p class="text-xs text-slate-500">Saring riwayat transaksi berdasarkan rentang tanggal, komoditas, atau jenis mutasi.</p>
                        </div>
                        @if(request('search') || request('stok_bantuan_id') || request('tipe') || request('tanggal_mulai') || request('tanggal_selesai'))
                            <a href="{{ route('stok-mutasi.index') }}" 
                               class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-lg transition self-start sm:self-auto">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>Reset Filter</span>
                            </a>
                        @endif
                    </div>

                    <!-- Formulir Filter Multi-Kriteria -->
                    <form action="{{ route('stok-mutasi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                        
                        <!-- Search Bar -->
                        <div class="md:col-span-4">
                            <label for="search" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">
                                Cari Barang / Keterangan
                            </label>
                            <div class="relative">
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Ketik nama komoditas atau alasan..."
                                    class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Komoditas -->
                        <div class="md:col-span-3">
                            <label for="stok_bantuan_id" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">
                                Komoditas Barang
                            </label>
                            <select name="stok_bantuan_id" id="stok_bantuan_id"
                                class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                                <option value="">-- Semua Komoditas --</option>
                                @foreach ($daftarBarang as $barang)
                                    <option value="{{ $barang->id }}" {{ request('stok_bantuan_id') == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->nama_barang }} ({{ $barang->satuan }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Jenis Mutasi -->
                        <div class="md:col-span-2">
                            <label for="tipe" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">
                                Jenis Mutasi
                            </label>
                            <select name="tipe" id="tipe"
                                class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                                <option value="">Semua (Masuk/Keluar)</option>
                                <option value="masuk" {{ request('tipe') === 'masuk' ? 'selected' : '' }}>Masuk (Pengadaan)</option>
                                <option value="keluar" {{ request('tipe') === 'keluar' ? 'selected' : '' }}>Keluar (Penyaluran/Lainnya)</option>
                            </select>
                        </div>

                        <!-- Filter Rentang Tanggal Mulai -->
                        <div class="md:col-span-3">
                            <label for="tanggal_mulai" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">
                                Dari Tanggal
                            </label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                                class="w-full px-3 py-1.5 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        </div>

                        <!-- Filter Rentang Tanggal Selesai -->
                        <div class="md:col-span-3">
                            <label for="tanggal_selesai" class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">
                                Sampai Tanggal
                            </label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ request('tanggal_selesai') }}"
                                class="w-full px-3 py-1.5 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        </div>

                        <!-- Tombol Terapkan Filter -->
                        <div class="md:col-span-9 flex space-x-2">
                            <button type="submit"
                                class="w-full py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-xl text-xs font-bold shadow-sm transition flex items-center justify-center space-x-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                <span>Terapkan Filter Riwayat</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tabel Data Riwayat Mutasi -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-[11px] uppercase text-slate-700 font-extrabold border-b border-slate-200/80">
                            <tr>
                                <th scope="col" class="px-5 py-3.5">Tanggal & Waktu Mutasi</th>
                                <th scope="col" class="px-5 py-3.5">Komoditas Barang</th>
                                <th scope="col" class="px-5 py-3.5 text-center">Jenis Mutasi</th>
                                <th scope="col" class="px-5 py-3.5 text-right">Jumlah Mutasi</th>
                                <th scope="col" class="px-5 py-3.5">Keterangan / Alasan</th>
                                <th scope="col" class="px-5 py-3.5">Petugas yang Menginput</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($mutasi as $m)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-5 py-3.5 text-xs text-slate-600 font-medium whitespace-nowrap">
                                        <div class="font-bold text-slate-800 flex items-center space-x-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>{{ $m->created_at->format('d M Y') }}</span>
                                        </div>
                                        <div class="text-[11px] text-slate-400 pl-5">{{ $m->created_at->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="font-bold text-slate-900 text-sm">{{ $m->stokBantuan?->nama_barang ?? '-' }}</div>
                                        <div class="text-[11px] text-slate-500 font-semibold text-blue-700">Satuan: {{ $m->stokBantuan?->satuan ?? '-' }}</div>
                                    </td>
                                    <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                        @if ($m->tipe === 'masuk')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                <span class="mr-1">&uarr;</span> Masuk
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-300">
                                                <span class="mr-1">&darr;</span> Keluar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-right font-mono font-bold text-sm whitespace-nowrap
                                        {{ $m->tipe === 'masuk' ? 'text-emerald-700' : 'text-rose-700' }}">
                                        {{ $m->tipe === 'masuk' ? '+' : '-' }}{{ number_format($m->jumlah) }}
                                        <span class="text-[11px] font-normal text-slate-500">{{ $m->stokBantuan?->satuan }}</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-xs text-slate-700 max-w-sm leading-relaxed">
                                        @if(preg_match('/^\[(.*?)\]\s*(.*)$/s', $m->keterangan ?? '', $matches))
                                            <div class="mb-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold 
                                                    {{ str_contains($matches[1], 'Rusak') ? 'bg-rose-100 text-rose-800 border border-rose-200' : (str_contains($matches[1], 'Kadaluarsa') ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-slate-100 text-slate-700 border border-slate-200') }}">
                                                    {{ $matches[1] }}
                                                </span>
                                            </div>
                                            <div>{{ $matches[2] }}</div>
                                        @else
                                            {{ $m->keterangan ?? '-' }}
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-xs whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 border border-blue-200 flex items-center justify-center font-bold text-xs uppercase flex-shrink-0">
                                                {{ strtoupper(substr($m->user?->name ?? 'P', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800">{{ $m->user?->name ?? 'Petugas Gudang' }}</div>
                                                <span class="inline-block px-1.5 py-0.5 rounded text-[10px] uppercase font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                                    {{ $m->user?->role ? ucfirst($m->user->role) : 'Operator' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-16 text-center text-slate-400">
                                        <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                        <p class="font-bold text-slate-800 text-base">Belum Ada Catatan Mutasi Stok</p>
                                        <p class="text-xs text-slate-400 mt-1 max-w-md mx-auto">
                                            Data mutasi keluar-masuk barang logistik akan muncul di sini saat Petugas mencatat pengadaan baru atau realisasi pengeluaran manual.
                                        </p>
                                        <div class="mt-4 flex items-center justify-center space-x-2">
                                            <a href="{{ route('stok-mutasi.create') }}"
                                               class="inline-flex items-center space-x-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-xl text-xs font-bold transition shadow-sm">
                                                <span>+ Catat Barang Masuk</span>
                                            </a>
                                            <a href="{{ route('stok.index') }}"
                                               class="inline-flex items-center space-x-1.5 px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-bold transition">
                                                <span>Ke Master Stok</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination -->
                @if($mutasi->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $mutasi->links() }}
                    </div>
                @endif

            </div>

        </main>

        <!-- Footer -->
        <footer class="mt-auto py-4 px-6 border-t border-slate-200/80 bg-white text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} PENAMAS &mdash; Sistem Informasi Manajemen Bantuan Pangan Dinsospermades Kabupaten Banyumas.
        </footer>

    </div>

</body>
</html>
