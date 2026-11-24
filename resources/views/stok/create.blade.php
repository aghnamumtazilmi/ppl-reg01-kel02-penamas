@extends('layouts.app')

@section('title', 'Tambah Komoditas Pangan Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header Halaman -->
    <div class="mb-6">
        <div class="flex items-center space-x-2 text-xs text-slate-500 mb-2">
            <span>Gudang Logistik</span>
            <span>&rsaquo;</span>
            <a href="{{ route('stok.index') }}" class="text-slate-600 hover:text-emerald-700">Kelola Stok</a>
            <span>&rsaquo;</span>
            <span class="text-slate-800 font-semibold">PBI-010: Tambah Komoditas Baru</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Catat Komoditas Pangan Baru</h1>
        <p class="text-sm text-slate-500 mt-1">Daftarkan jenis komoditas bahan pangan baru beserta satuan dan persediaan awal di gudang.</p>
    </div>

    <!-- Card Formulir -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form action="{{ route('stok.store') }}" method="POST">
            @csrf

            <!-- Field 1: Nama Barang -->
            <div class="mb-5">
                <label for="nama_barang" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Nama Komoditas Pangan <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="nama_barang" 
                    name="nama_barang" 
                    value="{{ old('nama_barang') }}"
                    placeholder="Contoh: Beras Premium, Minyak Goreng, Gula Pasir" 
                    class="w-full px-4 py-2.5 rounded-xl border @error('nama_barang') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-300 bg-white text-slate-800 @enderror focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition"
                    required
                >
                @error('nama_barang')
                    <p class="text-xs text-rose-600 mt-1.5 flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <span>{{ $message }}</span>
                    </p>
                @else
                    <p class="text-xs text-slate-400 mt-1">Pastikan nama barang spesifik dan belum pernah didaftarkan sebelumnya.</p>
                @enderror
            </div>

            <!-- Field 2: Satuan Barang -->
            <div class="mb-5">
                <label for="satuan" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Satuan Barang <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <select 
                        id="satuan" 
                        name="satuan" 
                        class="w-full px-4 py-2.5 rounded-xl border @error('satuan') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-300 bg-white text-slate-800 @enderror focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition appearance-none cursor-pointer"
                        required
                    >
                        <option value="" disabled {{ old('satuan') ? '' : 'selected' }}>-- Pilih Satuan Barang --</option>
                        @foreach($satuanOptions as $key => $label)
                            <option value="{{ $key }}" {{ old('satuan') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @error('satuan')
                    <p class="text-xs text-rose-600 mt-1.5 flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Field 3: Jumlah Stok Awal -->
            <div class="mb-6">
                <label for="jumlah" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Jumlah Stok Awal di Gudang
                </label>
                <div class="relative">
                    <input 
                        type="number" 
                        id="jumlah" 
                        name="jumlah" 
                        value="{{ old('jumlah', 0) }}"
                        step="1"
                        placeholder="0" 
                        class="w-full px-4 py-2.5 rounded-xl border @error('jumlah') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-300 bg-white text-slate-800 @enderror focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition"
                    >
                </div>
                @error('jumlah')
                    <p class="text-xs text-rose-600 mt-1.5 flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <span>{{ $message }}</span>
                    </p>
                @else
                    <p class="text-xs text-slate-400 mt-1">Isi 0 jika stok fisik belum diterima di gudang saat pendaftaran master barang.</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                <a 
                    href="{{ route('stok.index') }}" 
                    class="text-xs text-slate-500 hover:text-slate-800 font-medium flex items-center space-x-1"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>Kembali ke Daftar Stok</span>
                </a>
                <div class="flex items-center space-x-3">
                    <button 
                        type="reset" 
                        class="px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition"
                    >
                        Reset Form
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition flex items-center space-x-1.5"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Simpan Komoditas</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
