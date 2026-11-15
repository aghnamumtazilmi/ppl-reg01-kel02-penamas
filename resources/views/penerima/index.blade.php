<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penerima Bantuan - PENAMAS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen py-10">

    <div class="max-w-6xl mx-auto px-4">
        
        <!-- Header Proyek -->
        <div class="bg-emerald-700 text-white rounded-t-2xl p-6 shadow-md flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold">Daftar Keluarga Penerima Manfaat (KPM)</h1>
                <p class="text-emerald-100 text-sm mt-1">PENAMAS — Sistem Informasi Pengelolaan Bantuan Pangan Masyarakat</p>
            </div>
            <div>
                <a href="{{ route('penerima.create') }}" class="inline-flex items-center space-x-2 px-5 py-2.5 bg-emerald-800 hover:bg-emerald-900 border border-emerald-600 text-white font-semibold rounded-lg shadow-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Penerima Baru</span>
                </a>
            </div>
        </div>

        <!-- Kontainer Utama -->
        <div class="bg-white rounded-b-2xl shadow-md p-6 border border-slate-200 border-t-0">
            
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg text-emerald-800 text-sm flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Form Pencarian (NIK / Nama) & Filter Wilayah Kecamatan -->
            <form action="{{ route('penerima.index') }}" method="GET" class="mb-6 bg-slate-50 p-4 rounded-xl border border-slate-200">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                    
                    <!-- Kotak Pencarian NIK atau Nama -->
                    <div class="md:col-span-5">
                        <label for="search" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">
                            Cari Berdasarkan NIK atau Nama
                        </label>
                        <div class="relative">
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Ketik NIK 16 digit atau nama warga..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Pilihan Filter Kecamatan (Lengkap 27 Kecamatan Kab. Banyumas) -->
                    <div class="md:col-span-4">
                        <label for="kecamatan" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">
                            Wilayah Kecamatan
                        </label>
                        <select name="kecamatan" id="kecamatan"
                            class="w-full px-3 py-2.5 rounded-lg border border-slate-300 text-sm bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">
                            <option value="">-- Semua Kecamatan --</option>
                            @foreach ($daftarKecamatan as $kec)
                                <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>
                                    Kecamatan {{ $kec }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Status Kelayakan -->
                    <div class="md:col-span-2">
                        <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">
                            Status
                        </label>
                        <select name="status" id="status"
                            class="w-full px-3 py-2.5 rounded-lg border border-slate-300 text-sm bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <!-- Tombol Submit & Reset Filter -->
                    <div class="md:col-span-1 flex space-x-1">
                        <button type="submit" title="Cari Data"
                            class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold flex items-center justify-center transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>

                        @if(request('search') || request('kecamatan') || request('status'))
                            <a href="{{ route('penerima.index') }}" title="Reset Filter"
                                class="px-2.5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm flex items-center justify-center transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        @endif
                    </div>

                </div>

                <!-- Indikator Filter yang Sedang Aktif -->
                @if(request('search') || request('kecamatan') || request('status'))
                    <div class="mt-3 pt-3 border-t border-slate-200 text-xs text-slate-500 flex items-center justify-between">
                        <div>
                            Menampilkan hasil untuk:
                            @if(request('search'))
                                <span class="font-semibold text-slate-800">"{{ request('search') }}"</span>
                            @endif
                            @if(request('kecamatan'))
                                pada Kecamatan <span class="font-semibold text-slate-800">{{ request('kecamatan') }}</span>
                            @endif
                            @if(request('status'))
                                status <span class="font-semibold text-slate-800">{{ ucfirst(request('status')) }}</span>
                            @endif
                        </div>
                        <a href="{{ route('penerima.index') }}" class="text-emerald-700 hover:underline font-medium">Hapus Filter</a>
                    </div>
                @endif
            </form>

            <!-- Tabel Data Warga -->
            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-100 text-xs uppercase text-slate-700 font-semibold border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-4 py-3.5">NIK (16 Digit)</th>
                            <th scope="col" class="px-4 py-3.5">Nama Penerima</th>
                            <th scope="col" class="px-4 py-3.5">Alamat / Wilayah</th>
                            <th scope="col" class="px-4 py-3.5">Kontak</th>
                            <th scope="col" class="px-4 py-3.5 text-center">Status</th>
                            <th scope="col" class="px-4 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($penerima as $p)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3 font-mono font-medium text-slate-900">{{ $p->nik }}</td>
                                <td class="px-4 py-3 font-semibold text-slate-900">{{ $p->nama }}</td>
                                <td class="px-4 py-3">
                                    <div class="text-xs text-slate-700 font-medium">{{ $p->alamat }}</div>
                                    <div class="text-xs text-slate-500 font-semibold text-emerald-800">Kec. {{ $p->kecamatan }} • Kel. {{ $p->kelurahan }}</div>
                                </td>
                                <td class="px-4 py-3 text-xs">{{ $p->no_hp ?? '-' }}</td>
                                
                                <!-- Badge Status Aktif / Nonaktif -->
                                <td class="px-4 py-3 text-center">
                                    @if ($p->status === 'aktif')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 border border-rose-300">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <!-- Tombol Edit Data & Status -->
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('penerima.edit', $p->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-300 text-xs font-semibold transition">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Ubah Data
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-400">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="font-medium text-slate-600">Tidak ada data penerima bantuan yang sesuai.</p>
                                    <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian lain atau reset filter kecamatan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $penerima->links() }}
            </div>

        </div>

    </div>

</body>
</html>
