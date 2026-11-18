<?php

namespace App\Http\Controllers;

use App\Models\StokBantuan;
use Illuminate\Http\Request;

class StokBantuanController extends Controller
{
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

        return redirect()->route('stok.create')->with('success', 'Komoditas pangan baru berhasil dicatat di gudang!');
    }
}
