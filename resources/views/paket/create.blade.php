@extends('layouts.app')

@section('title', 'Tambah Paket Bantuan Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Breadcrumb -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('paket.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar Paket
            </a>
            <h1 class="text-2xl font-bold text-slate-900 mt-1">Tambah Paket Bantuan Baru (PBI-007)</h1>
            <p class="text-xs text-slate-500">Tentukan nama paket dan tentukan rincian isi barang yang akan dibagikan kepada penerima.</p>
        </div>
    </div>

    <!-- Error Validation Display -->
    @if (isset($errors) && $errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-xs">
            <div class="font-bold mb-1 flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Terdapat kesalahan dalam pengisian formulir:
            </div>
            <ul class="list-disc list-inside text-xs space-y-0.5 ml-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulir Tambah Paket -->
    <form action="{{ route('paket.store') }}" method="POST" class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-8">
        @csrf

        <!-- Informasi Utama Paket -->
        <div class="space-y-4">
            <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold flex items-center justify-center">1</span>
                Informasi Utama Paket Bantuan
            </h2>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="nama" class="block text-xs font-bold uppercase text-slate-600 mb-1">
                        Nama Paket Bantuan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ old('nama') }}" 
                           placeholder="Contoh: Paket Sembako Ramadhan / Paket Lansia Sejahtera" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                           required>
                </div>

                <div>
                    <label for="deskripsi" class="block text-xs font-bold uppercase text-slate-600 mb-1">
                        Deskripsi / Keterangan Tambahan
                    </label>
                    <textarea name="deskripsi" 
                              id="deskripsi" 
                              rows="3" 
                              placeholder="Keterangan sasaran penerima atau catatan khusus isi paket..." 
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">{{ old('deskripsi') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Rincian Komponen Barang (PBI-007 Dynamic Row) -->
        <div class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 pb-2 gap-2">
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold flex items-center justify-center">2</span>
                    Rincian Komponen Barang Bantuan
                </h2>
                <span class="text-xs text-slate-500">Saran barang otomatis dari stok gudang</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm" id="table-komponen">
                    <thead class="bg-slate-50 text-slate-700 text-xs uppercase font-bold border-y border-slate-200">
                        <tr>
                            <th scope="col" class="px-4 py-3 min-w-[220px]">Nama Barang Komoditas <span class="text-rose-500">*</span></th>
                            <th scope="col" class="px-4 py-3 min-w-[120px]">Satuan <span class="text-rose-500">*</span></th>
                            <th scope="col" class="px-4 py-3 min-w-[120px]">Jumlah per Paket <span class="text-rose-500">*</span></th>
                            <th scope="col" class="px-4 py-3 text-right w-16">Hapus</th>
                        </tr>
                    </thead>
                    <tbody id="komponen-container" class="divide-y divide-slate-100">
                        <!-- Default 1 Baris Komponen -->
                        <tr class="baris-komponen hover:bg-slate-50/50 transition">
                            <td class="px-4 py-3">
                                <input type="text" 
                                       name="komponen[0][nama_barang]" 
                                       list="datalist-komoditas" 
                                       placeholder="Pilih atau ketik barang..." 
                                       class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 input-nama-barang"
                                       required>
                            </td>
                            <td class="px-4 py-3">
                                <input type="text" 
                                       name="komponen[0][satuan]" 
                                       placeholder="kg, liter, dll" 
                                       class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 input-satuan"
                                       required>
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" 
                                       step="0.01" 
                                       min="0.01" 
                                       name="komponen[0][jumlah]" 
                                       placeholder="Misal: 5" 
                                       class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500"
                                       required>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button type="button" 
                                        onclick="hapusBaris(this)" 
                                        class="p-2 text-slate-400 hover:text-rose-600 transition rounded-lg hover:bg-rose-50" 
                                        title="Hapus baris">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tombol Tambah Baris Barang (PBI-007) -->
            <button type="button" 
                    onclick="tambahBaris()" 
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs border border-emerald-200 transition">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                + Tambah Baris Barang
            </button>
        </div>

        <!-- Datalist Saran Otomatis dari Stok Gudang (PBI-007 Kriteria 2) -->
        <datalist id="datalist-komoditas">
            @foreach($komoditasList as $item)
                <option value="{{ $item->nama_barang }}" data-satuan="{{ $item->satuan }}">{{ $item->nama_barang }} ({{ $item->satuan }})</option>
            @endforeach
        </datalist>

        <!-- Tombol Aksi Simpan -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('paket.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-sm transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md shadow-emerald-600/20 transition">
                Simpan Paket Bantuan
            </button>
        </div>
    </form>

</div>

<script>
    let barisIndex = 1;

    // Database referensi satuan dari stok gudang
    const komoditasMap = {
        @foreach($komoditasList as $item)
            "{{ addslashes($item->nama_barang) }}": "{{ addslashes($item->satuan) }}",
        @endforeach
    };

    function attachAutoSatuanListener(row) {
        const inputNama = row.querySelector('.input-nama-barang');
        const inputSatuan = row.querySelector('.input-satuan');

        if (inputNama && inputSatuan) {
            inputNama.addEventListener('input', function() {
                const val = this.value.trim();
                if (komoditasMap[val]) {
                    inputSatuan.value = komoditasMap[val];
                }
            });
        }
    }

    // Attach listener ke baris pertama
    document.querySelectorAll('.baris-komponen').forEach(attachAutoSatuanListener);

    function tambahBaris() {
        const container = document.getElementById('komponen-container');
        const tr = document.createElement('tr');
        tr.className = 'baris-komponen hover:bg-slate-50/50 transition';
        tr.innerHTML = `
            <td class="px-4 py-3">
                <input type="text" 
                       name="komponen[${barisIndex}][nama_barang]" 
                       list="datalist-komoditas" 
                       placeholder="Pilih atau ketik barang..." 
                       class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 input-nama-barang"
                       required>
            </td>
            <td class="px-4 py-3">
                <input type="text" 
                       name="komponen[${barisIndex}][satuan]" 
                       placeholder="kg, liter, dll" 
                       class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 input-satuan"
                       required>
            </td>
            <td class="px-4 py-3">
                <input type="number" 
                       step="0.01" 
                       min="0.01" 
                       name="komponen[${barisIndex}][jumlah]" 
                       placeholder="Misal: 5" 
                       class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500"
                       required>
            </td>
            <td class="px-4 py-3 text-right">
                <button type="button" 
                        onclick="hapusBaris(this)" 
                        class="p-2 text-slate-400 hover:text-rose-600 transition rounded-lg hover:bg-rose-50" 
                        title="Hapus baris">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </td>
        `;
        container.appendChild(tr);
        attachAutoSatuanListener(tr);
        barisIndex++;
    }

    function hapusBaris(btn) {
        const rows = document.querySelectorAll('.baris-komponen');
        if (rows.length <= 1) {
            alert('Minimal harus ada 1 komponen barang dalam paket bantuan.');
            return;
        }
        btn.closest('tr').remove();
    }
</script>
@endsection
