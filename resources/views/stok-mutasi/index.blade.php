<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Mutasi Stok Gudang - PENAMAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen py-10">

    <div class="max-w-6xl mx-auto px-4">

        <!-- Header -->
        <div class="bg-blue-700 text-white rounded-t-2xl p-6 shadow-md flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold">Riwayat Mutasi Stok Gudang</h1>
                <p class="text-blue-100 text-sm mt-1">F-06 | PBI-016, PBI-017, PBI-018 — Catatan Keluar-Masuk Barang Gudang</p>
            </div>
            <a href="{{ route('stok-mutasi.create') }}"
               class="inline-flex items-center space-x-2 px-5 py-2.5 bg-blue-800 hover:bg-blue-900 border border-blue-600 text-white font-semibold rounded-lg shadow-sm transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Catat Mutasi Masuk</span>
            </a>
        </div>

        <!-- Konten Utama -->
        <div class="bg-white rounded-b-2xl shadow-md p-6 border border-slate-200 border-t-0">

            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg text-emerald-800 text-sm flex items-center space-x-2">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Form Filter --}}
            <form action="{{ route('stok-mutasi.index') }}" method="GET" class="mb-6 bg-slate-50 p-4 rounded-xl border border-slate-200">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">

                    {{-- Filter Nama Barang --}}
                    <div class="md:col-span-5">
                        <label for="barang" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">
                            Cari Nama Barang
                        </label>
                        <input type="text" name="barang" id="barang" value="{{ request('barang') }}"
                            placeholder="Ketik nama barang..."
                            class="w-full px-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    </div>

                    {{-- Filter Tipe Mutasi --}}
                    <div class="md:col-span-4">
                        <label for="tipe" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">
                            Tipe Mutasi
                        </label>
                        <select name="tipe" id="tipe"
                            class="w-full px-3 py-2.5 rounded-lg border border-slate-300 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                            <option value="">-- Semua Tipe --</option>
                            <option value="masuk" {{ request('tipe') === 'masuk' ? 'selected' : '' }}>Masuk (Pengadaan)</option>
                            <option value="keluar" {{ request('tipe') === 'keluar' ? 'selected' : '' }}>Keluar (Penyaluran/Rusak)</option>
                        </select>
                    </div>

                    {{-- Tombol Filter --}}
                    <div class="md:col-span-3 flex space-x-2">
                        <button type="submit"
                            class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition shadow-sm">
                            Cari
                        </button>
                        @if(request('barang') || request('tipe'))
                            <a href="{{ route('stok-mutasi.index') }}"
                               class="px-3 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm flex items-center justify-center transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            {{-- Tabel Riwayat Mutasi --}}
            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-100 text-xs uppercase text-slate-700 font-semibold border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3.5">Tanggal</th>
                            <th class="px-4 py-3.5">Nama Barang</th>
                            <th class="px-4 py-3.5 text-center">Tipe</th>
                            <th class="px-4 py-3.5 text-right">Jumlah</th>
                            <th class="px-4 py-3.5">Keterangan</th>
                            <th class="px-4 py-3.5">Dicatat Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($mutasi as $m)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3 text-xs text-slate-500 whitespace-nowrap">
                                    {{ $m->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-4 py-3 font-semibold text-slate-900">
                                    {{ $m->stokBantuan?->nama_barang ?? '-' }}
                                    <div class="text-xs text-slate-400 font-normal">{{ $m->stokBantuan?->satuan }}</div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($m->tipe === 'masuk')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                            ↑ Masuk
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 border border-rose-300">
                                            ↓ Keluar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right font-mono font-semibold
                                    {{ $m->tipe === 'masuk' ? 'text-emerald-700' : 'text-rose-700' }}">
                                    {{ $m->tipe === 'masuk' ? '+' : '-' }}{{ number_format($m->jumlah) }}
                                </td>
                                <td class="px-4 py-3 text-xs text-slate-600 max-w-xs">{{ $m->keterangan ?? '-' }}</td>
                                <td class="px-4 py-3 text-xs text-slate-500">{{ $m->user?->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-400">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="font-medium text-slate-600">Belum ada riwayat mutasi stok.</p>
                                    <p class="text-xs text-slate-400 mt-1">Klik "Catat Mutasi Masuk" untuk mencatat pengadaan barang pertama.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $mutasi->links() }}
            </div>

        </div>
    </div>

</body>
</html>
