@extends('layouts.app')

@section('page-title', 'Import Data Penerima Bantuan')
@section('page-subtitle', 'Unggah berkas Excel atau CSV untuk menambahkan data warga KPM secara massal')

@section('page-actions')
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('penamas.penerima.index') }}" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 6px;">
            <span>&larr; Kembali ke Daftar</span>
        </a>
        <a href="{{ route('penerima.create') }}" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 6px;">
            <span>Input Manual &rarr;</span>
        </a>
    </div>
@endsection

@section('content')
<div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 20px; align-items: start; max-width: 1100px; margin: 0 auto;">
    
    <!-- Bagian 1: Formulir Unggah Berkas -->
    <div class="card">
        <div class="card-header" style="padding: 16px 20px; border-bottom: 1px solid var(--border);">
            <h3 class="card-title" style="font-size: 14px; font-weight: 700; color: var(--text-1); margin: 0;">Unggah Berkas Excel / CSV</h3>
        </div>

        <div class="card-body" style="padding: 24px;">
            @if (session('warning'))
                <div class="alert alert-warning" style="margin-bottom: 20px;">
                    <svg style="width:16px;height:16px;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>{{ session('warning') }}</div>
                </div>
            @endif

            @if (isset($errors) && $errors->any())
                <div class="alert alert-error" style="margin-bottom: 20px;">
                    <svg style="width:16px;height:16px;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <strong style="display:block; margin-bottom: 4px;">Gagal Memproses Berkas:</strong>
                        <ul style="margin: 0; padding-left: 18px; font-size: 12px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Unduh Template Panduan -->
            <div style="background: var(--surface-2); border: 1px solid var(--border); border-radius: 8px; padding: 14px 16px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 12px;">
                <div>
                    <div style="font-size: 13px; font-weight: 600; color: var(--text-1);">Belum punya formatnya?</div>
                    <div style="font-size: 11.5px; color: var(--text-2);">Gunakan template resmi agar susunan kolom sesuai dengan sistem.</div>
                </div>
                <a href="{{ route('penamas.penerima.import.template') }}" class="btn btn-secondary" style="font-size: 12px; padding: 7px 14px; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh Template</span>
                </a>
            </div>

            <form action="{{ route('penamas.penerima.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- File Input Area -->
                <div class="form-group" style="margin-bottom: 24px;">
                    <label for="file" class="form-label" style="font-weight: 600; color: var(--text-1); display: block; margin-bottom: 8px;">
                        Pilih Berkas Excel / CSV <span style="color: #ef4444;">*</span>
                    </label>
                    <div style="border: 2px dashed var(--border); border-radius: 8px; padding: 24px 16px; text-align: center; background: var(--surface-2); cursor: pointer; position: relative;">
                        <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" required
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;"
                            onchange="updateFileName(this)">
                        
                        <div id="file-drop-info">
                            <div style="font-size: 32px; margin-bottom: 8px;">📁</div>
                            <div style="font-size: 13px; font-weight: 600; color: var(--text-1); margin-bottom: 4px;">
                                Klik atau Tarik berkas ke area ini
                            </div>
                            <div style="font-size: 11.5px; color: var(--text-3);">
                                Format yang didukung: <strong>.xlsx, .xls, .csv</strong> (Maks. 5 MB)
                            </div>
                        </div>

                        <div id="file-selected-name" style="display: none; font-size: 13px; font-weight: 600; color: #10b981; margin-top: 8px;">
                            Berkas terpilih: <span id="fileNameText"></span>
                        </div>
                    </div>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 16px; border-top: 1px solid var(--border);">
                    <a href="{{ route('penamas.penerima.index') }}" class="btn btn-secondary">
                        <span>&larr; Batal</span>
                    </a>
                    <button type="submit" class="btn btn-primary" style="padding: 9px 22px; display: inline-flex; align-items: center; gap: 8px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 15px; height: 15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span>Proses & Simpan Data</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bagian 2: Panduan Susunan Kolom -->
    <div class="card">
        <div class="card-header" style="padding: 16px 20px; border-bottom: 1px solid var(--border);">
            <h3 class="card-title" style="font-size: 14px; font-weight: 700; color: var(--text-1); margin: 0;">Ketentuan Susunan Kolom</h3>
        </div>

        <div class="card-body" style="padding: 20px;">
            <p style="font-size: 12px; color: var(--text-2); margin-top: 0; margin-bottom: 16px; line-height: 1.5;">
                Pastikan baris pertama (baris 1) berkas adalah <strong>nama kolom (header)</strong> dan isi data dimulai pada baris 2 dengan urutan sebagai berikut:
            </p>

            <div style="border: 1px solid var(--border); border-radius: 6px; overflow: hidden; margin-bottom: 16px;">
                <table style="width: 100%; border-collapse: collapse; font-size: 12px; text-align: left;">
                    <thead>
                        <tr style="background: var(--surface-2); border-bottom: 1px solid var(--border);">
                            <th style="padding: 8px 12px; font-weight: 600; color: var(--text-1);">Kolom</th>
                            <th style="padding: 8px 12px; font-weight: 600; color: var(--text-1);">Nama Kolom</th>
                            <th style="padding: 8px 12px; font-weight: 600; color: var(--text-1);">Aturan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 8px 12px; color: var(--text-3);">A</td>
                            <td style="padding: 8px 12px; font-weight: 600; color: var(--text-1);">nik</td>
                            <td style="padding: 8px 12px; color: var(--text-2);">Tepat 16 digit angka, unik</td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 8px 12px; color: var(--text-3);">B</td>
                            <td style="padding: 8px 12px; font-weight: 600; color: var(--text-1);">nama</td>
                            <td style="padding: 8px 12px; color: var(--text-2);">Nama lengkap KPM</td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 8px 12px; color: var(--text-3);">C</td>
                            <td style="padding: 8px 12px; font-weight: 600; color: var(--text-1);">alamat</td>
                            <td style="padding: 8px 12px; color: var(--text-2);">RT/RW atau nama jalan</td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 8px 12px; color: var(--text-3);">D</td>
                            <td style="padding: 8px 12px; font-weight: 600; color: var(--text-1);">kelurahan</td>
                            <td style="padding: 8px 12px; color: var(--text-2);">Nama kelurahan / desa</td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 8px 12px; color: var(--text-3);">E</td>
                            <td style="padding: 8px 12px; font-weight: 600; color: var(--text-1);">kecamatan</td>
                            <td style="padding: 8px 12px; color: var(--text-2);">Salah satu kecamatan di Banyumas</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 12px; color: var(--text-3);">F</td>
                            <td style="padding: 8px 12px; font-weight: 600; color: var(--text-1);">no_hp</td>
                            <td style="padding: 8px 12px; color: var(--text-3);">Nomor kontak (opsional)</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="font-size: 11.5px; color: var(--text-2); background: rgba(59, 130, 246, 0.08); border-left: 3px solid #3b82f6; padding: 10px 12px; border-radius: 4px;">
                💡 <strong>Catatan Keamanan:</strong> Baris yang NIK-nya tidak 16 digit atau sudah terdaftar di sistem akan dilewati secara otomatis tanpa menggagalkan data lainnya.
            </div>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    if (input.files && input.files[0]) {
        document.getElementById('fileNameText').innerText = input.files[0].name;
        document.getElementById('file-selected-name').style.display = 'block';
    }
}
</script>
@endsection
