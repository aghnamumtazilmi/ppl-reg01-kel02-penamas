<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Mutasi Keluar Stok Gudang - PENAMAS</title>
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
    @include('stok-mutasi.partials.sidebar', ['active' => 'mutasi-keluar'])

    <!-- Kontainer Halaman Utama di Sebelah Kanan Sidebar -->
    <div class="md:pl-64 lg:pl-72 flex flex-col min-h-screen bg-slate-50 transition-all duration-300">

        <!-- Top Navigation Bar (Header dengan Tombol Kembali ke Halaman Sebelumnya) -->
        <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200/90 px-4 sm:px-8 py-3.5 flex items-center justify-between shadow-xs">
            <div class="flex items-center space-x-3">
                <!-- Tombol Toggle Sidebar untuk Mobile -->
                <button type="button" 
                        onclick="toggleSidebar()" 
                        class="md:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Tombol Kembali ke Buku Riwayat Mutasi -->
                <a href="{{ route('stok-mutasi.index') }}" 
                   class="inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-blue-700 text-xs font-bold transition shadow-2xs group"
                   title="Kembali ke Buku Riwayat Mutasi">
                    <svg class="w-4 h-4 text-slate-500 group-hover:text-blue-600 group-hover:-translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>&larr; Kembali ke Buku Mutasi</span>
                </a>

                <!-- Breadcrumbs Navigasi -->
                <nav class="hidden sm:flex items-center space-x-2 text-xs text-slate-400 pl-2">
                    <span>/</span>
                    <a href="{{ route('stok.index') }}" class="hover:text-blue-700 transition">Logistik Gudang</a>
                    <span>/</span>
                    <a href="{{ route('stok-mutasi.index') }}" class="hover:text-blue-700 transition">Buku Mutasi</a>
                    <span>/</span>
                    <span class="text-slate-800 font-bold">Catat Pengeluaran Manual</span>
                </nav>
            </div>

            <!-- Tombol Pintas Ke Master Stok -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('stok.index') }}"
                   class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-800 text-xs font-semibold transition">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span>Ke Master Stok</span>
                </a>
            </div>
        </header>

        <!-- Area Konten Form -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-4xl w-full mx-auto space-y-6">

            <!-- Header Card Banner -->
            <div class="bg-gradient-to-r from-rose-700 via-rose-800 to-red-900 text-white rounded-2xl p-6 sm:p-7 shadow-lg border border-rose-600/30 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center space-x-2 px-2.5 py-1 rounded-full bg-rose-500/20 border border-rose-400/30 text-xs font-semibold text-rose-100 mb-2">
                        <span class="w-2 h-2 rounded-full bg-rose-400 animate-pulse"></span>
                        <span>Pengurangan Kuantitas Fisik Gudang Dinsospermades</span>
                    </div>
                    <h1 class="text-2xl font-extrabold tracking-tight">Formulir Mutasi Barang Keluar Manual</h1>
                    <p class="text-rose-100 text-xs sm:text-sm mt-1 leading-relaxed">
                        Mencatat pengurangan stok gudang karena barang rusak, kadaluarsa, penyusutan fisik timbangan, atau distribusi darurat bencana.
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('stok-mutasi.index') }}"
                       class="inline-flex items-center space-x-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold rounded-xl text-xs backdrop-blur-sm transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Lihat Riwayat</span>
                    </a>
                </div>
            </div>

            <!-- Form Card Container -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/90 p-6 sm:p-8">

                {{-- Alert Error Global --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-2xl">
                        <div class="flex items-center space-x-2 text-rose-800 font-bold text-sm mb-1">
                            <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Gagal Menyimpan! Terdapat {{ $errors->count() }} kesalahan input:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs text-rose-700 space-y-0.5 ml-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Peringatan Real-Time Melebihi Stok Tersedia -->
                <div id="alertOverStock" class="hidden mb-6 p-4 bg-rose-50 border-2 border-rose-500 rounded-2xl text-rose-900 shadow-sm animate-pulse">
                    <div class="flex items-start space-x-3">
                        <div class="p-1 rounded-lg bg-rose-200 text-rose-800 mt-0.5 flex-shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <span class="font-extrabold text-sm block">Peringatan: Jumlah Keluar Melebihi Stok Tersedia!</span>
                            <p class="text-xs text-rose-700 mt-0.5 leading-relaxed" id="textAlertOverStock">
                                Sistem menolak pengeluaran karena stok di gudang tidak mencukupi untuk dikeluarkan.
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('stok-mutasi.store-keluar') }}" method="POST" class="space-y-6" id="formMutasiKeluar">
                    @csrf

                    <!-- PILIH KOMODITAS BARANG -->
                    <div>
                        <label for="stok_bantuan_id" class="block text-sm font-bold text-slate-800 mb-1.5">
                            Pilih Nama Komoditas Barang <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-xs text-slate-500 mb-2">Pilih bahan pangan di gudang yang akan dikurangi stoknya.</p>
                        <div class="relative">
                            <select name="stok_bantuan_id" id="stok_bantuan_id" required
                                class="w-full px-4 py-3 rounded-xl border @error('stok_bantuan_id') border-rose-400 bg-rose-50 @else border-slate-300 @enderror text-sm bg-white font-medium focus:ring-2 focus:ring-rose-500 focus:border-rose-500 focus:outline-none transition appearance-none">
                                <option value="" data-satuan="" data-jumlah="0">-- Pilih Komoditas Pangan --</option>
                                @foreach ($daftarBarang as $barang)
                                    <option value="{{ $barang->id }}" 
                                            data-satuan="{{ $barang->satuan }}"
                                            data-jumlah="{{ $barang->jumlah }}"
                                            data-nama="{{ $barang->nama_barang }}"
                                            {{ old('stok_bantuan_id') == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->nama_barang }} &nbsp;&mdash;&nbsp; Stok Barang Tersedia: {{ number_format($barang->jumlah) }} {{ $barang->satuan }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        @error('stok_bantuan_id')
                            <p class="mt-1.5 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- TIPE PENGELUARAN BARANG -->
                    <div>
                        <label for="tipe_keluar" class="block text-sm font-bold text-slate-800 mb-1.5">
                            Kategori Alasan Pengeluaran <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-xs text-slate-500 mb-2">Tentukan klasifikasi penyebab berkurangnya bahan pangan dari gudang.</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <label class="flex items-center p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                                <input type="radio" name="tipe_keluar" value="Barang Rusak" class="text-rose-600 focus:ring-rose-500"
                                    {{ old('tipe_keluar', 'Barang Rusak') === 'Barang Rusak' ? 'checked' : '' }} onchange="updateTipeKeluar(this.value)">
                                <div class="ml-3">
                                    <span class="text-xs font-bold text-slate-800 block">Barang Rusak / Kemasan Robek</span>
                                    <span class="text-[11px] text-slate-500">Kerusakan fisik saat penyimpanan</span>
                                </div>
                            </label>

                            <label class="flex items-center p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                                <input type="radio" name="tipe_keluar" value="Kadaluarsa" class="text-rose-600 focus:ring-rose-500"
                                    {{ old('tipe_keluar') === 'Kadaluarsa' ? 'checked' : '' }} onchange="updateTipeKeluar(this.value)">
                                <div class="ml-3">
                                    <span class="text-xs font-bold text-slate-800 block">Kadaluarsa / Tak Layak Konsumsi</span>
                                    <span class="text-[11px] text-slate-500">Melewati batas waktu aman pangan</span>
                                </div>
                            </label>

                            <label class="flex items-center p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                                <input type="radio" name="tipe_keluar" value="Penyusutan / Selisih Fisik" class="text-rose-600 focus:ring-rose-500"
                                    {{ old('tipe_keluar') === 'Penyusutan / Selisih Fisik' ? 'checked' : '' }} onchange="updateTipeKeluar(this.value)">
                                <div class="ml-3">
                                    <span class="text-xs font-bold text-slate-800 block">Penyusutan / Selisih Fisik</span>
                                    <span class="text-[11px] text-slate-500">Susut berat timbangan / audit stock opname</span>
                                </div>
                            </label>

                            <label class="flex items-center p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                                <input type="radio" name="tipe_keluar" value="Distribusi Darurat / Khusus" class="text-rose-600 focus:ring-rose-500"
                                    {{ old('tipe_keluar') === 'Distribusi Darurat / Khusus' ? 'checked' : '' }} onchange="updateTipeKeluar(this.value)">
                                <div class="ml-3">
                                    <span class="text-xs font-bold text-slate-800 block">Distribusi Tanggap Darurat Bencana</span>
                                    <span class="text-[11px] text-slate-500">Bencana banjir, longsor, atau kebakaran</span>
                                </div>
                            </label>
                        </div>
                        @error('tipe_keluar')
                            <p class="mt-1.5 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- JUMLAH VOLUME KELUAR -->
                    <div>
                        <label for="jumlah" class="block text-sm font-bold text-slate-800 mb-1.5">
                            Jumlah Volume Barang Keluar <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-xs text-slate-500 mb-2">Jumlah kuantitas yang dikeluarkan (tidak boleh melebihi stok yang tersedia).</p>
                        <div class="relative rounded-xl shadow-xs">
                            <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}"
                                min="1" required placeholder="Contoh: 15"
                                class="w-full pl-4 pr-24 py-3 rounded-xl border @error('jumlah') border-rose-400 bg-rose-50 @else border-slate-300 @enderror text-sm font-bold text-slate-800 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 focus:outline-none transition">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider bg-slate-100 px-2.5 py-1 rounded-md" id="badgeSatuan">
                                    Unit
                                </span>
                            </div>
                        </div>
                        @error('jumlah')
                            <p class="mt-1.5 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SIMULASI REAL-TIME PENGURANGAN STOK -->
                    <div id="boxSimulasi" class="hidden p-4 rounded-2xl bg-gradient-to-r from-rose-50 via-slate-50 to-orange-50 border border-rose-200">
                        <div class="flex items-center justify-between text-xs text-rose-900 mb-2">
                            <span class="font-bold flex items-center space-x-1.5">
                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <span>Proyeksi Sisa Stok Gudang</span>
                            </span>
                            <span class="text-[11px] text-rose-700 font-semibold bg-rose-100 px-2 py-0.5 rounded-full">Proteksi Stok Minus</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2.5 text-center pt-1">
                            <div class="bg-white/90 p-3 rounded-xl border border-slate-200">
                                <span class="text-[11px] text-slate-500 block">Stok Barang Tersedia</span>
                                <span class="text-sm font-bold text-slate-800" id="simSaldoLama">0</span>
                            </div>
                            <div class="bg-rose-50 p-3 rounded-xl border border-rose-200">
                                <span class="text-[11px] text-rose-700 block">&minus; Jumlah Keluar</span>
                                <span class="text-sm font-extrabold text-rose-700" id="simJumlahKeluar">-0</span>
                            </div>
                            <div class="p-3 rounded-xl shadow-sm text-white" id="boxSimSisa">
                                <span class="text-[11px] text-slate-100 block">Sisa Stok Gudang</span>
                                <span class="text-sm font-extrabold" id="simSaldoBaru">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- KETERANGAN / ALASAN PENGELUARAN -->
                    <div>
                        <label for="keterangan" class="block text-sm font-bold text-slate-800 mb-1.5">
                            Rincian Alasan Pengeluaran Barang <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-xs text-slate-500 mb-2">
                            Tuliskan kronologi, lokasi kejadian bencana, nomor Berita Acara pemusnahan barang, atau saksi petugas.
                        </p>
                        <textarea name="keterangan" id="keterangan" rows="3" required
                            placeholder="Contoh: Pemusnahan 15 kg beras yang basah terkena rembesan atap gudang saat hujan lebat. Telah diverifikasi Koordinator Gudang."
                            class="w-full px-4 py-3 rounded-xl border @error('keterangan') border-rose-400 bg-rose-50 @else border-slate-300 @enderror text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 focus:outline-none transition resize-none">{{ old('keterangan') }}</textarea>
                        
                        <!-- Rekomendasi Alasan Cepat -->
                        <div class="mt-2.5 flex flex-wrap items-center gap-1.5">
                            <span class="text-[11px] text-slate-400 font-semibold mr-1">Rekomendasi Cepat:</span>
                            <button type="button" onclick="setKeteranganAlasan('Kerusakan kemasan karung akibat rembesan air di Gudang Logistik B')"
                                class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-rose-50 hover:text-rose-700 border border-slate-200 text-slate-600 transition">
                                + Kemasan Basah/Rusak
                            </button>
                            <button type="button" onclick="setKeteranganAlasan('Bahan pangan telah melewati masa simpan aman (kadaluarsa) sesuai BA No. 04/BA-MUSNAH/2026')"
                                class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-rose-50 hover:text-rose-700 border border-slate-200 text-slate-600 transition">
                                + Kadaluarsa Berita Acara
                            </button>
                            <button type="button" onclick="setKeteranganAlasan('Penyusutan susut timbangan alami selama penyimpanan kuartal 4')"
                                class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-rose-50 hover:text-rose-700 border border-slate-200 text-slate-600 transition">
                                + Susut Timbangan
                            </button>
                            <button type="button" onclick="setKeteranganAlasan('Penyaluran darurat tanggap bencana tanah longsor Desa Karangtengah Kec. Cilongok')"
                                class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-rose-50 hover:text-rose-700 border border-slate-200 text-slate-600 transition">
                                + Darurat Bencana
                            </button>
                        </div>

                        @error('keterangan')
                            <p class="mt-1.5 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Integritas Transaksi Data -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 flex items-start space-x-3">
                        <div class="p-1 rounded-lg bg-rose-100 text-rose-700 mt-0.5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold text-slate-800">Integritas Transaksi Terjamin (Pessimistic Locking):</span>
                            <p class="text-slate-500 mt-0.5">
                                Sistem mengunci baris data di basis data saat transaksi berlangsung untuk menjamin tidak terjadi *race condition* atau saldo minus. Semua pengurangan tercatat di buku besar mutasi.
                            </p>
                        </div>
                    </div>

                    <!-- Tombol Aksi Submit & Batal -->
                    <div class="flex items-center justify-end space-x-3 pt-5 border-t border-slate-200">
                        <a href="{{ route('stok-mutasi.index') }}"
                           class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-100 transition">
                            Batal
                        </a>
                        <button type="submit" id="btnSubmitKeluar"
                            class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 focus:ring-4 focus:ring-rose-200 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/>
                            </svg>
                            <span>Simpan Mutasi Keluar</span>
                        </button>
                    </div>

                </form>
            </div>

        </main>

        <!-- Footer -->
        <footer class="mt-auto py-4 px-6 border-t border-slate-200/80 bg-white text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} PENAMAS &mdash; Sistem Informasi Manajemen Bantuan Pangan Dinsospermades Kabupaten Banyumas.
        </footer>

    </div>

    <!-- Script Dynamic UI, Validasi Over-Stock, & Simulasi Pengurangan -->
    <script>
        const selectBarang     = document.getElementById('stok_bantuan_id');
        const inputJumlah      = document.getElementById('jumlah');
        const badgeSatuan      = document.getElementById('badgeSatuan');
        const boxSimulasi      = document.getElementById('boxSimulasi');
        const simSaldoLama     = document.getElementById('simSaldoLama');
        const simJumlahKeluar  = document.getElementById('simJumlahKeluar');
        const simSaldoBaru     = document.getElementById('simSaldoBaru');
        const boxSimSisa       = document.getElementById('boxSimSisa');
        const alertOverStock   = document.getElementById('alertOverStock');
        const textAlertOverStock = document.getElementById('textAlertOverStock');
        const btnSubmitKeluar  = document.getElementById('btnSubmitKeluar');

        function updateSimulasi() {
            const selectedOpt = selectBarang.options[selectBarang.selectedIndex];
            const satuan = selectedOpt.getAttribute('data-satuan') || 'Unit';
            const namaBarang = selectedOpt.getAttribute('data-nama') || 'Komoditas';
            const saldoLama = parseInt(selectedOpt.getAttribute('data-jumlah') || 0);
            const keluar = parseInt(inputJumlah.value) || 0;

            badgeSatuan.textContent = satuan;

            if (selectBarang.value) {
                boxSimulasi.classList.remove('hidden');
                simSaldoLama.textContent = saldoLama.toLocaleString('id-ID') + ' ' + satuan;
                simJumlahKeluar.textContent = '-' + keluar.toLocaleString('id-ID') + ' ' + satuan;

                const sisa = saldoLama - keluar;

                if (keluar > saldoLama) {
                    // KONDISI OVER-STOCK: KELUAR MELEBIHI SALDO
                    alertOverStock.classList.remove('hidden');
                    textAlertOverStock.textContent = `Jumlah keluar (${keluar.toLocaleString('id-ID')} ${satuan}) melebihi stok ${namaBarang} yang tersedia di gudang (${saldoLama.toLocaleString('id-ID')} ${satuan})! Sistem memblokir pengeluaran agar saldo tidak minus.`;
                    
                    simSaldoBaru.textContent = sisa.toLocaleString('id-ID') + ' ' + satuan + ' (MINUS)';
                    boxSimSisa.className = 'p-3 rounded-xl shadow-sm text-white bg-rose-700 animate-pulse';
                    
                    btnSubmitKeluar.disabled = true;
                    btnSubmitKeluar.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    // KONDISI NORMAL
                    alertOverStock.classList.add('hidden');
                    simSaldoBaru.textContent = sisa.toLocaleString('id-ID') + ' ' + satuan;
                    boxSimSisa.className = 'p-3 rounded-xl shadow-sm text-white bg-emerald-700';
                    
                    btnSubmitKeluar.disabled = false;
                    btnSubmitKeluar.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            } else {
                boxSimulasi.classList.add('hidden');
                alertOverStock.classList.add('hidden');
            }
        }

        function setKeteranganAlasan(teks) {
            document.getElementById('keterangan').value = teks;
            document.getElementById('keterangan').focus();
        }

        function updateTipeKeluar(tipe) {
            // Optional hook jika user memilih radio button
        }

        selectBarang.addEventListener('change', updateSimulasi);
        inputJumlah.addEventListener('input', updateSimulasi);

        // Inisialisasi awal saat halaman dibuka
        updateSimulasi();
    </script>

</body>
</html>
