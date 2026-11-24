@extends('layouts.app')

@section('page-title', 'Ubah Data Penerima Bantuan')
@section('page-subtitle', 'Perbarui data alamat atau status aktif/nonaktif Keluarga Penerima Manfaat')

@section('page-actions')
    <a href="{{ route('penerima.index') }}" class="btn btn-secondary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        <span>Kembali ke Daftar</span>
    </a>
@endsection

@section('content')
<div class="card p-6" style="max-width: 680px; margin: 0 auto; width: 100%;">
    <!-- Info Singkat Penerima -->
    <div style="display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 8px; background: var(--surface-2); border: 1px solid var(--border); margin-bottom: 20px;">
        <div class="user-ava" style="width: 32px; height: 32px; font-size: 13px;">
            {{ strtoupper(substr($penerima->nama, 0, 1)) }}
        </div>
        <div>
            <div style="font-size: 11px; color: var(--text-3); text-transform: uppercase; font-weight: 600; letter-spacing: 0.04em;">Sedang Mengubah KPM:</div>
            <div style="font-size: 13px; font-weight: 600; color: var(--text-1);">{{ $penerima->nama }} <span style="font-weight: 400; color: var(--text-2); font-size: 12px; font-family: monospace;">(NIK: {{ $penerima->nik }})</span></div>
        </div>
    </div>

    <form action="{{ route('penerima.update', $penerima->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- NIK (Read-Only) -->
        <div class="form-group">
            <label class="form-label">NIK (Terkunci / Tidak Dapat Diubah)</label>
            <input type="text" value="{{ $penerima->nik }}" disabled class="form-input" style="opacity: 0.7; cursor: not-allowed; background: var(--surface-2);">
        </div>

        <!-- Nama Lengkap -->
        <div class="form-group">
            <label for="nama" class="form-label">
                Nama Lengkap Penerima <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" 
                   name="nama" 
                   id="nama" 
                   value="{{ old('nama', $penerima->nama) }}" 
                   required
                   class="form-input">
            @error('nama')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Status Penerima -->
        <div class="form-group">
            <label for="status" class="form-label">
                Status Penerima <span style="color: #ef4444;">*</span>
            </label>
            <select name="status" id="status" required class="form-select">
                <option value="aktif" {{ old('status', $penerima->status) == 'aktif' ? 'selected' : '' }}>Aktif (Berhak Menerima Bantuan)</option>
                <option value="nonaktif" {{ old('status', $penerima->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif (Pindah / Meninggal / Tidak Memenuhi Syarat)</option>
            </select>
            @error('status')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Alamat Domisili -->
        <div class="form-group">
            <label for="alamat" class="form-label">
                Alamat Domisili Lengkap <span style="color: #ef4444;">*</span>
            </label>
            <textarea name="alamat" 
                      id="alamat" 
                      rows="3" 
                      required
                      class="form-input">{{ old('alamat', $penerima->alamat) }}</textarea>
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
                    @foreach($daftarKecamatan as $kec)
                        <option value="{{ $kec }}" {{ old('kecamatan', $penerima->kecamatan) == $kec ? 'selected' : '' }}>{{ $kec }}</option>
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
                       value="{{ old('kelurahan', $penerima->kelurahan) }}" 
                       required
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
                   value="{{ old('no_hp', $penerima->no_hp) }}" 
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
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
@endsection
