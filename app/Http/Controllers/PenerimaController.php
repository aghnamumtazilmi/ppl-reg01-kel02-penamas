<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use Illuminate\Http\Request;

class PenerimaController extends Controller
{
    /**
     * Halaman Tabel Daftar Penerima
     * Menampilkan daftar warga penerima bantuan dengan status dan tombol aksi Edit.
     */
    public function index()
    {
        $penerima = Penerima::latest()->paginate(10);
        return view('penerima.index', compact('penerima'));
    }

    // =========================================================================
    // [PBI-004] FITUR PENDAFTARAN PENERIMA BANTUAN BARU
    // Kriteria: Admin mengisi NIK 16 digit, nama, alamat, kelurahan, kecamatan.
    // Sistem menolak jika format NIK salah atau NIK sudah pernah terdaftar.
    // =========================================================================

    /**
     * [PBI-004] Menampilkan Form Pendaftaran Penerima Baru
     */
    public function create()
    {
        return view('penerima.create');
    }

    /**
     * [PBI-004] Memproses Penyimpanan Data & Validasi NIK 16 Digit Unik
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => [
                'required',
                'numeric',
                'digits:16',            // AC 2: Validasi NIK wajib tepat 16 digit
                'unique:penerima,nik',  // AC 2: Validasi NIK belum pernah terdaftar
            ],
            'nama'      => 'required|string|max:255',
            'alamat'    => 'required|string',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'no_hp'     => 'nullable|string|max:20',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric'  => 'NIK harus berupa angka.',
            'nik.digits'   => 'Format NIK salah! NIK harus tepat 16 digit angka.',
            'nik.unique'   => 'Pendaftaran ditolak! NIK ini sudah pernah terdaftar sebagai penerima.',
            'nama.required' => 'Nama penerima wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kelurahan.required' => 'Kelurahan/Desa wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
        ]);

        $validated['kabupaten'] = $validated['kabupaten'] ?? 'Banyumas';
        $validated['status']    = 'aktif'; // Default pendaftaran awal adalah aktif

        Penerima::create($validated);

        return redirect()->route('penerima.index')->with('success', 'Data Keluarga Penerima Manfaat (KPM) baru berhasil didaftarkan!');
    }

    // =========================================================================
    // [PBI-005] FITUR MENGUBAH DATA ALAMAT ATAU STATUS PENERIMA
    // Kriteria:
    // 1. Admin dapat mengedit data warga atau mengubah statusnya (aktif/nonaktif).
    // 2. Penerima nonaktif tidak muncul saat pembuatan rencana bantuan.
    // =========================================================================

    /**
     * [PBI-005] Menampilkan Form Edit untuk Mengubah Alamat & Status Penerima
     */
    public function edit($id)
    {
        // Cari data penerima berdasarkan ID, jika tidak ada tampilkan 404
        $penerima = Penerima::findOrFail($id);

        return view('penerima.edit', compact('penerima'));
    }

    /**
     * [PBI-005] Memproses Pembaruan Data Alamat & Perubahan Status (Aktif/Nonaktif)
     */
    public function update(Request $request, $id)
    {
        $penerima = Penerima::findOrFail($id);

        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'alamat'    => 'required|string',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'no_hp'     => 'nullable|string|max:20',
            'status'    => 'required|in:aktif,nonaktif', // Kriteria Utama PBI-005: Aktif / Nonaktif
        ], [
            'status.required' => 'Status penerima wajib ditentukan.',
            'status.in'       => 'Pilihan status hanya boleh "aktif" atau "nonaktif".',
            'nama.required'   => 'Nama penerima wajib diisi.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'kelurahan.required' => 'Kelurahan/Desa wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
        ]);

        // Eksekusi update perubahan alamat dan status ke tabel penerima
        $penerima->update($validated);

        return redirect()->route('penerima.index')->with('success', 'Data alamat dan status penerima berhasil diperbarui!');
    }
}
