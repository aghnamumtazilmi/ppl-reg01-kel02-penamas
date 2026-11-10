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
        
        <!-- Header Proyek (Konsisten Hijau Emerald seperti PBI-004) -->
        <div class="bg-emerald-700 text-white rounded-t-2xl p-6 shadow-md flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <span class="bg-emerald-800 text-emerald-200 text-xs font-semibold px-2.5 py-1 rounded-full uppercase tracking-wider">
                    Feature F-02 • Kelola Data Penerima Bantuan
                </span>
                <h1 class="text-2xl font-bold mt-2">Daftar Keluarga Penerima Manfaat (KPM)</h1>
                <p class="text-emerald-100 text-sm mt-1">PENAMAS — Sistem Informasi Pengelolaan Bantuan Pangan Masyarakat</p>
            </div>
            <div>
                <a href="{{ route('penerima.create') }}" class="inline-flex items-center space-x-2 px-5 py-2.5 bg-emerald-800 hover:bg-emerald-900 border border-emerald-600 text-white font-semibold rounded-lg shadow-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Penerima Baru (PBI-004)</span>
                </a>
            </div>
        </div>

        <!-- Kontainer Tabel -->
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

            <!-- Tabel Data Warga -->
            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-100 text-xs uppercase text-slate-700 font-semibold border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-4 py-3.5">NIK (16 Digit)</th>
                            <th scope="col" class="px-4 py-3.5">Nama Penerima</th>
                            <th scope="col" class="px-4 py-3.5">Alamat / Wilayah</th>
                            <th scope="col" class="px-4 py-3.5">Kontak</th>
                            <th scope="col" class="px-4 py-3.5 text-center">Status (PBI-005)</th>
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
                                    <div class="text-xs text-slate-500">Kel. {{ $p->kelurahan }}, Kec. {{ $p->kecamatan }}</div>
                                </td>
                                <td class="px-4 py-3 text-xs">{{ $p->no_hp ?? '-' }}</td>
                                
                                <!-- [PBI-005] Badge Status Aktif / Nonaktif -->
                                <td class="px-4 py-3 text-center">
                                    @if ($p->status === 'aktif')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                            🟢 Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 border border-rose-300">
                                            🔴 Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <!-- [PBI-005] Tombol Edit Data & Status -->
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('penerima.edit', $p->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-300 text-xs font-semibold transition">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Ubah (PBI-005)
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                                    Belum ada data penerima bantuan. Silakan tambah data baru.
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
