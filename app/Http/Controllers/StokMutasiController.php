<?php

namespace App\Http\Controllers;

use App\Models\StokBantuan;
use App\Models\StokMutasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokMutasiController extends Controller
{
    // =========================================================================
    // [PBI-016] FITUR MUTASI MASUK STOK GUDANG (Pengadaan / Donatur)
    // Kriteria:
    // 1. Admin memilih nama barang, mengisi jumlah masuk, dan keterangan sumber.
    // 2. Angka stok di gudang otomatis bertambah sesuai jumlah yang dimasukkan.
    // =========================================================================

    /**
     * [PBI-016] Menampilkan halaman riwayat mutasi stok & form aksi cepat
     */
    public function index(Request $request)
    {
        $query = StokMutasi::with(['stokBantuan', 'user'])->latest();

        // Filter berdasarkan tipe mutasi (masuk / keluar)
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        // Filter berdasarkan nama barang
        if ($request->filled('barang')) {
            $query->whereHas('stokBantuan', function ($q) use ($request) {
                $q->where('nama_barang', 'like', "%{$request->barang}%");
            });
        }

        $mutasi = $query->paginate(15)->withQueryString();
        $daftarBarang = StokBantuan::orderBy('nama_barang')->get();

        return view('stok-mutasi.index', compact('mutasi', 'daftarBarang'));
    }

    /**
     * [PBI-016] Menampilkan form pencatatan mutasi masuk barang baru
     */
    public function create()
    {
        $daftarBarang = StokBantuan::orderBy('nama_barang')->get();
        return view('stok-mutasi.create', compact('daftarBarang'));
    }

    /**
     * [PBI-016] Memproses penyimpanan mutasi masuk & otomatis tambah saldo stok
     * Kriteria 1: Validasi nama barang, jumlah masuk, dan keterangan sumber.
     * Kriteria 2: Saldo stok_bantuan.jumlah otomatis bertambah sesuai jumlah masuk.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'stok_bantuan_id' => 'required|exists:stok_bantuan,id',
            'jumlah'          => 'required|integer|min:1',
            'keterangan'      => 'required|string|max:500',
        ], [
            'stok_bantuan_id.required' => 'Nama barang wajib dipilih.',
            'stok_bantuan_id.exists'   => 'Barang yang dipilih tidak ditemukan.',
            'jumlah.required'          => 'Jumlah barang masuk wajib diisi.',
            'jumlah.integer'           => 'Jumlah harus berupa bilangan bulat.',
            'jumlah.min'               => 'Jumlah masuk minimal 1.',
            'keterangan.required'      => 'Keterangan sumber barang wajib diisi.',
        ]);

        // [Kriteria 2] Gunakan DB Transaction agar data konsisten
        DB::transaction(function () use ($validated, $request) {
            // Catat mutasi masuk ke tabel stok_mutasi
            StokMutasi::create([
                'stok_bantuan_id' => $validated['stok_bantuan_id'],
                'tipe'            => 'masuk',
                'jumlah'          => $validated['jumlah'],
                'keterangan'      => $validated['keterangan'],
                'user_id'         => $request->user()?->id ?? 1, // sementara pakai ID 1 sebelum auth
            ]);

            // [Kriteria 2] Stok gudang otomatis bertambah sesuai jumlah yang dimasukkan
            StokBantuan::where('id', $validated['stok_bantuan_id'])
                ->increment('jumlah', $validated['jumlah']);
        });

        return redirect()->route('stok-mutasi.index')
            ->with('success', 'Mutasi masuk berhasil dicatat! Saldo stok gudang telah diperbarui.');
    }
}
