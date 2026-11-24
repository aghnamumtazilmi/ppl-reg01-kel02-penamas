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

    <!-- Universal Navigation Bar -->
    @include('layouts.navbar')

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 w-full flex-1">

        <!-- Navigasi Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-4">
            <a href="{{ route('stok.index') }}" class="hover:text-blue-700 transition flex items-center space-x-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Menu Utama</span>
            </a>
            <span>/</span>
            <a href="{{ route('stok-mutasi.index') }}" class="hover:text-blue-700 transition">Mutasi Stok</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Catat Mutasi Keluar</span>
        </nav>

        <!-- Header Card -->
        <div class="bg-gradient-to-r from-rose-700 via-rose-800 to-red-900 text-white rounded-t-2xl p-6 shadow-lg flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-2 px-2.5 py-1 rounded-full bg-rose-600/60 border border-rose-400/30 text-xs font-semibold text-rose-100 mb-2">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span>Pengeluaran Bahan Pangan Gudang</span>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight">Pencatatan Mutasi Barang Keluar</h1>
                <p class="text-rose-100 text-sm mt-1">
                    Mencatat pengeluaran stok manual untuk barang rusak, kadaluarsa, susut, atau penyaluran darurat.
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('stok-mutasi.index') }}"
                   class="inline-flex items-center space-x-1.5 px-3 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold rounded-xl text-xs backdrop-blur-sm transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Riwayat Mutasi</span>
                </a>
                <a href="{{ route('stok.index') }}"
                   class="inline-flex items-center space-x-1.5 px-3.5 py-2 bg-white/20 hover:bg-white/30 border border-white/30 text-white font-bold rounded-xl text-xs backdrop-blur-sm transition shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Menu Utama</span>
                </a>
            </div>
        </div>

        <!-- Form Card Container -->
        <div class="bg-white rounded-b-2xl shadow-xl p-6 sm:p-8 border border-slate-200 border-t-0">

            {{-- Alert Error Global --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl">
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

            <form action="{{ route('stok-mutasi.store-keluar') }}" method="POST" class="space-y-6" id="formMutasiKeluar">
                @csrf

                <!-- [Kriteria 1] PILIH NAMA KOMODITAS BARANG -->
                <div>
                    <label for="stok_bantuan_id" class="block text-sm font-bold text-slate-800 mb-1.5">
                        Pilih Nama Komoditas Barang <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-xs text-slate-500 mb-2">Pilih bahan pangan yang akan dikeluarkan dari gudang Dinsospermades Kab. Banyumas.</p>
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
                                    {{ $barang->nama_barang }} &nbsp;—&nbsp; Stok Barang Tersedia: {{ number_format($barang->jumlah) }} {{ $barang->satuan }}
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

                <!-- [Kriteria 1] PILIH TIPE KELUAR -->
                <div>
                    <label for="tipe_keluar" class="block text-sm font-bold text-slate-800 mb-1.5">
                        Tipe Pengeluaran Barang <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-xs text-slate-500 mb-2">Pilih kategori atau kondisi yang menyebabkan barang dikeluarkan dari persediaan gudang.</p>
                    <div class="relative">
                        <select name="tipe_keluar" id="tipe_keluar" required
                            class="w-full px-4 py-3 rounded-xl border @error('tipe_keluar') border-rose-400 bg-rose-50 @else border-slate-300 @enderror text-sm bg-white font-semibold focus:ring-2 focus:ring-rose-500 focus:border-rose-500 focus:outline-none transition appearance-none">
                            <option value="">-- Pilih Tipe Pengeluaran --</option>
                            <option value="Barang Rusak" {{ old('tipe_keluar') == 'Barang Rusak' ? 'selected' : '' }}>
                                🔴 Barang Rusak (Kemasan Robek / Cacat Fisik / Tercemar)
                            </option>
                            <option value="Kadaluarsa" {{ old('tipe_keluar') == 'Kadaluarsa' ? 'selected' : '' }}>
                                🟠 Kadaluarsa (Expired / Melewati Batas Waktu Konsumsi)
                            </option>
                            <option value="Penyusutan / Selisih Fisik" {{ old('tipe_keluar') == 'Penyusutan / Selisih Fisik' ? 'selected' : '' }}>
                                🟡 Penyusutan / Selisih Fisik (Susut Takaran / Hilang)
                            </option>
                            <option value="Distribusi Darurat / Khusus" {{ old('tipe_keluar') == 'Distribusi Darurat / Khusus' ? 'selected' : '' }}>
                                🔵 Distribusi Darurat / Khusus (Tanggap Bencana Mendesak)
                            </option>
                            <option value="Lainnya" {{ old('tipe_keluar') == 'Lainnya' ? 'selected' : '' }}>
                                ⚪ Lainnya
                            </option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('tipe_keluar')
                        <p class="mt-1.5 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- [Kriteria 1] JUMLAH VOLUME KELUAR -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="jumlah" class="block text-sm font-bold text-slate-800">
                            Jumlah Volume Keluar <span class="text-rose-500">*</span>
                        </label>
                        <span id="badgeSatuan" class="text-xs px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-800 font-semibold hidden">
                            Satuan: <span id="labelSatuan">Unit</span>
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mb-2">Banyaknya kuantitas barang yang dikeluarkan dari persediaan stok fisik.</p>
                    <div class="relative rounded-xl shadow-sm">
                        <input type="number" name="jumlah" id="jumlah" min="1" required
                            value="{{ old('jumlah') }}"
                            placeholder="Contoh: 25"
                            class="w-full pl-4 pr-24 py-3 rounded-xl border @error('jumlah') border-rose-400 bg-rose-50 @else border-slate-300 @enderror text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 focus:outline-none transition">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider bg-slate-100 px-2.5 py-1 rounded-md" id="inputUnit">
                                Unit
                            </span>
                        </div>
                    </div>
                    @error('jumlah')
                        <p class="mt-1.5 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- [Kriteria 2] SIMULASI & VALIDASI REAL-TIME PENCEGAHAN OVER-STOCK -->
                <div id="boxSimulasi" class="hidden p-4 rounded-xl bg-slate-50 border border-slate-200 transition">
                    <div class="flex items-center justify-between text-xs text-slate-700 mb-2">
                        <span class="font-bold flex items-center space-x-1.5">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <span>Simulasi Pengurangan Stok Gudang</span>
                        </span>
                        <span class="text-[11px] text-slate-500 font-medium">Validasi Stok Otomatis</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 text-center pt-1 mb-2">
                        <div class="bg-white p-2.5 rounded-lg border border-slate-200 shadow-2xs">
                            <span class="text-[11px] text-slate-500 block">Stok Barang Tersedia</span>
                            <span class="text-sm font-bold text-slate-800" id="simSaldoLama">0</span>
                        </div>
                        <div class="bg-rose-50 p-2.5 rounded-lg border border-rose-200">
                            <span class="text-[11px] text-rose-700 block">- Jumlah Keluar</span>
                            <span class="text-sm font-extrabold text-rose-700" id="simJumlahKeluar">-0</span>
                        </div>
                        <div class="bg-slate-800 text-white p-2.5 rounded-lg shadow-sm" id="boxSisaSaldo">
                            <span class="text-[11px] text-slate-300 block">Sisa Stok Akhir</span>
                            <span class="text-sm font-extrabold" id="simSaldoBaru">0</span>
                        </div>
                    </div>

                    <!-- Banner Peringatan Pencegahan Pengeluaran Melebihi Stok [Kriteria 2] -->
                    <div id="alertOverStock" class="hidden mt-3 p-3 rounded-lg bg-rose-500 text-white text-xs font-semibold flex items-center space-x-2 animate-pulse">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span id="alertOverStockText">
                            Sistem mencegah pengeluaran! Jumlah yang dimasukkan melebihi sisa stok yang tersedia di gudang.
                        </span>
                    </div>
                </div>

                <!-- [Kriteria 1] ALASAN / KETERANGAN PENGELUARAN -->
                <div>
                    <label for="keterangan" class="block text-sm font-bold text-slate-800 mb-1.5">
                        Alasan / Detail Keterangan Pengeluaran <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-xs text-slate-500 mb-2">
                        Tuliskan rincian penyebab barang dikeluarkan, nomor berita acara pemusnahan/penyaluran, atau catatan kondisi fisik barang.
                    </p>
                    <textarea name="keterangan" id="keterangan" rows="3" required
                        placeholder="Contoh: Kemasan karung robek dan basah akibat bocor atap gudang sisi timur saat hujan lebat"
                        class="w-full px-4 py-3 rounded-xl border @error('keterangan') border-rose-400 bg-rose-50 @else border-slate-300 @enderror text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 focus:outline-none transition resize-none">{{ old('keterangan') }}</textarea>
                    
                    <!-- Preset Rekomendasi Cepat Alasan Keluar -->
                    <div class="mt-2 flex flex-wrap items-center gap-1.5">
                        <span class="text-[11px] text-slate-400 font-semibold mr-1">Rekomendasi Cepat:</span>
                        <button type="button" onclick="setAlasan('Kemasan karung sobek dan rusak saat bongkar muat logistik')"
                            class="text-[11px] px-2.5 py-1 rounded-md bg-slate-100 hover:bg-rose-50 hover:text-rose-700 border border-slate-200 text-slate-600 transition">
                            + Karung Sobek
                        </button>
                        <button type="button" onclick="setAlasan('Bahan pangan berjamur akibat kelembapan udara gudang')"
                            class="text-[11px] px-2.5 py-1 rounded-md bg-slate-100 hover:bg-rose-50 hover:text-rose-700 border border-slate-200 text-slate-600 transition">
                            + Berjamur
                        </button>
                        <button type="button" onclick="setAlasan('Melewati tanggal kadaluarsa (expired date) layak konsumsi pangan')"
                            class="text-[11px] px-2.5 py-1 rounded-md bg-slate-100 hover:bg-rose-50 hover:text-rose-700 border border-slate-200 text-slate-600 transition">
                            + Melewati Kadaluarsa
                        </button>
                        <button type="button" onclick="setAlasan('Penyaluran cepat tanggap darurat bencana alam Dinsos Banyumas')"
                            class="text-[11px] px-2.5 py-1 rounded-md bg-slate-100 hover:bg-rose-50 hover:text-rose-700 border border-slate-200 text-slate-600 transition">
                            + Tanggap Bencana
                        </button>
                    </div>

                    @error('keterangan')
                        <p class="mt-1.5 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Garansi Integritas Data (DB Transaction & Lock) -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 flex items-start space-x-3">
                    <div class="p-1 rounded-lg bg-rose-100 text-rose-700 mt-0.5">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold text-slate-800">Proteksi Keamanan Saldo Stok:</span>
                        <p class="text-slate-500 mt-0.5">
                            Sistem mengunci baris data stok (<code class="bg-slate-200 px-1 py-0.5 rounded text-[11px]">lockForUpdate</code>) selama proses simpan berlangsung untuk menjamin tidak ada saldo yang bernilai minus.
                        </p>
                    </div>
                </div>

                <!-- Tombol Submit & Batal -->
                <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-100">
                    <a href="{{ route('stok-mutasi.index') }}"
                       class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-100 transition">
                        Batal
                    </a>
                    <button type="submit" id="btnSubmitKeluar"
                            class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-md shadow-rose-600/20 transition flex items-center space-x-1.5 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span id="btnSubmitText">Simpan Mutasi Keluar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500 mt-auto">
        &copy; {{ date('Y') }} PENAMAS - Proyek Perangkat Lunak REG01 Kelompok 02
    </footer>

    <!-- Script Dynamic UI & Simulasi Real-Time Validasi Pengurangan Stok -->
    <script>
        const selectBarang     = document.getElementById('stok_bantuan_id');
        const inputJumlah      = document.getElementById('jumlah');
        const badgeSatuan      = document.getElementById('badgeSatuan');
        const labelSatuan      = document.getElementById('labelSatuan');
        const inputUnit        = document.getElementById('inputUnit');
        const boxSimulasi      = document.getElementById('boxSimulasi');
        const simSaldoLama     = document.getElementById('simSaldoLama');
        const simJumlahKeluar  = document.getElementById('simJumlahKeluar');
        const simSaldoBaru     = document.getElementById('simSaldoBaru');
        const boxSisaSaldo     = document.getElementById('boxSisaSaldo');
        const alertOverStock   = document.getElementById('alertOverStock');
        const alertOverStockText = document.getElementById('alertOverStockText');
        const btnSubmitKeluar  = document.getElementById('btnSubmitKeluar');
        const btnSubmitText    = document.getElementById('btnSubmitText');

        function updateSimulasiKeluar() {
            const selectedOpt = selectBarang.options[selectBarang.selectedIndex];
            const satuan = selectedOpt.getAttribute('data-satuan') || 'Unit';
            const namaBarang = selectedOpt.getAttribute('data-nama') || 'Barang';
            const saldoTersedia = parseInt(selectedOpt.getAttribute('data-jumlah') || 0);
            const keluar = parseInt(inputJumlah.value) || 0;

            labelSatuan.textContent = satuan;
            inputUnit.textContent = satuan;

            if (selectBarang.value) {
                badgeSatuan.classList.remove('hidden');
                boxSimulasi.classList.remove('hidden');

                simSaldoLama.textContent = saldoTersedia.toLocaleString('id-ID') + ' ' + satuan;
                simJumlahKeluar.textContent = '-' + keluar.toLocaleString('id-ID') + ' ' + satuan;

                const sisa = saldoTersedia - keluar;

                // [Kriteria 2] Cek apakah pengeluaran melebihi saldo tersedia
                if (keluar > saldoTersedia) {
                    // PENGELUARAN MELEBIHI STOK -> CEGAH PENGELUARAN!
                    boxSisaSaldo.className = "bg-rose-700 text-white p-2.5 rounded-lg shadow-sm";
                    simSaldoBaru.textContent = "Defisit (" + sisa.toLocaleString('id-ID') + ") " + satuan;

                    alertOverStock.classList.remove('hidden');
                    alertOverStockText.textContent = "Sistem mencegah pengeluaran! Jumlah keluar (" + keluar.toLocaleString('id-ID') + " " + satuan + ") melebihi stok yang tersedia (" + saldoTersedia.toLocaleString('id-ID') + " " + satuan + ")!";

                    inputJumlah.classList.add('border-rose-500', 'bg-rose-50');
                    btnSubmitKeluar.disabled = true;
                    btnSubmitText.textContent = "Jumlah Melebihi Stok!";
                } else {
                    // PENGELUARAN AMAN
                    boxSisaSaldo.className = "bg-slate-800 text-white p-2.5 rounded-lg shadow-sm";
                    simSaldoBaru.textContent = sisa.toLocaleString('id-ID') + ' ' + satuan;

                    alertOverStock.classList.add('hidden');
                    inputJumlah.classList.remove('border-rose-500', 'bg-rose-50');
                    btnSubmitKeluar.disabled = false;
                    btnSubmitText.textContent = "Simpan Mutasi Keluar";
                }
            } else {
                badgeSatuan.classList.add('hidden');
                boxSimulasi.classList.add('hidden');
                alertOverStock.classList.add('hidden');
                btnSubmitKeluar.disabled = false;
                btnSubmitText.textContent = "Simpan Mutasi Keluar";
            }
        }

        selectBarang.addEventListener('change', updateSimulasiKeluar);
        inputJumlah.addEventListener('input', updateSimulasiKeluar);

        function setAlasan(teks) {
            const textarea = document.getElementById('keterangan');
            textarea.value = teks;
            textarea.focus();
        }

        // Inisialisasi awal
        if (selectBarang.value) {
            updateSimulasiKeluar();
        }
    </script>
</body>
</html>
