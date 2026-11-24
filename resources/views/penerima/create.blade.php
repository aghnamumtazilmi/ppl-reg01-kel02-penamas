@extends('layouts.app')

@section('page-title', 'Pendaftaran Penerima Bantuan')
@section('page-subtitle', 'Tambah data Keluarga Penerima Manfaat (KPM) baru ke dalam sistem')

@section('page-actions')
    <a href="{{ route('penamas.penerima.index') }}" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 6px;">
        <span>&larr; Kembali ke Daftar</span>
    </a>
@endsection

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header" style="padding: 16px 20px; border-bottom: 1px solid var(--border);">
        <h3 class="card-title" style="font-size: 14px; font-weight: 700; color: var(--text-1);">Formulir Pendaftaran Warga KPM Baru</h3>
        <p class="card-sub" style="font-size: 12px; color: var(--text-2);">Lengkapi data identitas kependudukan penerima bantuan dengan benar.</p>
    </div>

    <div class="card-body" style="padding: 24px;">
        @if (isset($errors) && $errors->any())
            <div class="alert alert-error" style="margin-bottom: 20px;">
                <svg style="width:16px;height:16px;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <strong style="display:block; margin-bottom: 4px;">Gagal Mendaftarkan Data:</strong>
                    <ul style="margin: 0; padding-left: 18px; font-size: 12px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('penerima.store') }}" method="POST">
            @csrf

            <!-- Input NIK -->
            <div class="form-group">
                <label for="nik" class="form-label" style="font-weight: 600; color: var(--text-1); display: block; margin-bottom: 6px;">
                    Nomor Induk Kependudukan (NIK) <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="nik" id="nik" maxlength="16" value="{{ old('nik') }}"
                    placeholder="Contoh: 3302012304950001 (Wajib tepat 16 digit)"
                    class="form-input" style="width: 100%;">
                <p style="font-size: 11.5px; color: var(--text-3); margin-top: 4px;">Format NIK wajib tepat 16 digit angka numerik dan belum pernah terdaftar di sistem.</p>
                @error('nik')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Nama -->
            <div class="form-group">
                <label for="nama" class="form-label" style="font-weight: 600; color: var(--text-1); display: block; margin-bottom: 6px;">
                    Nama Lengkap Kepala Keluarga / Penerima <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                    placeholder="Masukkan nama lengkap sesuai KTP"
                    class="form-input" style="width: 100%;">
                @error('nama')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Alamat -->
            <div class="form-group">
                <label for="alamat" class="form-label" style="font-weight: 600; color: var(--text-1); display: block; margin-bottom: 6px;">
                    Alamat Lengkap (RT/RW / Nama Jalan) <span style="color: #ef4444;">*</span>
                </label>
                <textarea name="alamat" id="alamat" rows="2"
                    placeholder="Contoh: RT 02 / RW 03, Jl. Gerilya No. 12"
                    class="form-textarea" style="width: 100%;">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Kelurahan & Kecamatan Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label for="kelurahan" class="form-label" style="font-weight: 600; color: var(--text-1); display: block; margin-bottom: 6px;">
                        Desa / Kelurahan <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan') }}"
                        placeholder="Contoh: Purwokerto Kidul"
                        class="form-input" style="width: 100%;">
                    @error('kelurahan')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="kecamatan" class="form-label" style="font-weight: 600; color: var(--text-1); display: block; margin-bottom: 6px;">
                        Kecamatan <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="kecamatan" id="kecamatan" class="form-select" style="width: 100%;">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach ($daftarKecamatan as $kec)
                            <option value="{{ $kec }}" {{ old('kecamatan') == $kec ? 'selected' : '' }}>
                                Kecamatan {{ $kec }}
                            </option>
                        @endforeach
                    </select>
                    @error('kecamatan')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Kabupaten -->
            <div class="form-group" style="margin-bottom: 24px;">
                <label for="kabupaten" class="form-label" style="font-weight: 600; color: var(--text-1); display: block; margin-bottom: 6px;">
                    Kabupaten
                </label>
                <input type="text" name="kabupaten" id="kabupaten" value="Banyumas" readonly
                    class="form-input" style="width: 100%; background: var(--surface-2); color: var(--text-3); cursor: not-allowed;">
            </div>

            <!-- Tombol Aksi -->
            <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 16px; border-top: 1px solid var(--border);">
                <a href="{{ route('penamas.penerima.index') }}" class="btn btn-secondary">
                    <span>&larr; Batal & Kembali</span>
                </a>
                <button type="submit" class="btn btn-primary" style="padding: 9px 20px;">
                    <span>Simpan Data Penerima</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
