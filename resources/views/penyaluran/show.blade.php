<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tugas & Realisasi Penyaluran - PENAMAS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen py-10">

    <div class="max-w-6xl mx-auto px-4">
        
        <!-- Header Proyek -->
        <div class="bg-emerald-700 text-white rounded-t-2xl p-6 shadow-md">
            <div>
                <h1 class="text-2xl font-bold">Detail Tugas & Realisasi Penyaluran</h1>
                <p class="text-emerald-100 text-sm mt-1">PENAMAS — Sistem Informasi Pengelolaan Bantuan Pangan Masyarakat</p>
            </div>
        </div>

        <!-- Kontainer Utama -->
        <div class="bg-white rounded-b-2xl shadow-md p-6 border border-slate-200 border-t-0">
            
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg text-emerald-800 text-sm flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

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
                        @if($distribusi->status === 'disalurkan')
                            <span class="font-semibold px-2.5 py-0.5 rounded-lg bg-blue-50 text-blue-700 border border-blue-200 ml-1 text-xs">
                                Disalurkan
                            </span>
                        @else
                            <span class="font-semibold px-2.5 py-0.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 ml-1 text-xs">
                                Disetujui
                            </span>
                        @endif
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
            <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Daftar Warga (KPM) Wajib Terima Bantuan</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar keluarga penerima manfaat yang berhak menerima penyerahan paket bantuan pada penugasan ini.</p>
                </div>
            </div>

            <!-- Tabel Warga KPM -->
            <div class="overflow-x-auto rounded-lg border border-slate-200 mb-8">
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
                <div class="mb-8">
                    {{ $daftarPenerima->links() }}
                </div>
            @endif

            <!-- ============================================================= -->
            <!-- [PBI-026] PENCATATAN REALISASI PENYERAHAN BANTUAN             -->
            <!-- ============================================================= -->

            @if($distribusi->status === 'disalurkan' && $distribusi->realisasi)
                <!-- Kondisi 1: Bantuan Sudah Disalurkan (Tampilkan Hasil Realisasi) -->
                <div class="p-6 bg-slate-50 rounded-xl border border-slate-200 mb-6">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Bukti Realisasi Penyerahan Bantuan Tercatat Resmi</h3>
                            <p class="text-xs text-slate-500">Rencana distribusi ini telah berhasil disalurkan kepada warga penerima manfaat.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-3 border-t border-slate-200 text-sm">
                        <div>
                            <span class="block text-xs text-slate-500">Tanggal Serah Terima</span>
                            <span class="font-bold text-slate-800">
                                {{ \Carbon\Carbon::parse($distribusi->realisasi->tanggal_penyaluran)->isoFormat('D MMMM Y') }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-500">Jumlah Paket Bantuan Tersalurkan</span>
                            <span class="font-bold text-emerald-700">
                                {{ $distribusi->realisasi->jumlah_disalurkan }} Paket Sembako
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-500">Petugas Pencatat</span>
                            <span class="font-semibold text-slate-800">
                                {{ $distribusi->realisasi->user->name ?? 'Petugas Lapangan' }}
                            </span>
                        </div>
                    </div>

                    @if($distribusi->realisasi->keterangan)
                        <div class="mt-4 pt-3 border-t border-slate-200 text-xs">
                            <span class="block text-slate-500 font-semibold mb-1">Catatan / Keterangan Penyerahan:</span>
                            <p class="text-slate-700 bg-white p-3 rounded-lg border border-slate-200">{{ $distribusi->realisasi->keterangan }}</p>
                        </div>
                    @endif
                </div>

            @else
                <!-- Kondisi 2: Bantuan Berstatus Disetujui (Tampilkan Form Realisasi Penyerahan) -->
                <div class="p-6 bg-emerald-50/50 rounded-xl border border-emerald-200 mb-6">
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Form Pencatatan Realisasi Penyerahan Bantuan</h3>
                            <p class="text-xs text-slate-600">Isi data serah terima di bawah ini. Status distribusi akan otomatis berubah menjadi <strong>Disalurkan</strong> setelah disimpan.</p>
                        </div>
                    </div>

                    <form action="{{ route('penyaluran.realisasi.store', $distribusi->id) }}" method="POST" class="mt-4">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Tanggal Penyerahan (PBI-026 Kriteria 1) -->
                            <div>
                                <label for="tanggal_penyaluran" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1">
                                    Tanggal Penyerahan Bantuan <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="tanggal_penyaluran" id="tanggal_penyaluran"
                                    value="{{ old('tanggal_penyaluran', date('Y-m-d')) }}"
                                    class="w-full px-4 py-2.5 rounded-lg border @error('tanggal_penyaluran') border-rose-400 bg-rose-50 @else border-slate-300 @enderror focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm transition">
                                @error('tanggal_penyaluran')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jumlah Bantuan yang Diserahkan (PBI-026 Kriteria 1) -->
                            <div>
                                <label for="jumlah_disalurkan" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1">
                                    Jumlah Bantuan yang Diserahkan (Paket) <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="jumlah_disalurkan" id="jumlah_disalurkan" min="1"
                                        value="{{ old('jumlah_disalurkan', $distribusi->penerima->count() ?: 1) }}"
                                        class="w-full px-4 py-2.5 rounded-lg border @error('jumlah_disalurkan') border-rose-400 bg-rose-50 @else border-slate-300 @enderror focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm transition pr-16">
                                    <span class="absolute inset-y-0 right-0 pr-4 flex items-center text-xs font-medium text-slate-400 pointer-events-none">Paket</span>
                                </div>
                                @error('jumlah_disalurkan')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Keterangan Serah Terima (PBI-026 Kriteria 1) -->
                        <div class="mb-5">
                            <label for="keterangan" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1">
                                Keterangan / Catatan Serah Terima (Opsional)
                            </label>
                            <textarea name="keterangan" id="keterangan" rows="3"
                                placeholder="Contoh: Paket bantuan pangan telah diserahkan langsung kepada seluruh warga KPM di Balai Desa dengan tertib dan lancar."
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm transition">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Simpan Realisasi -->
                        <div class="flex items-center justify-end pt-3 border-t border-emerald-200">
                            <button type="submit"
                                class="px-6 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-sm transition flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Simpan Realisasi Penyerahan</span>
                            </button>
                        </div>
                    </form>
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
