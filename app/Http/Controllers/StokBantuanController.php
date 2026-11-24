<?php

namespace App\Http\Controllers;

use App\Models\StokBantuan;
use App\Models\KomponenBantuan;
use Illuminate\Http\Request;

class StokBantuanController extends Controller
{
    /**
     * PBI-011: Menampilkan daftar seluruh komoditas pangan dan sisa stok di gudang.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query data komoditas pangan dengan filter pencarian jika ada
        $query = StokBantuan::query();

        if ($search) {
            $query->where('nama_barang', 'like', '%' . $search . '%');
        }

        // Ambil data dengan pagination 10 item per halaman
        $stokList = $query->orderBy('nama_barang', 'asc')->paginate(10)->withQueryString();

        // Ringkasan statistik cepat untuk kartu KPI di bagian atas tabel
        $totalJenisBarang = StokBantuan::count();
        $stokTersedia     = StokBantuan::where('jumlah', '>', 10)->count();
        $stokMenipis      = StokBantuan::whereBetween('jumlah', [1, 10])->count();
        $stokHabis        = StokBantuan::where('jumlah', '<=', 0)->count();

        return view('stok.index', compact(
            'stokList',
            'search',
            'totalJenisBarang',
            'stokTersedia',
            'stokMenipis',
            'stokHabis'
        ));
    }

    /**
     * PBI-010: Menampilkan formulir pendaftaran komoditas pangan baru.
     */
    public function create()
    {
        $satuanOptions = [
            'kg' => 'Kilogram (kg)',
            'liter' => 'Liter (L)',
            'kaleng' => 'Kaleng',
            'dus' => 'Dus / Karton',
            'karung' => 'Karung (25/50 kg)',
            'paket' => 'Paket',
            'pcs' => 'Pcs / Buah',
        ];

        return view('stok.create', compact('satuanOptions'));
    }

    /**
     * PBI-010: Menyimpan data komoditas pangan baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255|unique:stok_bantuan,nama_barang',
            'satuan' => 'required|string|max:50',
            'jumlah' => 'nullable|integer|min:0',
        ], [
            'nama_barang.required' => 'Nama komoditas barang wajib diisi.',
            'nama_barang.unique' => 'Nama barang ini sudah terdaftar di gudang.',
            'satuan.required' => 'Satuan barang wajib dipilih.',
            'jumlah.integer' => 'Jumlah stok awal harus berupa angka bulat.',
            'jumlah.min' => 'Jumlah stok awal tidak boleh bernilai negatif.',
        ]);

        $validated['jumlah'] = $validated['jumlah'] ?? 0;

        StokBantuan::create($validated);

        return redirect()->route('penamas.stok.index')->with('success', 'Komoditas pangan baru berhasil dicatat di gudang!');
    }

    /**
     * PBI-012: Menghapus item barang komoditas yang salah diinput.
     */
    public function destroy($id)
    {
        $barang = StokBantuan::findOrFail($id);

        // 1. Cek proteksi relasi: apakah barang memiliki riwayat mutasi stok keluar/masuk?
        if ($barang->mutasi()->exists()) {
            return redirect()->route('penamas.stok.index')->with('error', "Komoditas '{$barang->nama_barang}' tidak dapat dihapus karena sudah memiliki riwayat mutasi fisik di gudang!");
        }

        // 2. Cek proteksi relasi: apakah barang terdaftar sebagai komponen paket bantuan aktif?
        if (KomponenBantuan::where('nama_barang', $barang->nama_barang)->exists()) {
            return redirect()->route('penamas.stok.index')->with('error', "Komoditas '{$barang->nama_barang}' tidak dapat dihapus karena sudah terdaftar sebagai komponen paket bantuan!");
        }

        // 3. Jika aman dari relasi data lain, hapus komoditas
        $namaBarang = $barang->nama_barang;
        $barang->delete();

        return redirect()->route('penamas.stok.index')->with('success', "Komoditas '{$namaBarang}' berhasil dihapus dari persediaan gudang.");
    }
}
