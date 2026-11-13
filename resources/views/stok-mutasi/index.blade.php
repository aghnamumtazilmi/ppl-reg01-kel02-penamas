<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Mutasi Stok Gudang - PENAMAS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen py-8 antialiased">

    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        <!-- Top Navigation / Modul Switcher -->
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6 pb-4 border-b border-slate-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-blue-700 flex items-center justify-center text-white font-extrabold shadow-md">
                    P
                </div>
                <div>
                    <h2 class="font-extrabold text-slate-900 tracking-tight text-lg">PENAMAS GUDANG</h2>
                    <p class="text-xs text-slate-500">Dinsospermades Kabupaten Banyumas</p>
                </div>
            </div>
            <nav class="flex items-center space-x-2">
                <a href="{{ route('penerima.index') }}"
                   class="px-3.5 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">
                    Data Penerima (KPM)
                </a>
                <span class="px-3.5 py-1.5 rounded-lg bg-blue-700 text-white text-xs font-bold shadow-sm">
                    Mutasi Stok Gudang
                </span>
            </nav>
        </header>

        <!-- Banner Header Card -->
        <div class="bg-gradient-to-r from-blue-700 via-blue-800 to-indigo-900 text-white rounded-t-2xl p-6 shadow-lg flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-2 px-2.5 py-1 rounded-full bg-blue-600/60 border border-blue-400/30 text-xs font-semibold text-blue-100 mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Modul Logistik • F-06 : Catatan Keluar-Masuk Stok Gudang</span>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight">Catatan Keluar-Masuk Stok Pangan</h1>
                <p class="text-blue-100 text-sm mt-1">
                    Buku besar mutasi logistik barang bansos, pemantauan pengadaan masuk, dan audit penyaluran.
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('stok-mutasi.create') }}"
                   class="inline-flex items-center space-x-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 border border-emerald-400 text-white font-bold rounded-xl shadow-md transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>+ Catat Mutasi Masuk (PBI-016)</span>
                </a>
            </div>
        </div>

        <!-- Kontainer Utama -->
        <div class="bg-white rounded-b-2xl shadow-xl p-6 border border-slate-200 border-t-0 space-y-6">

            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-emerald-900 text-sm flex items-start space-x-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="text-xs text-emerald-800 mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- KPI Summary Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <span class="text-xs font-semibold text-slate-500 block">Total Transaksi Masuk</span>
                    <span class="text-2xl font-extrabold text-blue-700 mt-1 block">
                        {{ number_format($stats['total_transaksi_masuk']) }}
                        <span class="text-xs font-normal text-slate-500">kali</span>
                    </span>
                    <span class="text-[11px] text-emerald-600 font-semibold mt-1 inline-flex items-center">
                        ↑ Dari Pengadaan & Donasi
                    </span>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <span class="text-xs font-semibold text-slate-500 block">Volume Total Masuk</span>
                    <span class="text-2xl font-extrabold text-emerald-700 mt-1 block">
                        {{ number_format($stats['total_volume_masuk']) }}
                        <span class="text-xs font-normal text-slate-500">unit</span>
                    </span>
                    <span class="text-[11px] text-slate-500 font-medium mt-1 block">Akumulasi seluruh barang</span>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <span class="text-xs font-semibold text-slate-500 block">Total Transaksi Keluar</span>
                    <span class="text-2xl font-extrabold text-rose-700 mt-1 block">
                        {{ number_format($stats['total_transaksi_keluar']) }}
                        <span class="text-xs font-normal text-slate-500">kali</span>
                    </span>
                    <span class="text-[11px] text-slate-500 font-medium mt-1 block">Penyaluran / Rusak</span>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <span class="text-xs font-semibold text-slate-500 block">Jenis Komoditas Pangan</span>
                    <span class="text-2xl font-extrabold text-slate-800 mt-1 block">
                        {{ number_format($stats['total_komoditas']) }}
                        <span class="text-xs font-normal text-slate-500">komoditas</span>
                    </span>
                    <span class="text-[11px] text-blue-600 font-semibold mt-1 block">Tersedia di Gudang</span>
                </div>
            </div>

            <!-- Form Pencarian & Filter Multi-Kriteria -->
            <form action="{{ route('stok-mutasi.index') }}" method="GET" class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">

                    <!-- Search Input -->
                    <div class="md:col-span-4">
                        <label for="search" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">
                            Cari Barang / Keterangan
                        </label>
                        <div class="relative">
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Ketik nama komoditas atau sumber..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Komoditas -->
                    <div class="md:col-span-4">
                        <label for="stok_bantuan_id" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">
                            Pilih Komoditas
                        </label>
                        <select name="stok_bantuan_id" id="stok_bantuan_id"
                            class="w-full px-3 py-2.5 rounded-lg border border-slate-300 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                            <option value="">-- Semua Komoditas --</option>
                            @foreach ($daftarBarang as $barang)
                                <option value="{{ $barang->id }}" {{ request('stok_bantuan_id') == $barang->id ? 'selected' : '' }}>
                                    {{ $barang->nama_barang }} ({{ $barang->satuan }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Tipe Mutasi -->
                    <div class="md:col-span-2">
                        <label for="tipe" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">
                            Jenis Mutasi
                        </label>
                        <select name="tipe" id="tipe"
                            class="w-full px-3 py-2.5 rounded-lg border border-slate-300 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                            <option value="">Semua</option>
                            <option value="masuk" {{ request('tipe') === 'masuk' ? 'selected' : '' }}>Masuk (Pengadaan)</option>
                            <option value="keluar" {{ request('tipe') === 'keluar' ? 'selected' : '' }}>Keluar (Penyaluran)</option>
                        </select>
                    </div>

                    <!-- Tombol Submit & Reset -->
                    <div class="md:col-span-2 flex space-x-2">
                        <button type="submit"
                            class="flex-1 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-sm font-bold shadow-sm transition flex items-center justify-center space-x-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <span>Filter</span>
                        </button>
                        @if(request('search') || request('stok_bantuan_id') || request('tipe'))
                            <a href="{{ route('stok-mutasi.index') }}" title="Reset Filter"
                               class="px-3 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm flex items-center justify-center transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            <!-- Tabel Data Mutasi Logistik -->
            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-100 text-xs uppercase text-slate-700 font-bold border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-4 py-3.5">Waktu Pencatatan</th>
                            <th scope="col" class="px-4 py-3.5">Komoditas Barang</th>
                            <th scope="col" class="px-4 py-3.5 text-center">Tipe Mutasi</th>
                            <th scope="col" class="px-4 py-3.5 text-right">Volume Mutasi</th>
                            <th scope="col" class="px-4 py-3.5">Keterangan Sumber / Alasan</th>
                            <th scope="col" class="px-4 py-3.5">Operator Pencatat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($mutasi as $m)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-4 py-3.5 text-xs text-slate-600 font-medium whitespace-nowrap">
                                    <div class="font-bold text-slate-800">{{ $m->created_at->format('d M Y') }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $m->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-4 py-3.5">
                                    <div class="font-bold text-slate-900">{{ $m->stokBantuan?->nama_barang ?? '-' }}</div>
                                    <div class="text-xs text-slate-500 font-semibold text-blue-700">Satuan: {{ $m->stokBantuan?->satuan ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    @if ($m->tipe === 'masuk')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                            <span class="mr-1">↑</span> Masuk
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-300">
                                            <span class="mr-1">↓</span> Keluar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-right font-mono font-bold text-base whitespace-nowrap
                                    {{ $m->tipe === 'masuk' ? 'text-emerald-700' : 'text-rose-700' }}">
                                    {{ $m->tipe === 'masuk' ? '+' : '-' }}{{ number_format($m->jumlah) }}
                                    <span class="text-xs font-normal text-slate-500">{{ $m->stokBantuan?->satuan }}</span>
                                </td>
                                <td class="px-4 py-3.5 text-xs text-slate-700 max-w-sm leading-relaxed">
                                    {{ $m->keterangan ?? '-' }}
                                </td>
                                <td class="px-4 py-3.5 text-xs">
                                    <div class="font-bold text-slate-800">{{ $m->user?->name ?? 'Admin Sistem' }}</div>
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] uppercase font-semibold bg-slate-100 text-slate-600 border border-slate-200 mt-0.5">
                                        {{ $m->user?->role ?? 'Operator' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-slate-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <p class="font-bold text-slate-700 text-base">Belum Ada Catatan Mutasi Stok</p>
                                    <p class="text-xs text-slate-400 mt-1 max-w-md mx-auto">
                                        Data mutasi keluar-masuk barang bansos akan muncul di sini saat Admin mencatat pengadaan baru atau realisasi penyaluran lapangan.
                                    </p>
                                    <div class="mt-4">
                                        <a href="{{ route('stok-mutasi.create') }}"
                                           class="inline-flex items-center space-x-2 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-xs font-bold transition shadow-sm">
                                            <span>+ Catat Mutasi Masuk Sekarang (PBI-016)</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pt-2">
                {{ $mutasi->links() }}
            </div>

        </div>

    </div>

</body>
</html>
