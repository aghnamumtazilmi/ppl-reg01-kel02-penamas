@extends('layouts.app')

@section('page-title', 'Data Penerima Bantuan')
@section('page-subtitle', 'Daftar Keluarga Penerima Manfaat (KPM) Kabupaten Banyumas')

@section('page-actions')
    <a href="{{ route('penerima.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>Tambah Penerima Baru</span>
    </a>
@endsection

@section('content')
<!-- Filter Pencarian & Wilayah Kecamatan -->
<div class="card" style="margin-bottom: 20px; padding: 16px;">
    <form action="{{ route('penamas.penerima.index') }}" method="GET">
        <div style="display: grid; grid-template-columns: 1.8fr 1.4fr 1.2fr auto; gap: 12px; align-items: flex-end;">
            <div>
                <label class="form-label" style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--text-2); margin-bottom: 6px; display: block;">
                    Cari NIK atau Nama
                </label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik NIK 16 digit atau nama..."
                    class="form-input" style="width: 100%; height: 38px;">
            </div>

            <div>
                <label class="form-label" style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--text-2); margin-bottom: 6px; display: block;">
                    Filter Kecamatan
                </label>
                <select name="kecamatan" class="form-select" style="width: 100%; height: 38px;">
                    <option value="">-- Semua Kecamatan --</option>
                    @foreach($daftarKecamatan as $kec)
                        <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label" style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--text-2); margin-bottom: 6px; display: block;">
                    Filter Status
                </label>
                <select name="status" class="form-select" style="width: 100%; height: 38px;">
                    <option value="">-- Semua Status --</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-primary" style="height: 38px; padding: 0 16px; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <span>Filter</span>
                </button>
                <a href="{{ route('penamas.penerima.index') }}" class="btn btn-secondary" style="height: 38px; padding: 0 14px; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;" title="Reset Filter">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    <span>Reset</span>
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Tabel Daftar Penerima Bantuan -->
<div class="card">
    <div class="card-header" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border-bottom: 1px solid var(--border);">
        <div>
            <h3 class="card-title" style="font-size: 14px; font-weight: 700; color: var(--text-1);">Daftar Warga Penerima Manfaat</h3>
            <p class="card-sub" style="font-size: 12px; color: var(--text-2);">Total terdata: <strong>{{ $penerima->total() }}</strong> warga KPM</p>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">No</th>
                    <th>NIK</th>
                    <th>Nama Lengkap</th>
                    <th>Kecamatan</th>
                    <th>Alamat Lengkap</th>
                    <th style="text-align: center;">Status</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penerima as $index => $warga)
                    <tr>
                        <td style="text-align: center; color: var(--text-3); font-size: 12px;">
                            {{ $penerima->firstItem() + $index }}
                        </td>
                        <td style="font-family: monospace; font-weight: 600; font-size: 12.5px;">
                            {{ $warga->nik }}
                        </td>
                        <td style="font-weight: 600; color: var(--text-1);">
                            {{ $warga->nama }}
                        </td>
                        <td>
                            <span style="font-weight: 500; color: var(--text-1); font-size: 12.5px;">{{ $warga->kecamatan }}</span>
                        </td>
                        <td style="color: var(--text-2); font-size: 12px; max-width: 260px;">
                            {{ $warga->alamat }}
                        </td>
                        <td style="text-align: center;">
                            @if($warga->status === 'aktif')
                                <span class="badge badge-aktif">Aktif</span>
                            @else
                                <span class="badge badge-nonaktif">Nonaktif</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <div style="display: inline-flex; gap: 4px;">
                                <a href="{{ route('penerima.edit', $warga->id) }}" class="btn btn-secondary btn-xs" title="Ubah Data">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 12px; height: 12px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    <span>Ubah</span>
                                </a>
                                <form action="{{ route('penerima.destroy', $warga->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penerima {{ $warga->nama }}?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" title="Hapus Data">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 12px; height: 12px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 36px; color: var(--text-3);">
                            Tidak ada data penerima bantuan yang cocok dengan pencarian atau filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($penerima->hasPages())
        <div style="padding: 12px 18px; border-top: 1px solid var(--border);">
            {{ $penerima->links() }}
        </div>
    @endif
</div>
@endsection
