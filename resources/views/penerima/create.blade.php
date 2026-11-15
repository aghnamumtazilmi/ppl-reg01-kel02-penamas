<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Penerima Bantuan - PENAMAS</title>
    <!-- Tailwind CSS CDN agar tampilan langsung rapi dan profesional -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen py-10">

    <div class="max-w-3xl mx-auto px-4">
        
        <!-- Header Proyek -->
        <div class="bg-emerald-700 text-white rounded-t-2xl p-6 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Pendaftaran Penerima Bantuan (KPM) Baru</h1>
                    <p class="text-emerald-100 text-sm mt-1">PENAMAS — Sistem Informasi Pengelolaan Bantuan Pangan Masyarakat</p>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-b-2xl shadow-md p-8 border border-slate-200 border-t-0">
            
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

            <!-- Notifikasi Error Umum (Jika NIK salah format atau duplikat) -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-lg text-rose-800 text-sm">
                    <p class="font-semibold mb-1">Gagal Mendaftarkan Data:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('penerima.store') }}" method="POST">
                @csrf

                <!-- Input NIK (Kriteria Utama: 16 Digit) -->
                <div class="mb-5">
                    <label for="nik" class="block text-sm font-semibold text-slate-700 mb-1">
                        Nomor Induk Kependudukan (NIK) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nik" id="nik" maxlength="16" value="{{ old('nik') }}"
                        placeholder="Contoh: 3302012304950001 (Wajib 16 digit)"
                        class="w-full px-4 py-2.5 rounded-lg border @error('nik') border-rose-400 bg-rose-50 @else border-slate-300 @enderror focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">
                    <p class="text-xs text-slate-500 mt-1">Format NIK wajib tepat 16 digit angka dan belum pernah terdaftar.</p>
                </div>

                <!-- Input Nama -->
                <div class="mb-5">
                    <label for="nama" class="block text-sm font-semibold text-slate-700 mb-1">
                        Nama Lengkap Kepala Keluarga / Penerima <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                        placeholder="Masukkan nama lengkap sesuai KTP"
                        class="w-full px-4 py-2.5 rounded-lg border @error('nama') border-rose-400 bg-rose-50 @else border-slate-300 @enderror focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">
                </div>

                <!-- Input Alamat -->
                <div class="mb-5">
                    <label for="alamat" class="block text-sm font-semibold text-slate-700 mb-1">
                        Alamat Lengkap (RT/RW / Nama Jalan) <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="alamat" id="alamat" rows="2"
                        placeholder="Contoh: RT 02 / RW 03, Jl. Gerilya No. 12"
                        class="w-full px-4 py-2 rounded-lg border @error('alamat') border-rose-400 bg-rose-50 @else border-slate-300 @enderror focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">{{ old('alamat') }}</textarea>
                </div>

                <!-- Kelurahan & Kecamatan Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="kelurahan" class="block text-sm font-semibold text-slate-700 mb-1">
                            Desa / Kelurahan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan') }}"
                            placeholder="Contoh: Purwokerto Kidul"
                            class="w-full px-4 py-2.5 rounded-lg border @error('kelurahan') border-rose-400 bg-rose-50 @else border-slate-300 @enderror focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">
                    </div>

                    <div>
                        <label for="kecamatan" class="block text-sm font-semibold text-slate-700 mb-1">
                            Kecamatan <span class="text-rose-500">*</span>
                        </label>
                        <select name="kecamatan" id="kecamatan"
                            class="w-full px-4 py-2.5 rounded-lg border @error('kecamatan') border-rose-400 bg-rose-50 @else border-slate-300 @enderror focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach ($daftarKecamatan as $kec)
                                <option value="{{ $kec }}" {{ old('kecamatan') == $kec ? 'selected' : '' }}>
                                    Kecamatan {{ $kec }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Kabupaten -->
                <div class="mb-8">
                    <label for="kabupaten" class="block text-sm font-semibold text-slate-700 mb-1">
                        Kabupaten
                    </label>
                    <input type="text" name="kabupaten" id="kabupaten" value="Banyumas" readonly
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed">
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                    <a href="{{ route('penerima.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium hover:bg-slate-50 transition flex items-center space-x-1">
                        <span>&larr; Kembali ke Daftar</span>
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-sm transition flex items-center space-x-2">
                        <span>Simpan Data Penerima</span>
                    </button>
                </div>

            </form>
        </div>

    </div>

</body>
</html>
