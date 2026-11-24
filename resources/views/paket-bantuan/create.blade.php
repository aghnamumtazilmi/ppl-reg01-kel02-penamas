@extends('layouts.app')

@section('page-title', 'Tambah Paket Bantuan')
@section('page-subtitle', 'Definisikan jenis paket dan komponen takaran komoditas pangan baru')

@section('page-actions')
    <a href="{{ route('penamas.paket-bantuan.index') }}" class="btn btn-secondary btn-sm">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar
    </a>
@endsection

@section('content')
<form action="{{ route('penamas.paket-bantuan.store') }}" method="POST" id="formPaketBantuan">
    @csrf

    <!-- Informasi Utama Paket -->
    <div class="card mb-4">
        <div class="card-header">
            <div>
                <div class="card-title">Informasi Dasar Paket</div>
                <div class="card-sub">Nama dan keterangan umum identitas paket bantuan</div>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="nama" class="form-label">Nama Paket Bantuan <span style="color: #ef4444;">*</span></label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="form-input @error('nama') is-invalid @enderror" placeholder="Contoh: Paket Sembako Reguler Tahap 1" required autofocus>
                @error('nama')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="deskripsi" class="form-label">Deskripsi / Peruntukan</label>
                <textarea id="deskripsi" name="deskripsi" class="form-textarea @error('deskripsi') is-invalid @enderror" placeholder="Contoh: Ditujukan untuk masyarakat prasejahtera terdampak rawan pangan di Kabupaten Banyumas.">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Datalist Autocomplete dari Master Stok Gudang -->
    <datalist id="datalistKomoditas">
        @foreach($komoditasList as $k)
            <option value="{{ $k->nama_barang }}" data-satuan="{{ $k->satuan }}">{{ $k->nama_barang }} (Satuan: {{ $k->satuan }})</option>
        @endforeach
    </datalist>

    <!-- Rincian Komponen Barang Dinamis -->
    <div class="card mb-4">
        <div class="card-header">
            <div>
                <div class="card-title">Rincian Komponen Barang</div>
                <div class="card-sub">Tambahkan daftar komoditas dan takaran standar yang masuk ke dalam paket ini</div>
            </div>
            <button type="button" class="btn btn-secondary btn-sm" onclick="tambahBaris()">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Baris Barang
            </button>
        </div>

        @error('komponen')
            <div class="alert alert-error" style="margin: 14px 16px 0;">
                <svg style="width:16px;height:16px;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $message }}</span>
            </div>
        @enderror

        <div class="table-wrap">
            <table id="tabelKomponen">
                <thead>
                    <tr>
                        <th style="width: 48px; text-align: center;">No</th>
                        <th style="min-width: 250px;">Nama Komoditas Barang <span style="color: #ef4444;">*</span></th>
                        <th style="width: 160px;">Jumlah / Takaran <span style="color: #ef4444;">*</span></th>
                        <th style="width: 140px;">Satuan <span style="color: #ef4444;">*</span></th>
                        <th style="width: 80px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="komponenContainer">
                    @php
                        $oldKomponen = old('komponen', [
                            ['nama_barang' => '', 'jumlah' => '', 'satuan' => '']
                        ]);
                    @endphp

                    @foreach($oldKomponen as $idx => $item)
                        <tr class="baris-komponen">
                            <td class="nomor-baris" style="text-align: center; color: var(--text-3); font-weight: 600;">
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <input type="text" name="komponen[{{ $idx }}][nama_barang]" value="{{ $item['nama_barang'] ?? '' }}" list="datalistKomoditas" class="form-input input-nama-barang" placeholder="Ketik atau pilih komoditas..." required onchange="autoFillSatuan(this)">
                                @error("komponen.{$idx}.nama_barang")
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="number" name="komponen[{{ $idx }}][jumlah]" value="{{ $item['jumlah'] ?? '' }}" step="0.01" min="0.01" class="form-input" placeholder="Contoh: 5" required>
                                @error("komponen.{$idx}.jumlah")
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="text" name="komponen[{{ $idx }}][satuan]" value="{{ $item['satuan'] ?? '' }}" class="form-input input-satuan" placeholder="kg, liter, dll" required>
                                @error("komponen.{$idx}.satuan")
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn btn-ghost btn-xs btn-hapus-baris" style="color: #ef4444;" onclick="hapusBaris(this)" title="Hapus baris ini">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding: 10px 16px; background: var(--surface-2); border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
            <span style="font-size: 11.5px; color: var(--text-3);">
                Tip: Nama barang dapat dipilih dari saran komoditas stok gudang yang tersedia.
            </span>
            <button type="button" class="btn btn-secondary btn-xs" onclick="tambahBaris()">
                + Tambah Baris
            </button>
        </div>
    </div>

    <!-- Tombol Submit -->
    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px;">
        <a href="{{ route('penamas.paket-bantuan.index') }}" class="btn btn-ghost">Batal</a>
        <button type="submit" class="btn btn-primary">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Paket Bantuan
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    let barisIndex = {{ count($oldKomponen) }};

    function autoFillSatuan(input) {
        const val = input.value.trim();
        const option = document.querySelector(`#datalistKomoditas option[value="${val}"]`);
        if (option) {
            const satuan = option.getAttribute('data-satuan');
            if (satuan) {
                const tr = input.closest('tr');
                const satuanInput = tr.querySelector('.input-satuan');
                if (satuanInput && (!satuanInput.value || satuanInput.value === '')) {
                    satuanInput.value = satuan;
                }
            }
        }
    }

    function perbaruiNomorBaris() {
        const rows = document.querySelectorAll('#komponenContainer .baris-komponen');
        rows.forEach((row, i) => {
            const noCell = row.querySelector('.nomor-baris');
            if (noCell) noCell.textContent = i + 1;
        });
    }

    function tambahBaris() {
        const container = document.getElementById('komponenContainer');
        const tr = document.createElement('tr');
        tr.className = 'baris-komponen';
        tr.innerHTML = `
            <td class="nomor-baris" style="text-align: center; color: var(--text-3); font-weight: 600;"></td>
            <td>
                <input type="text" name="komponen[${barisIndex}][nama_barang]" list="datalistKomoditas" class="form-input input-nama-barang" placeholder="Ketik atau pilih komoditas..." required onchange="autoFillSatuan(this)">
            </td>
            <td>
                <input type="number" name="komponen[${barisIndex}][jumlah]" step="0.01" min="0.01" class="form-input" placeholder="Contoh: 5" required>
            </td>
            <td>
                <input type="text" name="komponen[${barisIndex}][satuan]" class="form-input input-satuan" placeholder="kg, liter, dll" required>
            </td>
            <td style="text-align: center;">
                <button type="button" class="btn btn-ghost btn-xs btn-hapus-baris" style="color: #ef4444;" onclick="hapusBaris(this)" title="Hapus baris ini">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </td>
        `;
        container.appendChild(tr);
        barisIndex++;
        perbaruiNomorBaris();
        tr.querySelector('.input-nama-barang').focus();
    }

    function hapusBaris(btn) {
        const rows = document.querySelectorAll('#komponenContainer .baris-komponen');
        if (rows.length <= 1) {
            alert('Minimal harus ada 1 komponen barang dalam paket bantuan.');
            return;
        }
        btn.closest('tr').remove();
        perbaruiNomorBaris();
    }

    perbaruiNomorBaris();
</script>
@endpush
