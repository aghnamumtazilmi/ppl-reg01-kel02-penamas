@extends('layouts.app')

@section('page-title', 'Pendaftaran Penerima Bantuan (KPM) Baru')
@section('page-subtitle', 'Daftarkan data warga penerima bantuan dengan validasi NIK 16 digit')

@section('page-actions')
    <a href="{{ route('penerima.index') }}" class="btn btn-secondary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        <span>Kembali ke Daftar</span>
    </a>
@endsection

@section('content')
<div class="card p-6" style="max-width: 680px; margin: 0 auto; width: 100%;">
    <div style="padding-bottom: 16px; margin-bottom: 22px; border-bottom: 1px solid var(--border);">
        <span class="card-title" style="display: block; font-size: 14px; font-weight: 700; color: var(--text-1);">Formulir Pendaftaran Penerima (KPM)</span>
        <p style="font-size: 12px; color: var(--text-3); margin-top: 3px;">Pastikan data NIK 16 digit sesuai KTP/KK dan wilayah terdaftar resmi di Banyumas.</p>
    </div>

    <form action="{{ route('penerima.store') }}" method="POST">
        @csrf

        <!-- NIK -->
        <div class="form-group">
            <label for="nik" class="form-label">
                NIK (Nomor Induk Kependudukan) <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" 
                   name="nik" 
                   id="nik" 
                   value="{{ old('nik') }}" 
                   maxlength="16" 
                   required
                   placeholder="16 digit angka sesuai KTP/KK..." 
                   class="form-input">
            @error('nik')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Nama Lengkap -->
        <div class="form-group">
            <label for="nama" class="form-label">
                Nama Lengkap Penerima <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" 
                   name="nama" 
                   id="nama" 
                   value="{{ old('nama') }}" 
                   required
                   placeholder="Nama lengkap sesuai KTP..." 
                   class="form-input">
            @error('nama')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Alamat Domisili -->
        <div class="form-group">
            <label for="alamat" class="form-label">
                Alamat Domisili Lengkap (RT/RW/Jalan) <span style="color: #ef4444;">*</span>
            </label>
            <textarea name="alamat" 
                      id="alamat" 
                      rows="3" 
                      required
                      placeholder="Contoh: RT 02 / RW 03, Jl. Gerilya No. 12" 
                      class="form-input">{{ old('alamat') }}</textarea>
            @error('alamat')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Kecamatan & Kelurahan -->
        <div class="grid grid-2 mb-4" style="gap: 12px;">
            <div>
                <label for="kecamatan" class="form-label">
                    Kecamatan <span style="color: #ef4444;">*</span>
                </label>
                <select name="kecamatan" id="kecamatan" required class="form-select">
                    <option value="">-- Pilih Kecamatan --</option>
                    @foreach($daftarKecamatan as $kec)
                        <option value="{{ $kec }}" {{ old('kecamatan') == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                    @endforeach
                </select>
                @error('kecamatan')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="kelurahan" class="form-label">
                    Kelurahan / Desa <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" 
                       name="kelurahan" 
                       id="kelurahan" 
                       value="{{ old('kelurahan') }}" 
                       required
                       placeholder="Nama kelurahan/desa..." 
                       class="form-input">
                @error('kelurahan')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Kontak / No. HP -->
        <div class="form-group">
            <label for="no_hp" class="form-label">
                Nomor Telepon / WhatsApp <span style="color: var(--text-3); font-weight: 400;">(Opsional)</span>
            </label>
            <input type="text" 
                   name="no_hp" 
                   id="no_hp" 
                   value="{{ old('no_hp') }}" 
                   placeholder="Contoh: 081234567890" 
                   class="form-input">
            @error('no_hp')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tombol Aksi -->
        <div class="flex items-center gap-3 mt-6" style="padding-top: 10px; justify-content: flex-end;">
            <a href="{{ route('penerima.index') }}" class="btn btn-secondary">
                <span>Batal</span>
            </a>
            <button type="submit" class="btn btn-primary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                <span>Simpan Penerima</span>
            </button>
        </div>
    </form>
</div>
@endsection
