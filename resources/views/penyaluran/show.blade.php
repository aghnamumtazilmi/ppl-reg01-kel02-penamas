<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tugas & Daftar Warga Penerima - PENAMAS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen py-10">

    <div class="max-w-6xl mx-auto px-4">
        
        <!-- Header Proyek -->
        <div class="bg-emerald-700 text-white rounded-t-2xl p-6 shadow-md">
            <div>
                <h1 class="text-2xl font-bold">Detail Tugas & Daftar Penerima Manfaat</h1>
                <p class="text-emerald-100 text-sm mt-1">PENAMAS — Sistem Informasi Pengelolaan Bantuan Pangan Masyarakat</p>
            </div>
        </div>

        <!-- Kontainer Utama -->
        <div class="bg-white rounded-b-2xl shadow-md p-6 border border-slate-200 border-t-0">
            
            <!-- Ringkasan Rencana Distribusi (Card Info) -->
            <div class="mb-8 p-5 bg-slate-50 rounded-xl border border-slate-200">
                <div class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Informasi Tugas Distribusi</div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="block text-xs text-slate-500">Kode Distribusi</span>
                        <span class="font-mono font-bold text-emerald-800 text-base">{{ $distribusi->kode }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-500">Wilayah Penyaluran</span>
                        <span class="font-semibold text-slate-800">{{ $distribusi->wilayah }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-500">Periode Penyaluran</span>
                        <span class="font-semibold text-slate-800">{{ $distribusi->periode }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-500">Paket Bantuan</span>
                        <span class="font-semibold text-slate-800">{{ $distribusi->paketBantuan->nama ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-200 grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                    <div>
                        <span class="text-slate-500">Status Distribusi:</span>
                        <span class="font-semibold px-2.5 py-0.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 ml-1 text-xs">
                            {{ ucfirst($distribusi->status) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-slate-500">Petugas Ditugaskan:</span>
                        <span class="font-medium text-slate-800 ml-1">
                            {{ $distribusi->petugas->pluck('name')->join(', ') ?: 'Petugas Lapangan' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-slate-500">Total Wajib Terima:</span>
                        <span class="font-bold text-slate-900 ml-1">{{ $distribusi->penerima->count() }} Warga KPM</span>
                    </div>
                </div>
            </div>

            <!-- Bagian: Daftar Nama Warga yang Wajib Menerima Bantuan (PBI-025 AC 2) -->
            <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Daftar Warga (KPM) Wajib Terima Bantuan</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar keluarga penerima manfaat yang wajib diserahkan bantuan pada penugasan ini.</p>
                </div>
            </div>

            <!-- Tabel Warga KPM -->
            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-100 text-xs uppercase text-slate-700 font-semibold border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                            <th scope="col" class="px-4 py-3">NIK (16 Digit)</th>
                            <th scope="col" class="px-4 py-3">Nama Warga Penerima</th>
                            <th scope="col" class="px-4 py-3">Alamat Lengkap</th>
                            <th scope="col" class="px-4 py-3">Wilayah</th>
                            <th scope="col" class="px-4 py-3 text-center">Status Warga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($daftarPenerima as $index => $warga)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3 text-center text-xs font-medium text-slate-400">
                                    {{ $daftarPenerima->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3 font-mono font-medium text-slate-900">
                                    {{ $warga->nik }}
                                </td>
                                <td class="px-4 py-3 font-semibold text-slate-900">
                                    {{ $warga->nama }}
                                </td>
                                <td class="px-4 py-3 text-xs text-slate-700">
                                    {{ $warga->alamat }}
                                </td>
                                <td class="px-4 py-3 text-xs text-emerald-800 font-medium">
                                    Kec. {{ $warga->kecamatan }} • Kel. {{ $warga->kelurahan }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ ucfirst($warga->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                                    Belum ada data warga yang terdaftar pada rencana distribusi ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Warga -->
            @if($daftarPenerima->hasPages())
                <div class="mt-4">
                    {{ $daftarPenerima->links() }}
                </div>
            @endif

            <!-- Tombol Navigasi Bawah -->
            <div class="flex items-center justify-between pt-6 border-t border-slate-100 mt-6">
                <a href="{{ route('penyaluran.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 text-sm font-medium hover:bg-slate-50 transition flex items-center space-x-1">
                    <span>&larr; Kembali ke Daftar Tugas</span>
                </a>
            </div>

        </div>

    </div>

</body>
</html>
