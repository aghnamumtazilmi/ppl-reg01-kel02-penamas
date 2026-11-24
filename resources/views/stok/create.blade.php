@extends('layouts.app')

@section('page-title', 'Tambah Komoditas Pangan Baru')
@section('page-subtitle', 'Daftarkan jenis komoditas bahan pangan baru beserta satuan dan stok awal di gudang')

@section('page-actions')
    <a href="{{ route('stok.index') }}" class="btn btn-secondary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        <span>Kembali ke Daftar</span>
    </a>
@endsection

@section('content')
<div class="card p-6" style="max-width: 680px; margin: 0 auto; width: 100%;">
    <div style="padding-bottom: 16px; margin-bottom: 22px; border-bottom: 1px solid var(--border);">
        <span class="card-title" style="display: block; font-size: 14px; font-weight: 700; color: var(--text-1);">Formulir Pendaftaran Komoditas Baru</span>
        <p style="font-size: 12px; color: var(--text-3); margin-top: 3px;">Pastikan nama barang spesifik dan belum pernah didaftarkan sebelumnya.</p>
    </div>

    <form action="{{ route('stok.store') }}" method="POST">
        @csrf

        <!-- Nama Barang -->
        <div class="form-group">
            <label for="nama_barang" class="form-label">
                Nama Komoditas Pangan <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" 
                   id="nama_barang" 
                   name="nama_barang" 
                   value="{{ old('nama_barang') }}"
                   placeholder="Contoh: Beras Premium, Minyak Goreng, Gula Pasir" 
                   required
                   class="form-input">
            @error('nama_barang')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Satuan Barang -->
        <div class="form-group">
            <label for="satuan" class="form-label">
                Satuan Ukuran <span style="color: #ef4444;">*</span>
            </label>
            <select id="satuan" name="satuan" required class="form-select">
                <option value="">-- Pilih Satuan Ukuran --</option>
                @foreach($satuanOptions as $key => $label)
                    <option value="{{ $key }}" {{ old('satuan') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('satuan')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Kategori -->
        <div class="form-group">
            <label for="kategori" class="form-label">
                Kategori Barang <span style="color: #ef4444;">*</span>
            </label>
            <select id="kategori" name="kategori" required class="form-select">
                <option value="Bahan Pokok" {{ old('kategori') == 'Bahan Pokok' ? 'selected' : '' }}>Bahan Pokok</option>
                <option value="Lauk Pauk" {{ old('kategori') == 'Lauk Pauk' ? 'selected' : '' }}>Lauk Pauk</option>
                <option value="Bumbu Dapur" {{ old('kategori') == 'Bumbu Dapur' ? 'selected' : '' }}>Bumbu Dapur</option>
                <option value="Sayur & Buah" {{ old('kategori') == 'Sayur & Buah' ? 'selected' : '' }}>Sayur & Buah</option>
                <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            @error('kategori')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Jumlah Stok Awal -->
        <div class="form-group">
            <label for="jumlah" class="form-label">
                Persediaan Fisik Awal (Stok) <span style="color: #ef4444;">*</span>
            </label>
            <input type="number" 
                   id="jumlah" 
                   name="jumlah" 
                   value="{{ old('jumlah', 0) }}" 
                   min="0" 
                   required
                   class="form-input">
            @error('jumlah')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Keterangan -->
        <div class="form-group">
            <label for="keterangan" class="form-label">
                Keterangan / Catatan Tambahan <span style="color: var(--text-3); font-weight: 400;">(Opsional)</span>
            </label>
            <textarea id="keterangan" 
                      name="keterangan" 
                      rows="3" 
                      placeholder="Catatan merek, kemasan, atau spesifikasi fisik barang..." 
                      class="form-input">{{ old('keterangan') }}</textarea>
            @error('keterangan')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tombol Aksi -->
        <div class="flex items-center gap-3 mt-6" style="padding-top: 10px; justify-content: flex-end;">
            <a href="{{ route('stok.index') }}" class="btn btn-secondary">
                <span>Batal</span>
            </a>
            <button type="submit" class="btn btn-primary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                <span>Simpan Komoditas</span>
            </button>
        </div>
    </form>
</div>
@endsection
