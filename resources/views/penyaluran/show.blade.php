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

            <!-- Notifikasi Validasi Error -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-lg text-rose-800 text-sm">
                    <p class="font-semibold mb-1">Gagal Menyimpan Data:</p>
                    <ul class="list-disc list-inside space-y-0.5 text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
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
            <!-- [PBI-026 & PBI-027] REALISASI PENYERAHAN & FOTO DOKUMENTASI    -->
            <!-- ============================================================= -->

            @if($distribusi->status === 'disalurkan' && $distribusi->realisasi)
                <!-- Kondisi 1: Bantuan Sudah Disalurkan (Tampilkan Realisasi & Foto Bukti PBI-027) -->
                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200 mb-6 shadow-sm">
                    
                    <!-- Header Status Realisasi -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200 mb-5">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-800">Catatan Resmi Realisasi Penyerahan Bantuan</h3>
                                <p class="text-xs text-slate-500">Penyaluran ini telah dicatat dan diverifikasi di sistem.</p>
                            </div>
                        </div>
                        <span class="px-3.5 py-1.5 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                            Status: Disalurkan
                        </span>
                    </div>

                    <!-- Ringkasan Data Serah Terima -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm mb-5">
                        <div class="bg-white p-4 rounded-xl border border-slate-200">
                            <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal Serah Terima</span>
                            <span class="font-bold text-slate-800 text-base">
                                {{ \Carbon\Carbon::parse($distribusi->realisasi->tanggal_penyaluran)->isoFormat('D MMMM Y') }}
                            </span>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-slate-200">
                            <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Jumlah Paket Diserahkan</span>
                            <span class="font-bold text-emerald-700 text-base">
                                {{ $distribusi->realisasi->jumlah_disalurkan }} Paket Sembako
                            </span>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-slate-200">
                            <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Petugas Pencatat</span>
                            <span class="font-semibold text-slate-800 text-base">
                                {{ $distribusi->realisasi->user->name ?? 'Petugas Lapangan' }}
                            </span>
                        </div>
                    </div>

                    @if($distribusi->realisasi->keterangan)
                        <div class="bg-white p-4 rounded-xl border border-slate-200 text-xs mb-6">
                            <span class="block text-slate-500 font-semibold mb-1">Catatan / Keterangan Penyerahan di Lapangan:</span>
                            <p class="text-slate-700 leading-relaxed">{{ $distribusi->realisasi->keterangan }}</p>
                        </div>
                    @endif

                    <!-- [PBI-027] Tampilan Foto Dokumentasi Serah Terima (Besar, Jelas, & Proporsional) -->
                    <div class="pt-5 border-t border-slate-200">
                        <div class="mb-4">
                            <h4 class="text-sm font-bold text-slate-800">Foto Dokumentasi Serah Terima (Bukti Fisik)</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Bukti visual penyerahan bantuan secara nyata kepada warga penerima manfaat di lapangan.</p>
                        </div>

                        @if($distribusi->realisasi->foto_bukti)
                            <!-- ============================================================== -->
                            <!-- TAMPILAN FOTO SUDAH BERHASIL TERUNGGAH (BESAR, JELAS, ELEGAN) -->
                            <!-- ============================================================== -->
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm w-full">
                                
                                <!-- Banner Indikator Sukses yang Sangat Jelas & Tombol Aksi -->
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-xl mb-5">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 rounded-full bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-emerald-900 uppercase tracking-wider">Status Dokumentasi</p>
                                            <h5 class="text-sm font-bold text-emerald-800">Foto Bukti Fisik Berhasil Terunggah & Tersimpan di Sistem</h5>
                                        </div>
                                    </div>
                                    
                                    <!-- Aksi: Buka Ukuran Penuh & Hapus Foto -->
                                    <div class="flex items-center space-x-2 flex-wrap">
                                        <!-- Tombol Buka Ukuran Penuh (Fungsi membuka file resolusi asli di tab baru) -->
                                        <a href="{{ asset($distribusi->realisasi->foto_bukti) }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center space-x-2 px-3.5 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 rounded-lg text-xs font-semibold shadow-sm transition">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                            <span>Buka Ukuran Penuh</span>
                                        </a>

                                        <!-- Tombol Hapus Foto Dokumentasi -->
                                        <form action="{{ route('penyaluran.foto.delete', $distribusi->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto dokumentasi serah terima ini? Berkas foto fisik akan dihapus dari sistem.');"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center space-x-1.5 px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-xs font-semibold shadow-sm transition">
                                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                <span>Hapus Foto</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Bingkai Foto Dokumentasi Ukuran Besar (Bisa Diklik Langsung untuk Ukuran Penuh) -->
                                <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-900/5 p-3 text-center">
                                    <a href="{{ asset($distribusi->realisasi->foto_bukti) }}" target="_blank" rel="noopener noreferrer" title="Klik foto untuk melihat resolusi penuh di tab baru" class="block cursor-zoom-in">
                                        <img src="{{ asset($distribusi->realisasi->foto_bukti) }}" alt="Foto Bukti Penyaluran"
                                            class="w-full max-h-[580px] object-contain rounded-lg mx-auto shadow-sm transition duration-200 hover:opacity-95">
                                    </a>
                                </div>

                                <!-- Bagian Ganti Foto (Teks Netral Bersih dengan Ikon Pensil Edit yang Wajar) -->
                                <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                                    <button type="button" onclick="toggleFormGantiFoto()"
                                        class="text-xs text-slate-500 hover:text-slate-700 font-medium inline-flex items-center space-x-1.5 transition">
                                        <!-- Ikon Pensil / Edit (Bukan Ikon Unggah Panah yang Mengundang) -->
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                        <span>Ubah / Ganti Foto Dokumentasi</span>
                                    </button>

                                    <!-- Form Ganti Foto yang Muncul Tepat di Bawahnya Setelah Teks Diklik -->
                                    <div id="form-ganti-foto-wrap" class="hidden mt-3 p-4 bg-slate-50 rounded-xl border border-slate-200 text-left transition">
                                        <div class="flex items-center justify-between mb-2.5">
                                            <span class="text-xs font-bold text-slate-700">Pilih Berkas Foto Baru:</span>
                                            <button type="button" onclick="toggleFormGantiFoto()" class="text-xs text-slate-400 hover:text-slate-600 font-semibold">
                                                ✕ Batal
                                            </button>
                                        </div>

                                        <form action="{{ route('penyaluran.foto.upload', $distribusi->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                                                <!-- Tombol Pilih File -->
                                                <label for="foto_ganti" class="cursor-pointer inline-flex items-center justify-center space-x-2 px-3.5 py-2.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 text-xs font-semibold shadow-sm transition flex-shrink-0">
                                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span>Pilih Berkas</span>
                                                </label>
                                                <input type="file" id="foto_ganti" name="foto_bukti" accept="image/*" class="hidden" required
                                                    onchange="handleGantiFotoSelect(this)">

                                                <!-- Kotak Teks Nama Berkas -->
                                                <div class="flex-1 px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-500 truncate flex items-center shadow-inner">
                                                    <svg class="w-4 h-4 text-slate-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <span id="label-foto-ganti">Tidak ada berkas baru dipilih</span>
                                                </div>

                                                <!-- Tombol Simpan Perubahan -->
                                                <button type="submit" id="btn-unggah-ganti" disabled
                                                    class="inline-flex items-center justify-center space-x-1.5 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white text-xs font-semibold rounded-lg shadow-sm transition flex-shrink-0">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span>Simpan Perubahan</span>
                                                </button>
                                            </div>

                                            <!-- Pratinjau Mini Jika Ada File Baru Dipilih -->
                                            <div id="preview-ganti-container" class="hidden mt-3 p-3 bg-white rounded-lg border border-slate-200 flex items-center space-x-3">
                                                <img id="preview-ganti-img" src="#" alt="Pratinjau Baru" class="w-12 h-12 object-cover rounded-lg border border-slate-300 shadow-sm">
                                                <div class="text-xs">
                                                    <p class="font-bold text-slate-800">Foto Pengganti Terpilih Siap Disimpan</p>
                                                    <p class="text-slate-500">Klik tombol <strong>Simpan Perubahan</strong> untuk memperbarui foto.</p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        @else
                            <!-- ============================================================== -->
                            <!-- TAMPILAN BELUM ADA FOTO (WIDGET UPLOAD ELEGAN & PROPORSIONAL)  -->
                            <!-- ============================================================== -->
                            <div class="bg-white p-8 rounded-2xl border-2 border-dashed border-emerald-300 text-center max-w-2xl mx-auto shadow-sm">
                                
                                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>

                                <h4 class="text-base font-bold text-slate-800 mb-1">Unggah Foto Dokumentasi Serah Terima</h4>
                                <p class="text-xs text-slate-500 mb-6 max-w-md mx-auto">
                                    Pilih berkas foto serah terima dari komputer Anda (Format: JPG, JPEG, atau PNG, Maksimal 5MB).
                                </p>

                                <form action="{{ route('penyaluran.foto.upload', $distribusi->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <!-- Baris Proporsional: [Pilih File] [Nama Berkas] [Unggah Foto] -->
                                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-4 text-left">
                                        <!-- Tombol Pilih File -->
                                        <label for="foto_upload_langsung" class="cursor-pointer inline-flex items-center justify-center space-x-2 px-4 py-2.5 rounded-lg border border-slate-300 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold shadow-sm transition flex-shrink-0">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>Pilih File</span>
                                        </label>
                                        <input type="file" id="foto_upload_langsung" name="foto_bukti" accept="image/*" class="hidden" required
                                            onchange="handleDirectUploadSelect(this)">

                                        <!-- Wadah Nama Berkas (Pengganti No File Chosen) -->
                                        <div class="flex-1 px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-500 truncate flex items-center shadow-inner">
                                            <svg class="w-4 h-4 text-slate-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span id="label-foto-langsung">Tidak ada berkas yang dipilih</span>
                                        </div>

                                        <!-- Tombol Unggah Foto -->
                                        <button type="submit" id="btn-submit-langsung" disabled
                                            class="inline-flex items-center justify-center space-x-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white text-xs font-semibold rounded-lg shadow-sm transition flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                            </svg>
                                            <span>Unggah Foto</span>
                                        </button>
                                    </div>

                                    <!-- Pratinjau Foto Sebelum Diunggah -->
                                    <div id="preview-langsung-container" class="hidden p-4 bg-slate-50 rounded-xl border border-slate-200 mb-2">
                                        <div class="flex items-center justify-center space-x-4">
                                            <img id="preview-langsung-img" src="#" alt="Pratinjau" class="w-32 h-24 object-cover rounded-lg border border-slate-300 shadow-sm">
                                            <div class="text-left text-xs">
                                                <span class="inline-block px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold mb-1">Siap Diunggah</span>
                                                <p id="preview-langsung-filename" class="font-bold text-slate-800 truncate max-w-xs"></p>
                                                <p class="text-slate-500">Klik tombol <strong>Unggah Foto</strong> di atas untuk menyimpan.</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

            @else
                <!-- Kondisi 2: Bantuan Berstatus Disetujui (Form Realisasi & Upload Foto Sekaligus) -->
                <div class="p-6 bg-emerald-50/50 rounded-2xl border border-emerald-200 mb-6 shadow-sm">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Form Pencatatan Realisasi Penyerahan Bantuan</h3>
                            <p class="text-xs text-slate-600">Isi data serah terima dan unggah foto dokumentasi fisik. Status distribusi akan otomatis berubah menjadi <strong>Disalurkan</strong> setelah disimpan.</p>
                        </div>
                    </div>

                    <form action="{{ route('penyaluran.realisasi.store', $distribusi->id) }}" method="POST" enctype="multipart/form-data" class="mt-5">
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
                        <div class="mb-4">
                            <label for="keterangan" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1">
                                Keterangan / Catatan Serah Terima (Opsional)
                            </label>
                            <textarea name="keterangan" id="keterangan" rows="2"
                                placeholder="Contoh: Paket bantuan pangan telah diserahkan langsung kepada seluruh warga KPM di Balai Desa dengan tertib dan lancar."
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:outline-none text-sm transition">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- [PBI-027] Upload Foto Bukti Dokumentasi Fisik Proporsional -->
                        <div class="mb-6 p-4 bg-white rounded-xl border border-slate-200">
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1">
                                Foto Dokumentasi Serah Terima (Bukti Fisik)
                            </label>
                            <p class="text-xs text-slate-400 mb-3">Unggah foto saat bantuan pangan diserahkan kepada warga (Format: JPG, PNG, JPEG. Maksimal 5MB).</p>
                            
                            <!-- Baris Proporsional: [Pilih File] [Nama Berkas] -->
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                                <label for="foto_bukti_form" class="cursor-pointer inline-flex items-center justify-center space-x-2 px-4 py-2.5 rounded-lg border border-slate-300 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold shadow-sm transition flex-shrink-0">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Pilih File</span>
                                </label>
                                <input type="file" name="foto_bukti" id="foto_bukti_form" accept="image/*" class="hidden"
                                    onchange="previewFormImage(this)">

                                <div class="flex-1 px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-500 truncate flex items-center shadow-inner">
                                    <svg class="w-4 h-4 text-slate-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span id="label-foto-form">Tidak ada berkas yang dipilih</span>
                                </div>
                            </div>

                            <!-- Pratinjau Mini Pada Form -->
                            <div id="preview-form-container" class="hidden mt-3 pt-3 border-t border-slate-200 flex items-center space-x-3">
                                <img id="image-form-preview" src="#" alt="Pratinjau Foto" class="w-14 h-14 object-cover rounded-lg border border-slate-300 shadow-sm">
                                <div class="text-xs">
                                    <span class="inline-block px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold mb-0.5">Foto Terpilih</span>
                                    <p id="file-form-name" class="font-bold text-slate-700 truncate max-w-xs"></p>
                                    <p class="text-slate-400">Foto dokumentasi fisik ini akan tersimpan saat formulir dikirim.</p>
                                </div>
                            </div>

                            @error('foto_bukti')
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
                                <span>Simpan Realisasi & Foto Bukti</span>
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

    <!-- Script JavaScript untuk Custom File Upload & Pratinjau Foto -->
    <script>
        // Preview pada Form Realisasi Awal (Kondisi 2: Bantuan Berstatus Disetujui)
        function previewFormImage(input) {
            const previewContainer = document.getElementById('preview-form-container');
            const preview = document.getElementById('image-form-preview');
            const nameLabel = document.getElementById('file-form-name');
            const btnLabel = document.getElementById('label-foto-form');
            if (input.files && input.files[0]) {
                const file = input.files[0];
                btnLabel.textContent = file.name;
                nameLabel.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        // Handle Pilih Foto pada Kotak Upload Langsung (Saat Status Disalurkan Belum Ada Foto)
        function handleDirectUploadSelect(input) {
            const label = document.getElementById('label-foto-langsung');
            const filenameText = document.getElementById('preview-langsung-filename');
            const submitBtn = document.getElementById('btn-submit-langsung');
            const previewContainer = document.getElementById('preview-langsung-container');
            const previewImg = document.getElementById('preview-langsung-img');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                label.textContent = file.name;
                filenameText.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                submitBtn.removeAttribute('disabled');
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        // Toggle Tampilan Form Ganti Foto
        function toggleFormGantiFoto() {
            const wrap = document.getElementById('form-ganti-foto-wrap');
            wrap.classList.toggle('hidden');
        }

        // Handle Pilih Foto pada Form Ganti/Perbarui Foto (Saat Status Disalurkan Sudah Ada Foto)
        function handleGantiFotoSelect(input) {
            const label = document.getElementById('label-foto-ganti');
            const submitBtn = document.getElementById('btn-unggah-ganti');
            const previewContainer = document.getElementById('preview-ganti-container');
            const previewImg = document.getElementById('preview-ganti-img');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                label.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                submitBtn.removeAttribute('disabled');
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>

</body>
</html>
