<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Mutasi Masuk Stok - PENAMAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen py-10">

    <div class="max-w-2xl mx-auto px-4">

        <!-- Header -->
        <div class="bg-blue-700 text-white rounded-t-2xl p-6 shadow-md flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold">Catat Mutasi Masuk Stok</h1>
                <p class="text-blue-100 text-sm mt-1">F-06 | PBI-016 — Penambahan barang dari pengadaan atau donatur</p>
            </div>
            <a href="{{ route('stok-mutasi.index') }}"
               class="inline-flex items-center space-x-2 px-4 py-2 bg-blue-800 hover:bg-blue-900 border border-blue-600 text-white font-semibold rounded-lg shadow-sm transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali ke Riwayat</span>
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-b-2xl shadow-md p-6 border border-slate-200 border-t-0">

            {{-- Tampilkan error validasi --}}
            @if ($errors->any())
                <div class="mb-5 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-lg">
                    <p class="text-sm font-semibold text-rose-800 mb-1">Terdapat kesalahan input:</p>
                    <ul class="list-disc list-inside text-sm text-rose-700 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('stok-mutasi.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- [Kriteria 1] Pilih Nama Barang dari Daftar Stok --}}
                <div>
                    <label for="stok_bantuan_id" class="block text-sm font-semibold text-slate-700 mb-1">
                        Nama Barang <span class="text-rose-500">*</span>
                    </label>
                    <select name="stok_bantuan_id" id="stok_bantuan_id"
                        class="w-full px-3 py-2.5 rounded-lg border @error('stok_bantuan_id') border-rose-400 bg-rose-50 @else border-slate-300 @enderror text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($daftarBarang as $barang)
                            <option value="{{ $barang->id }}" {{ old('stok_bantuan_id') == $barang->id ? 'selected' : '' }}>
                                {{ $barang->nama_barang }} (Saldo: {{ number_format($barang->jumlah) }} {{ $barang->satuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('stok_bantuan_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- [Kriteria 1] Jumlah Barang Masuk --}}
                <div>
                    <label for="jumlah" class="block text-sm font-semibold text-slate-700 mb-1">
                        Jumlah Masuk <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}"
                        min="1" placeholder="Contoh: 50"
                        class="w-full px-3 py-2.5 rounded-lg border @error('jumlah') border-rose-400 bg-rose-50 @else border-slate-300 @enderror text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    @error('jumlah')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-400">Angka stok gudang akan otomatis bertambah sesuai jumlah ini.</p>
                </div>

                {{-- [Kriteria 1] Keterangan Sumber Barang --}}
                <div>
                    <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-1">
                        Keterangan Sumber Barang <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                        placeholder="Contoh: Pengadaan dari Dinas Sosial, Donasi PT. XYZ, Hibah BAZNAS..."
                        class="w-full px-3 py-2.5 rounded-lg border @error('keterangan') border-rose-400 bg-rose-50 @else border-slate-300 @enderror text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition resize-none">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info box -->
                <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg text-xs text-blue-700 flex items-start space-x-2">
                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <span>Setelah disimpan, saldo stok barang yang dipilih akan <strong>otomatis bertambah</strong> dan riwayat mutasi masuk akan tercatat di log audit.</span>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-end space-x-3 pt-2">
                    <a href="{{ route('stok-mutasi.index') }}"
                       class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Simpan Mutasi Masuk</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
