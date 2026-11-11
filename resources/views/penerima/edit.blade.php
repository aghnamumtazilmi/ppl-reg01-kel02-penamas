<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Penerima & Status - PENAMAS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen py-10">

    <div class="max-w-3xl mx-auto px-4">
        
        <!-- Header Proyek -->
        <div class="bg-emerald-700 text-white rounded-t-2xl p-6 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Ubah Data Alamat & Status Penerima</h1>
                    <p class="text-emerald-100 text-sm mt-1">PENAMAS — Sistem Informasi Pengelolaan Bantuan Pangan Masyarakat</p>
                </div>
            </div>
        </div>

        <!-- Form Edit Container -->
        <div class="bg-white rounded-b-2xl shadow-md p-8 border border-slate-200 border-t-0">
            
            <!-- Notifikasi Error Validasi -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-lg text-rose-800 text-sm">
                    <p class="font-semibold mb-1">Gagal Menyimpan Perubahan:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('penerima.update', $penerima->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- NIK (Terkunci / Readonly karena identitas kependudukan permanen) -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Nomor Induk Kependudukan (NIK)
                    </label>
                    <input type="text" value="{{ $penerima->nik }}" readonly
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed font-mono">
                    <p class="text-xs text-slate-400 mt-1">NIK bersifat permanen dan tidak dapat diubah.</p>
                </div>

                <!-- Input Nama -->
                <div class="mb-5">
                    <label for="nama" class="block text-sm font-semibold text-slate-700 mb-1">
                        Nama Lengkap Kepala Keluarga / Penerima <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $penerima->nama) }}"
                        class="w-full px-4 py-2.5 rounded-lg border @error('nama') border-rose-400 bg-rose-50 @else border-slate-300 @enderror focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">
                </div>

                <!-- [PBI-005] Kriteria 1: Ubah Data Alamat -->
                <div class="mb-5">
                    <label for="alamat" class="block text-sm font-semibold text-slate-700 mb-1">
                        Alamat Lengkap (RT/RW / Nama Jalan) <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="alamat" id="alamat" rows="2"
                        class="w-full px-4 py-2 rounded-lg border @error('alamat') border-rose-400 bg-rose-50 @else border-slate-300 @enderror focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">{{ old('alamat', $penerima->alamat) }}</textarea>
                </div>

                <!-- Kelurahan & Kecamatan Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="kelurahan" class="block text-sm font-semibold text-slate-700 mb-1">
                            Desa / Kelurahan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan', $penerima->kelurahan) }}"
                            class="w-full px-4 py-2.5 rounded-lg border @error('kelurahan') border-rose-400 bg-rose-50 @else border-slate-300 @enderror focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">
                    </div>

                    <div>
                        <label for="kecamatan" class="block text-sm font-semibold text-slate-700 mb-1">
                            Kecamatan <span class="text-rose-500">*</span>
                        </label>
                        <select name="kecamatan" id="kecamatan"
                            class="w-full px-4 py-2.5 rounded-lg border @error('kecamatan') border-rose-400 bg-rose-50 @else border-slate-300 @enderror focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">
                            @foreach ($daftarKecamatan as $kec)
                                <option value="{{ $kec }}" {{ old('kecamatan', $penerima->kecamatan) == $kec ? 'selected' : '' }}>
                                    Kecamatan {{ $kec }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Kabupaten & No HP Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="kabupaten" class="block text-sm font-semibold text-slate-700 mb-1">
                            Kabupaten / Kota
                        </label>
                        <input type="text" name="kabupaten" id="kabupaten" value="{{ old('kabupaten', $penerima->kabupaten ?? 'Banyumas') }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">
                    </div>

                    <div>
                        <label for="no_hp" class="block text-sm font-semibold text-slate-700 mb-1">
                            Nomor WhatsApp / HP
                        </label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $penerima->no_hp) }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">
                    </div>
                </div>

                <!-- Status Penerima (Aktif / Nonaktif) -->
                <div class="mb-8">
                    <label for="status" class="block text-sm font-semibold text-slate-700 mb-1">
                        Status Penerima <span class="text-rose-500">*</span>
                    </label>
                    <select name="status" id="status"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-white font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none transition">
                        <option value="aktif" {{ old('status', $penerima->status) === 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="nonaktif" {{ old('status', $penerima->status) === 'nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                    <a href="{{ route('penerima.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium hover:bg-slate-50 transition flex items-center space-x-1">
                        <span>&larr; Kembali ke Daftar</span>
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-sm transition">
                        Simpan Perubahan Data & Status
                    </button>
                </div>

            </form>
        </div>

    </div>

</body>
</html>
