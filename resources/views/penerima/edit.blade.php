@extends('layouts.app')

@section('page-title', 'Ubah Data Penerima Bantuan')
@section('page-subtitle', 'Perbarui data alamat dan status keaktifan warga KPM')

@section('page-actions')
    <a href="{{ route('penamas.penerima.index') }}" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 6px;">
        <span>&larr; Kembali ke Daftar</span>
    </a>
@endsection

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header" style="padding: 16px 20px; border-bottom: 1px solid var(--border);">
        <h3 class="card-title" style="font-size: 14px; font-weight: 700; color: var(--text-1);">Formulir Pembaruan Data Warga KPM</h3>
        <p class="card-sub" style="font-size: 12px; color: var(--text-2);">NIK bersifat permanen dan tidak dapat diubah.</p>
    </div>

    <div class="card-body" style="padding: 24px;">
        @if (isset($errors) && $errors->any())
            <div class="alert alert-error" style="margin-bottom: 20px;">
                <svg style="width:16px;height:16px;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <strong style="display:block; margin-bottom: 4px;">Gagal Menyimpan Perubahan:</strong>
                    <ul style="margin: 0; padding-left: 18px; font-size: 12px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('penerima.update', $penerima->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- NIK (Readonly) -->
            <div class="form-group">
                <label class="form-label" style="font-weight: 600; color: var(--text-1); display: block; margin-bottom: 6px;">
                    Nomor Induk Kependudukan (NIK)
                </label>
                <input type="text" value="{{ $penerima->nik }}" readonly
                    class="form-input" style="width: 100%; font-family: monospace; background: var(--surface-2); color: var(--text-3); cursor: not-allowed;">
                <p style="font-size: 11.5px; color: var(--text-3); margin-top: 4px;">NIK bersifat permanen sesuai kependudukan resmi dan tidak dapat diubah.</p>
            </div>

            <!-- Input Nama -->
            <div class="form-group">
                <label for="nama" class="form-label" style="font-weight: 600; color: var(--text-1); display: block; margin-bottom: 6px;">
                    Nama Lengkap Kepala Keluarga / Penerima <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $penerima->nama) }}"
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
                    class="form-textarea" style="width: 100%;">{{ old('alamat', $penerima->alamat) }}</textarea>
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
                    <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan', $penerima->kelurahan) }}"
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
                        @foreach ($daftarKecamatan as $kec)
                            <option value="{{ $kec }}" {{ old('kecamatan', $penerima->kecamatan) == $kec ? 'selected' : '' }}>
                                Kecamatan {{ $kec }}
                            </option>
                        @endforeach
                    </select>
                    @error('kecamatan')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Kabupaten & Status Penerima Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                <div>
                    <label for="kabupaten" class="form-label" style="font-weight: 600; color: var(--text-1); display: block; margin-bottom: 6px;">
                        Kabupaten
                    </label>
                    <input type="text" name="kabupaten" id="kabupaten" value="{{ old('kabupaten', $penerima->kabupaten ?? 'Banyumas') }}"
                        class="form-input" style="width: 100%; background: var(--surface-2); color: var(--text-3); cursor: not-allowed;" readonly>
                </div>

                <div>
                    <label for="status" class="form-label" style="font-weight: 600; color: var(--text-1); display: block; margin-bottom: 6px;">
                        Status Penerima <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="status" id="status" class="form-select" style="width: 100%;">
                        <option value="aktif" {{ old('status', $penerima->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $penerima->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 16px; border-top: 1px solid var(--border);">
                <a href="{{ route('penamas.penerima.index') }}" class="btn btn-secondary">
                    <span>&larr; Batal & Kembali</span>
                </a>
                <button type="submit" class="btn btn-primary" style="padding: 9px 20px;">
                    <span>Simpan Perubahan Data & Status</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
