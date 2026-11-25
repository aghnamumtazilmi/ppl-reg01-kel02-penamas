@extends('layouts.app')

@section('page-title', 'Catat Mutasi Masuk')
@section('page-subtitle', 'Pencatatan komoditas pangan masuk ke gudang dari pengadaan dinas, donatur, atau BULOG')

@section('page-actions')
    <a href="{{ route('penamas.stok.mutasi') }}" class="btn btn-secondary" style="display:inline-flex; align-items:center; gap:6px;">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px; height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        <span>&larr; Kembali ke Riwayat Mutasi</span>
    </a>
@endsection

@section('content')
<div style="max-width:760px; margin:0 auto; display:flex; flex-direction:column; gap:20px;">

    {{-- Alert Error Global --}}
    @if ($errors->any())
        <div class="alert alert-error">
            <div style="font-weight:700; margin-bottom:6px; display:flex; align-items:center; gap:6px;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px; height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Terdapat kesalahan input:</span>
            </div>
            <ul style="margin-left:22px; font-size:12px; line-height:1.5;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- ── FORMULIR PENCATATAN BARANG MASUK ── -->
    <div class="card" style="padding:28px 32px;">
        <form action="{{ route('stok-mutasi.store') }}" method="POST" id="formMutasiMasuk">
            @csrf

            <!-- 1. PILIH KOMODITAS BARANG -->
            <div style="margin-bottom:20px;">
                <label for="stok_bantuan_id" class="form-label" style="display:block; font-size:13px; font-weight:600; color:var(--text-1); margin-bottom:6px;">
                    Pilih Nama Komoditas Barang <span style="color:#ef4444;">*</span>
                </label>
                <select name="stok_bantuan_id" id="stok_bantuan_id" required class="form-select"
                        style="width:100%; padding:10px 14px; font-size:13px; cursor:pointer;">
                    <option value="" data-satuan="" data-jumlah="0">-- Pilih Komoditas Pangan di Gudang --</option>
                    @foreach ($daftarBarang as $barang)
                        <option value="{{ $barang->id }}" 
                                data-satuan="{{ $barang->satuan }}"
                                data-jumlah="{{ $barang->jumlah }}"
                                data-nama="{{ $barang->nama_barang }}"
                                {{ old('stok_bantuan_id') == $barang->id ? 'selected' : '' }}>
                            {{ $barang->nama_barang }} &nbsp;&mdash;&nbsp; Stok Tersedia: {{ number_format($barang->jumlah) }} {{ $barang->satuan }}
                        </option>
                    @endforeach
                </select>
                @error('stok_bantuan_id')
                    <div style="font-size:11.5px; color:#dc2626; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- 2. JUMLAH VOLUME MASUK -->
            <div style="margin-bottom:20px;">
                <label for="jumlah" class="form-label" style="display:block; font-size:13px; font-weight:600; color:var(--text-1); margin-bottom:6px;">
                    Jumlah Volume Masuk <span style="color:#ef4444;">*</span>
                </label>
                <div style="position:relative;">
                    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}"
                        min="1" required placeholder="Contoh: 500" class="form-input"
                        style="width:100%; padding:10px 70px 10px 14px; font-size:13px; font-weight:700;">
                    <div style="position:absolute; right:14px; top:50%; transform:translateY(-50%); pointer-events:none; font-size:11.5px; font-weight:700; color:var(--text-3);" id="badgeSatuan">
                        Unit
                    </div>
                </div>
                @error('jumlah')
                    <div style="font-size:11.5px; color:#dc2626; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- 3. SIMULASI REAL-TIME PENAMBAHAN STOK -->
            <div id="boxSimulasi" style="display:none; padding:16px 18px; border-radius:10px; background:var(--surface-2); border:1px solid var(--border); margin-bottom:20px;">
                <div style="display:flex; justify-content:space-between; align-items:center; font-size:12px; font-weight:700; color:var(--text-2); margin-bottom:12px;">
                    <span style="display:flex; align-items:center; gap:6px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:15px; height:15px; color:#16a34a;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Simulasi Kalkulasi Stok Otomatis
                    </span>
                    <span style="background:var(--tag-green-bg); color:var(--tag-green-fg); border:1px solid var(--tag-green-border); border-radius:9999px; padding:2px 10px; font-size:11px; font-weight:600;">
                        Auto-Calculate
                    </span>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; text-align:center;">
                    <div style="background:var(--surface); padding:10px; border-radius:8px; border:1px solid var(--border);">
                        <span style="font-size:11px; color:var(--text-3); display:block;">Stok Saat Ini</span>
                        <strong style="font-size:14px; color:var(--text-1);" id="simSaldoLama">0</strong>
                    </div>
                    <div style="background:var(--tag-green-bg); padding:10px; border-radius:8px; border:1px solid var(--tag-green-border);">
                        <span style="font-size:11px; color:var(--tag-green-fg); display:block;">+ Jumlah Masuk</span>
                        <strong style="font-size:14px; color:var(--tag-green-fg);" id="simJumlahMasuk">+0</strong>
                    </div>
                    <div style="background:var(--surface); color:var(--text-1); padding:10px; border-radius:8px; border:1px solid var(--border);">
                        <span style="font-size:11px; color:var(--text-3); display:block;">Total Estimasi</span>
                        <strong style="font-size:14px; color:var(--text-1);" id="simSaldoBaru">0</strong>
                    </div>
                </div>
            </div>

            <!-- 4. KETERANGAN SUMBER PENGADAAN BARANG -->
            <div style="margin-bottom:24px;">
                <label for="keterangan" class="form-label" style="display:block; font-size:13px; font-weight:600; color:var(--text-1); margin-bottom:6px;">
                    Keterangan Sumber Barang <span style="color:#ef4444;">*</span>
                </label>
                <textarea name="keterangan" id="keterangan" rows="3" required class="form-textarea"
                    placeholder="Contoh: Pengadaan Beras Cadangan Pangan Pemerintah Daerah (APBD Banyumas 2026) No. BA: 024/BA-PANGAN/XI/2026"
                    style="width:100%; padding:10px 14px; font-size:13px; resize:vertical; line-height:1.5;">{{ old('keterangan') }}</textarea>
                
                <!-- Rekomendasi Cepat Sumber Barang -->
                <div style="display:flex; flex-wrap:wrap; gap:6px; align-items:center; margin-top:10px;">
                    <span style="font-size:11px; color:var(--text-3); font-weight:600;">Rekomendasi Cepat:</span>
                    <button type="button" onclick="setKeterangan('Pengadaan APBD Dinsospermades Kab. Banyumas TA 2026')" 
                            class="btn btn-secondary" style="font-size:11px; padding:4px 10px;">
                        + APBD Dinsospermades
                    </button>
                    <button type="button" onclick="setKeterangan('Bantuan Cadangan Pangan Perum BULOG KC Banyumas')" 
                            class="btn btn-secondary" style="font-size:11px; padding:4px 10px;">
                        + BULOG Banyumas
                    </button>
                    <button type="button" onclick="setKeterangan('Donasi Sembako BAZNAS Kabupaten Banyumas')" 
                            class="btn btn-secondary" style="font-size:11px; padding:4px 10px;">
                        + BAZNAS
                    </button>
                    <button type="button" onclick="setKeterangan('Hibah CSR Pangan PT. Sinar Harapan Banyumas')" 
                            class="btn btn-secondary" style="font-size:11px; padding:4px 10px;">
                        + CSR Perusahaan
                    </button>
                </div>

                @error('keterangan')
                    <div style="font-size:11.5px; color:#dc2626; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- 5. TOMBOL AKSI SUBMIT & BATAL -->
            <div style="display:flex; justify-content:flex-end; gap:10px; padding-top:20px; border-top:1px solid var(--border);">
                <a href="{{ route('penamas.stok.mutasi') }}" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:6px;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px; height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Mutasi Masuk</span>
                </button>
            </div>

        </form>
    </div>

</div>

<!-- Script Dynamic UI & Simulasi Penambahan Stok -->
<script>
    const selectBarang = document.getElementById('stok_bantuan_id');
    const inputJumlah  = document.getElementById('jumlah');
    const badgeSatuan  = document.getElementById('badgeSatuan');
    const boxSimulasi  = document.getElementById('boxSimulasi');
    const simSaldoLama = document.getElementById('simSaldoLama');
    const simJumlahMasuk = document.getElementById('simJumlahMasuk');
    const simSaldoBaru = document.getElementById('simSaldoBaru');

    function updateSimulasi() {
        const selectedOpt = selectBarang.options[selectBarang.selectedIndex];
        const satuan = selectedOpt.getAttribute('data-satuan') || 'Unit';
        const saldoLama = parseInt(selectedOpt.getAttribute('data-jumlah') || 0);
        const masuk = parseInt(inputJumlah.value) || 0;

        badgeSatuan.textContent = satuan;

        if (selectBarang.value) {
            boxSimulasi.style.display = 'block';
            simSaldoLama.textContent = saldoLama.toLocaleString('id-ID') + ' ' + satuan;
            simJumlahMasuk.textContent = '+' + masuk.toLocaleString('id-ID') + ' ' + satuan;
            simSaldoBaru.textContent = (saldoLama + masuk).toLocaleString('id-ID') + ' ' + satuan;
        } else {
            boxSimulasi.style.display = 'none';
        }
    }

    function setKeterangan(teks) {
        document.getElementById('keterangan').value = teks;
        document.getElementById('keterangan').focus();
    }

    selectBarang.addEventListener('change', updateSimulasi);
    inputJumlah.addEventListener('input', updateSimulasi);

    // Jalankan saat pertama dimuat
    updateSimulasi();
</script>
@endsection
