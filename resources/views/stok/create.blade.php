@extends('layouts.app')

@section('page-title', 'Tambah Komoditas Baru')
@section('page-subtitle', 'Daftarkan jenis komoditas bahan pangan baru beserta satuan dan persediaan awal di gudang logistik')

@section('page-actions')
    <a href="{{ route('penamas.stok.index') }}" class="btn btn-secondary" style="border-radius: 8px;">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 13px; height: 13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        <span>Kembali ke Daftar Stok</span>
    </a>
@endsection

@section('content')
<div style="max-width: 640px; margin: 0 auto; width: 100%;">
    <div class="card" style="border-radius: 14px; padding: 24px;">
        <!-- Header Formulir dengan garis pemisah yang seragam -->
        <div style="margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--border);">
            <div class="card-title" style="font-size: 14px; font-weight: 600; color: var(--text-1);">Formulir Pendaftaran Komoditas Pangan</div>
            <div class="card-sub" style="margin-top: 2px;">Lengkapi data komoditas pangan yang masuk ke gudang logistik</div>
        </div>

        <form action="{{ route('penamas.stok.store') }}" method="POST">
            @csrf

            <!-- Field 1: Nama Barang -->
            <div class="form-group">
                <label for="nama_barang" class="form-label">
                    Nama Komoditas Pangan <span style="color: #ef4444;">*</span>
                </label>
                <input 
                    type="text" 
                    id="nama_barang" 
                    name="nama_barang" 
                    value="{{ old('nama_barang') }}"
                    placeholder="Contoh: Beras Premium, Minyak Goreng, Gula Pasir" 
                    class="form-input"
                    style="width: 100%; border-radius: 8px;"
                    required
                >
                @error('nama_barang')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Field 2: Satuan (Custom Dropdown Ber-Corner Radius Halus) -->
            <div class="form-group" style="position: relative;">
                <label for="satuan_trigger" class="form-label">
                    Satuan Kuantitas <span style="color: #ef4444;">*</span>
                </label>
                
                <!-- Hidden input untuk menangkap value ke backend Laravel -->
                <input type="hidden" name="satuan" id="satuan_input" value="{{ old('satuan') }}" required>

                <!-- Trigger Button Dropdown -->
                <button 
                    type="button" 
                    id="satuan_trigger"
                    class="form-input" 
                    style="width: 100%; border-radius: 8px; padding: 9px 14px; text-align: left; display: flex; align-items: center; justify-content: space-between; cursor: pointer; background: var(--surface); color: var(--text-1);"
                    onclick="toggleDropdownMenu()"
                    aria-haspopup="listbox"
                    aria-expanded="false"
                >
                    <span id="selected_satuan_label" style="font-size: 12.5px; color: {{ old('satuan') ? 'var(--text-1)' : 'var(--text-3)' }}; font-weight: 500;">
                        @php
                            $satuanLabels = [
                                'kg' => 'kg (Kilogram)',
                                'liter' => 'liter (Liter)',
                                'dus' => 'dus (Dus / Karton)',
                                'kaleng' => 'kaleng (Kaleng)',
                                'pack' => 'pack (Pack / Bungkus)',
                                'karung' => 'karung (Karung)',
                                'botol' => 'botol (Botol)',
                            ];
                        @endphp
                        {{ old('satuan') ? ($satuanLabels[old('satuan')] ?? old('satuan')) : '-- Pilih Satuan Kuantitas --' }}
                    </span>
                    <svg id="dropdown_arrow" style="width: 14px; height: 14px; color: var(--text-3); transition: transform 0.2s;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Menu Card Dropdown dengan Corner Radius 12px & Shadow Halus -->
                <div 
                    id="satuan_menu" 
                    style="display: none; position: absolute; left: 0; right: 0; top: calc(100% + 6px); z-index: 50; background: var(--surface); border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 12px 28px -6px rgba(0, 0, 0, 0.15), 0 6px 12px -4px rgba(0, 0, 0, 0.08); padding: 6px; max-height: 240px; overflow-y: auto;"
                    role="listbox"
                >
                    @foreach($satuanLabels as $val => $label)
                        <div 
                            class="dropdown-item" 
                            style="padding: 8px 12px; border-radius: 7px; font-size: 12.5px; cursor: pointer; display: flex; align-items: center; justify-content: space-between; transition: background 0.12s, color 0.12s; color: var(--text-1);"
                            onmouseover="this.style.background='var(--active-bg)'"
                            onmouseout="this.style.background='transparent'"
                            onclick="selectSatuanOption('{{ $val }}', '{{ $label }}')"
                        >
                            <span style="font-weight: 500;">{{ $label }}</span>
                            <span class="badge badge-draft" style="border-radius: 5px; font-size: 10.5px;">{{ $val }}</span>
                        </div>
                    @endforeach
                </div>

                @error('satuan')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Field 3: Jumlah Awal -->
            <div class="form-group">
                <label for="jumlah" class="form-label">
                    Jumlah Fisik Awal di Gudang <span style="color: #ef4444;">*</span>
                </label>
                <input 
                    type="number" 
                    id="jumlah" 
                    name="jumlah" 
                    value="{{ old('jumlah', 0) }}"
                    class="form-input"
                    style="width: 100%; border-radius: 8px;"
                    required
                >
                @error('jumlah')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 24px;">
                <a href="{{ route('penamas.stok.index') }}" class="btn btn-secondary" style="border-radius: 8px; padding: 7px 14px;">Batal</a>
                <button type="submit" class="btn btn-primary" style="border-radius: 8px; padding: 7px 16px;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 13px; height: 13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Komoditas</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleDropdownMenu() {
        const menu = document.getElementById('satuan_menu');
        const arrow = document.getElementById('dropdown_arrow');
        const trigger = document.getElementById('satuan_trigger');
        const isOpen = menu.style.display === 'block';

        if (isOpen) {
            menu.style.display = 'none';
            arrow.style.transform = 'rotate(0deg)';
            trigger.setAttribute('aria-expanded', 'false');
        } else {
            menu.style.display = 'block';
            arrow.style.transform = 'rotate(180deg)';
            trigger.setAttribute('aria-expanded', 'true');
        }
    }

    function selectSatuanOption(value, label) {
        document.getElementById('satuan_input').value = value;
        const labelEl = document.getElementById('selected_satuan_label');
        labelEl.textContent = label;
        labelEl.style.color = 'var(--text-1)';
        toggleDropdownMenu();
    }

    // Tutup dropdown jika klik di luar
    document.addEventListener('click', function(event) {
        const trigger = document.getElementById('satuan_trigger');
        const menu = document.getElementById('satuan_menu');
        if (trigger && menu && !trigger.contains(event.target) && !menu.contains(event.target)) {
            menu.style.display = 'none';
            document.getElementById('dropdown_arrow').style.transform = 'rotate(0deg)';
            trigger.setAttribute('aria-expanded', 'false');
        }
    });
</script>
@endsection
