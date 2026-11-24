@extends('layouts.app')

@section('page-title', 'Catat Mutasi Keluar Manual')
@section('page-subtitle', 'Pencatatan pengeluaran barang karena rusak, kadaluarsa, susut timbangan, atau tanggap darurat')

@section('page-actions')
    <a href="{{ route('penamas.stok.mutasi') }}" class="btn btn-secondary btn-sm" style="display:inline-flex; align-items:center; gap:6px;">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:13px; height:13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        <span>&larr; Kembali ke Riwayat Mutasi</span>
    </a>
@endsection

@section('content')
<div style="max-width:760px; margin:0 auto; display:flex; flex-direction:column; gap:20px;">

    {{-- Alert Error Global --}}
    @if ($errors->any())
        <div class="alert alert-danger" style="padding:12px 16px; border-radius:8px; background:var(--tag-red-bg); color:var(--tag-red-fg); border:1px solid var(--tag-red-border); font-size:12.5px;">
            <div style="font-weight:700; margin-bottom:4px; display:flex; align-items:center; gap:6px;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px; height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Terdapat kesalahan input:</span>
            </div>
            <ul style="margin-left:20px; font-size:12px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Alert Real-Time Over-Stock -->
    <div id="alertOverStock" style="display:none; padding:12px 16px; border-radius:8px; background:var(--tag-red-bg); color:var(--tag-red-fg); border:1px solid var(--tag-red-border); font-size:12.5px;">
        <div style="font-weight:700; display:flex; align-items:center; gap:6px;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px; height:16px; flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>Peringatan Proteksi: Jumlah Keluar Melebihi Stok Tersedia!</span>
        </div>
        <p style="margin:4px 0 0 22px; font-size:12px; line-height:1.4;" id="textAlertOverStock">
            Sistem menolak pengeluaran karena stok di gudang tidak mencukupi.
        </p>
    </div>

    <!-- ── FORMULIR PENGELUARAN BARANG MANUAL ── -->
    <div class="card" style="padding:24px;">
        <form action="{{ route('stok-mutasi.store-keluar') }}" method="POST" id="formMutasiKeluar">
            @csrf

            <!-- 1. PILIH KOMODITAS BARANG -->
            <div class="form-group">
                <label for="stok_bantuan_id" class="form-label" style="font-weight:600;">
                    Pilih Nama Komoditas Barang <span style="color:#ef4444;">*</span>
                </label>
                <select name="stok_bantuan_id" id="stok_bantuan_id" required class="form-select @error('stok_bantuan_id') is-invalid @enderror">
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
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- 2. KATEGORI ALASAN PENGELUARAN -->
            <div class="form-group">
                <label for="tipe_keluar" class="form-label" style="font-weight:600;">
                    Kategori Alasan Pengeluaran <span style="color:#ef4444;">*</span>
                </label>
                <select name="tipe_keluar" id="tipe_keluar" required class="form-select @error('tipe_keluar') is-invalid @enderror">
                    <option value="Barang Rusak" {{ old('tipe_keluar') === 'Barang Rusak' ? 'selected' : '' }}>Barang Rusak / Kemasan Robek Fisik</option>
                    <option value="Kadaluarsa" {{ old('tipe_keluar') === 'Kadaluarsa' ? 'selected' : '' }}>Kadaluarsa / Tak Layak Konsumsi</option>
                    <option value="Penyusutan / Selisih Fisik" {{ old('tipe_keluar') === 'Penyusutan / Selisih Fisik' ? 'selected' : '' }}>Penyusutan / Selisih Fisik Timbangan</option>
                    <option value="Distribusi Darurat / Khusus" {{ old('tipe_keluar') === 'Distribusi Darurat / Khusus' ? 'selected' : '' }}>Distribusi Tanggap Darurat Bencana</option>
                    <option value="Lainnya" {{ old('tipe_keluar') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('tipe_keluar')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- 3. JUMLAH VOLUME KELUAR -->
            <div class="form-group">
                <label for="jumlah" class="form-label" style="font-weight:600;">
                    Jumlah Volume Barang Keluar <span style="color:#ef4444;">*</span>
                </label>
                <div style="position:relative;">
                    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}"
                        min="1" required placeholder="Contoh: 15" class="form-input @error('jumlah') is-invalid @enderror"
                        style="padding-right:70px; font-weight:700;">
                    <div style="position:absolute; right:12px; top:50%; transform:translateY(-50%); pointer-events:none; font-size:11.5px; font-weight:700; color:var(--text-3);" id="badgeSatuan">
                        Unit
                    </div>
                </div>
                @error('jumlah')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- 4. SIMULASI REAL-TIME PENGURANGAN STOK -->
            <div id="boxSimulasi" style="display:none; padding:14px 16px; border-radius:8px; background:var(--surface-2); border:1px solid var(--border); margin-bottom:16px;">
                <div style="display:flex; justify-content:space-between; align-items:center; font-size:11.5px; font-weight:700; color:var(--text-2); margin-bottom:10px;">
                    <span style="display:flex; align-items:center; gap:6px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px; height:14px; color:#dc2626;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Proyeksi Sisa Stok Gudang
                    </span>
                    <span class="badge badge-diajukan">Proteksi Stok Minus</span>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; text-align:center;">
                    <div style="background:var(--surface); padding:8px; border-radius:6px; border:1px solid var(--border);">
                        <span style="font-size:10.5px; color:var(--text-3); display:block;">Stok Tersedia</span>
                        <strong style="font-size:13px; color:var(--text-1);" id="simSaldoLama">0</strong>
                    </div>
                    <div style="background:var(--tag-red-bg); padding:8px; border-radius:6px; border:1px solid var(--tag-red-border);">
                        <span style="font-size:10.5px; color:var(--tag-red-fg); display:block;">&minus; Jumlah Keluar</span>
                        <strong style="font-size:13px; color:var(--tag-red-fg);" id="simJumlahKeluar">-0</strong>
                    </div>
                    <div style="background:var(--accent); color:var(--accent-fg); padding:8px; border-radius:6px;" id="boxSimSisa">
                        <span style="font-size:10.5px; opacity:0.8; display:block;">Sisa Stok Gudang</span>
                        <strong style="font-size:13px;" id="simSaldoBaru">0</strong>
                    </div>
                </div>
            </div>

            <!-- 5. RINCIAN ALASAN PENGELUARAN -->
            <div class="form-group">
                <label for="keterangan" class="form-label" style="font-weight:600;">
                    Rincian Alasan Pengeluaran Barang <span style="color:#ef4444;">*</span>
                </label>
                <textarea name="keterangan" id="keterangan" rows="3" required
                    placeholder="Contoh: Pemusnahan 15 kg beras basah akibat rembesan atap gudang saat hujan lebat. Disaksikan Koordinator Gudang."
                    class="form-textarea @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                
                <!-- Rekomendasi Cepat Alasan -->
                <div style="display:flex; flex-wrap:wrap; gap:6px; align-items:center; margin-top:8px;">
                    <span style="font-size:11px; color:var(--text-3); font-weight:600;">Rekomendasi Cepat:</span>
                    <button type="button" onclick="setKeterangan('Kerusakan kemasan karung akibat rembesan air di Gudang Logistik B')" class="btn btn-secondary btn-xs">
                        + Kemasan Basah/Rusak
                    </button>
                    <button type="button" onclick="setKeterangan('Bahan pangan telah melewati masa simpan aman (kadaluarsa) sesuai BA No. 04/BA-MUSNAH/2026')" class="btn btn-secondary btn-xs">
                        + Kadaluarsa BA
                    </button>
                    <button type="button" onclick="setKeterangan('Penyusutan susut timbangan alami selama penyimpanan kuartal 4')" class="btn btn-secondary btn-xs">
                        + Susut Timbangan
                    </button>
                    <button type="button" onclick="setKeterangan('Penyaluran darurat tanggap bencana tanah longsor Desa Karangtengah Kec. Cilongok')" class="btn btn-secondary btn-xs">
                        + Darurat Bencana
                    </button>
                </div>

                @error('keterangan')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- 6. TOMBOL AKSI SUBMIT & BATAL -->
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px; padding-top:16px; border-top:1px solid var(--border);">
                <a href="{{ route('penamas.stok.mutasi') }}" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" id="btnSubmitKeluar" class="btn btn-danger" style="display:inline-flex; align-items:center; gap:6px; background:#dc2626; color:#fff; border-color:#b91c1c;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px; height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                    <span>Simpan Mutasi Keluar</span>
                </button>
            </div>

        </form>
    </div>

</div>

<!-- Script Dynamic UI, Validasi Over-Stock, & Simulasi Pengurangan -->
<script>
    const selectBarang       = document.getElementById('stok_bantuan_id');
    const inputJumlah        = document.getElementById('jumlah');
    const badgeSatuan        = document.getElementById('badgeSatuan');
    const boxSimulasi        = document.getElementById('boxSimulasi');
    const simSaldoLama       = document.getElementById('simSaldoLama');
    const simJumlahKeluar    = document.getElementById('simJumlahKeluar');
    const simSaldoBaru       = document.getElementById('simSaldoBaru');
    const alertOverStock     = document.getElementById('alertOverStock');
    const textAlertOverStock = document.getElementById('textAlertOverStock');
    const btnSubmitKeluar    = document.getElementById('btnSubmitKeluar');

    function updateSimulasi() {
        const selectedOpt = selectBarang.options[selectBarang.selectedIndex];
        const satuan = selectedOpt.getAttribute('data-satuan') || 'Unit';
        const namaBarang = selectedOpt.getAttribute('data-nama') || 'Komoditas';
        const saldoLama = parseInt(selectedOpt.getAttribute('data-jumlah') || 0);
        const keluar = parseInt(inputJumlah.value) || 0;

        badgeSatuan.textContent = satuan;

        if (selectBarang.value) {
            boxSimulasi.style.display = 'block';
            simSaldoLama.textContent = saldoLama.toLocaleString('id-ID') + ' ' + satuan;
            simJumlahKeluar.textContent = '-' + keluar.toLocaleString('id-ID') + ' ' + satuan;

            const sisa = saldoLama - keluar;

            if (keluar > saldoLama) {
                // OVER-STOCK DETECTED
                alertOverStock.style.display = 'block';
                textAlertOverStock.textContent = `Jumlah keluar (${keluar.toLocaleString('id-ID')} ${satuan}) melebihi stok ${namaBarang} yang tersedia di gudang (${saldoLama.toLocaleString('id-ID')} ${satuan})! Sistem memblokir pengeluaran agar saldo tidak minus.`;
                simSaldoBaru.textContent = sisa.toLocaleString('id-ID') + ' ' + satuan + ' (MINUS)';
                simSaldoBaru.style.color = '#ef4444';
                btnSubmitKeluar.disabled = true;
                btnSubmitKeluar.style.opacity = '0.5';
                btnSubmitKeluar.style.cursor = 'not-allowed';
            } else {
                alertOverStock.style.display = 'none';
                simSaldoBaru.textContent = sisa.toLocaleString('id-ID') + ' ' + satuan;
                simSaldoBaru.style.color = 'inherit';
                btnSubmitKeluar.disabled = false;
                btnSubmitKeluar.style.opacity = '1';
                btnSubmitKeluar.style.cursor = 'pointer';
            }
        } else {
            boxSimulasi.style.display = 'none';
            alertOverStock.style.display = 'none';
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
