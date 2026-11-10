<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use Illuminate\Http\Request;

class PenerimaController extends Controller
{
    /**
     * Menampilkan daftar penerima bantuan (opsional, untuk melihat hasil data)
     */
    public function index()
    {
        $penerima = Penerima::latest()->paginate(10);
        return view('penerima.index', compact('penerima'));
    }

    /**
     * Menampilkan Form Pendaftaran Penerima Bantuan Baru (PBI-004)
     */
    public function create()
    {
        return view('penerima.create');
    }

    /**
     * Memproses Penyimpanan Data & Validasi NIK 16 Digit (PBI-004)
     */
    public function store(Request $request)
    {
        // 1. Validasi Sesuai Acceptance Criteria PBI-004
        $validated = $request->validate([
            'nik' => [
                'required',
                'numeric',
                'digits:16',            // Menolak jika bukan 16 digit
                'unique:penerima,nik',  // Menolak jika NIK sudah pernah terdaftar
            ],
            'nama'      => 'required|string|max:255',
            'alamat'    => 'required|string',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'no_hp'     => 'nullable|string|max:20',
        ], [
            // Pesan Error Bahasa Indonesia yang Ramah
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric'  => 'NIK harus berupa angka.',
            'nik.digits'   => 'Format NIK salah! NIK harus tepat 16 digit angka.',
            'nik.unique'   => 'Pendaftaran ditolak! NIK ini sudah pernah terdaftar sebagai penerima.',
            'nama.required' => 'Nama penerima wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kelurahan.required' => 'Kelurahan/Desa wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
        ]);

        // 2. Set default sesuai SKEMA_DATABASE_PENAMAS
        $validated['kabupaten'] = $validated['kabupaten'] ?? 'Banyumas';
        $validated['status']    = 'aktif'; // Sesuai kriteria status default aktif

        // 3. Simpan ke database
        Penerima::create($validated);

        // 4. Kembali ke form dengan notifikasi sukses
        return redirect()->route('penerima.create')->with('success', 'Data Keluarga Penerima Manfaat (KPM) baru berhasil didaftarkan!');
    }
}