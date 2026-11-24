<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Mutasi Masuk Stok Gudang - PENAMAS</title>
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
    @include('stok-mutasi.partials.sidebar', ['active' => 'mutasi-masuk'])

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
                    <span class="text-slate-800 font-bold">Catat Barang Masuk</span>
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
            <div class="bg-gradient-to-r from-blue-700 via-blue-800 to-indigo-900 text-white rounded-2xl p-6 sm:p-7 shadow-lg border border-blue-600/30 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center space-x-2 px-2.5 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-xs font-semibold text-blue-100 mb-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Penerimaan Bahan Pangan Gudang Dinsospermades</span>
                    </div>
                    <h1 class="text-2xl font-extrabold tracking-tight">Formulir Mutasi Barang Masuk</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-1 leading-relaxed">
                        Mencatat penerimaan komoditas bansos dari pengadaan dinas, donatur swasta, BAZNAS, atau cadangan pangan BULOG.
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

                <form action="{{ route('stok-mutasi.store') }}" method="POST" class="space-y-6" id="formMutasiMasuk">
                    @csrf

                    <!-- PILIH NAMA KOMODITAS BARANG -->
                    <div>
                        <label for="stok_bantuan_id" class="block text-sm font-bold text-slate-800 mb-1.5">
                            Pilih Nama Komoditas Barang <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-xs text-slate-500 mb-2">Pilih bahan pangan yang diterima ke dalam gudang Dinsospermades Kab. Banyumas.</p>
                        <div class="relative">
                            <select name="stok_bantuan_id" id="stok_bantuan_id" required
                                class="w-full px-4 py-3 rounded-xl border @error('stok_bantuan_id') border-rose-400 bg-rose-50 @else border-slate-300 @enderror text-sm bg-white font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition appearance-none">
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

                    <!-- JUMLAH VOLUME MASUK -->
                    <div>
                        <label for="jumlah" class="block text-sm font-bold text-slate-800 mb-1.5">
                            Jumlah Volume Masuk <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-xs text-slate-500 mb-2">Kuantitas fisik barang yang diserahterimakan ke gudang.</p>
                        <div class="relative rounded-xl shadow-xs">
                            <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}"
                                min="1" required placeholder="Contoh: 500"
                                class="w-full pl-4 pr-24 py-3 rounded-xl border @error('jumlah') border-rose-400 bg-rose-50 @else border-slate-300 @enderror text-sm font-bold text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
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

                    <!-- SIMULASI REAL-TIME PENAMBAHAN STOK -->
                    <div id="boxSimulasi" class="hidden p-4 rounded-2xl bg-gradient-to-r from-blue-50 via-indigo-50 to-slate-50 border border-blue-200">
                        <div class="flex items-center justify-between text-xs text-blue-900 mb-2">
                            <span class="font-bold flex items-center space-x-1.5">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <span>Simulasi Akumulasi Stok Otomatis</span>
                            </span>
                            <span class="text-[11px] text-blue-600 font-semibold bg-blue-100 px-2 py-0.5 rounded-full">Auto-Calculate</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2.5 text-center pt-1">
                            <div class="bg-white/90 p-3 rounded-xl border border-blue-100">
                                <span class="text-[11px] text-slate-500 block">Stok Barang Tersedia</span>
                                <span class="text-sm font-bold text-slate-800" id="simSaldoLama">0</span>
                            </div>
                            <div class="bg-emerald-50 p-3 rounded-xl border border-emerald-200">
                                <span class="text-[11px] text-emerald-700 block">+ Jumlah Masuk</span>
                                <span class="text-sm font-extrabold text-emerald-700" id="simJumlahMasuk">+0</span>
                            </div>
                            <div class="bg-blue-600 text-white p-3 rounded-xl shadow-sm">
                                <span class="text-[11px] text-blue-100 block">Total Estimasi Stok</span>
                                <span class="text-sm font-extrabold" id="simSaldoBaru">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- KETERANGAN SUMBER BARANG -->
                    <div>
                        <label for="keterangan" class="block text-sm font-bold text-slate-800 mb-1.5">
                            Keterangan Sumber Barang <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-xs text-slate-500 mb-2">
                            Tuliskan nomor Berita Acara, asal pengadaan dinas, donatur, atau pihak pengirim.
                        </p>
                        <textarea name="keterangan" id="keterangan" rows="3" required
                            placeholder="Contoh: Pengadaan Beras Cadangan Pangan Pemerintah Daerah (APBD Banyumas 2026) No. BA: 024/BA-PANGAN/XI/2026"
                            class="w-full px-4 py-3 rounded-xl border @error('keterangan') border-rose-400 bg-rose-50 @else border-slate-300 @enderror text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition resize-none">{{ old('keterangan') }}</textarea>
                        
                        <!-- Preset Cepat Sumber Barang -->
                        <div class="mt-2.5 flex flex-wrap items-center gap-1.5">
                            <span class="text-[11px] text-slate-400 font-semibold mr-1">Rekomendasi Cepat:</span>
                            <button type="button" onclick="setKeterangan('Pengadaan APBD Dinsospermades Kab. Banyumas TA 2026')"
                                class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-blue-50 hover:text-blue-700 border border-slate-200 text-slate-600 transition">
                                + APBD Dinsospermades
                            </button>
                            <button type="button" onclick="setKeterangan('Bantuan Cadangan Pangan Perum BULOG KC Banyumas')"
                                class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-blue-50 hover:text-blue-700 border border-slate-200 text-slate-600 transition">
                                + BULOG KC Banyumas
                            </button>
                            <button type="button" onclick="setKeterangan('Donasi Sembako BAZNAS Kabupaten Banyumas')"
                                class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-blue-50 hover:text-blue-700 border border-slate-200 text-slate-600 transition">
                                + BAZNAS Banyumas
                            </button>
                            <button type="button" onclick="setKeterangan('Hibah CSR Pangan PT. Sinar Harapan Banyumas')"
                                class="text-[11px] px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-blue-50 hover:text-blue-700 border border-slate-200 text-slate-600 transition">
                                + CSR Perusahaan
                            </button>
                        </div>

                        @error('keterangan')
                            <p class="mt-1.5 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Integritas Transaksi Data -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 flex items-start space-x-3">
                        <div class="p-1 rounded-lg bg-emerald-100 text-emerald-700 mt-0.5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold text-slate-800">Integritas Transaksi Terjamin (Atomicity):</span>
                            <p class="text-slate-500 mt-0.5">
                                Sistem secara atomik mencatat bukti mutasi ke buku besar dan langsung menambah saldo pada master stok. Riwayat diaudit atas nama akun Petugas Gudang yang sedang bertugas.
                            </p>
                        </div>
                    </div>

                    <!-- Tombol Aksi Submit & Batal -->
                    <div class="flex items-center justify-end space-x-3 pt-5 border-t border-slate-200">
                        <a href="{{ route('stok-mutasi.index') }}"
                           class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-100 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-200 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Simpan Mutasi Masuk</span>
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

    <!-- Script Dynamic UI & Simulasi Penambahan Stok -->
    <script>
        const selectBarang = document.getElementById('stok_bantuan_id');
        const inputJumlah  = document.getElementById('jumlah');
        const badgeSatuan  = document.getElementById('badgeSatuan');
        const boxSimulasi  = document.getElementById('boxSimulasi');
        const simSaldoLama = document.getElementById('simSaldoLama');
        const simJumlahMasuk = document.getElementById('simJumlahMasuk');
        const simSaldoBaru = document.getElementById('simSaldoBaru');

        function updateSimulasi() {
            const selectedOpt = selectBarang.options[selectBarang.selectedIndex];
            const satuan = selectedOpt.getAttribute('data-satuan') || 'Unit';
            const saldoLama = parseInt(selectedOpt.getAttribute('data-jumlah') || 0);
            const masuk = parseInt(inputJumlah.value) || 0;

            badgeSatuan.textContent = satuan;

            if (selectBarang.value) {
                boxSimulasi.classList.remove('hidden');
                simSaldoLama.textContent = saldoLama.toLocaleString('id-ID') + ' ' + satuan;
                simJumlahMasuk.textContent = '+' + masuk.toLocaleString('id-ID') + ' ' + satuan;
                simSaldoBaru.textContent = (saldoLama + masuk).toLocaleString('id-ID') + ' ' + satuan;
            } else {
                boxSimulasi.classList.add('hidden');
            }
        }

        function setKeterangan(teks) {
            document.getElementById('keterangan').value = teks;
            document.getElementById('keterangan').focus();
        }

        selectBarang.addEventListener('change', updateSimulasi);
        inputJumlah.addEventListener('input', updateSimulasi);

        // Inisialisasi awal saat halaman termuat
        updateSimulasi();
    </script>

</body>
</html>
