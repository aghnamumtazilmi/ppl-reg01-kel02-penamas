<?php

namespace App\Http\Controllers;

use App\Models\StokBantuan;
use App\Models\StokMutasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokMutasiController extends Controller
{
    // =========================================================================
    // [PBI-016] FITUR MUTASI MASUK STOK GUDANG (Pengadaan / Donatur)
    // Aktor: Admin (Operator Bansos)
    // Kriteria:
    // 1. Admin memilih nama barang, mengisi jumlah masuk, dan keterangan sumber barang.
    // 2. Angka stok di gudang otomatis bertambah sesuai jumlah yang dimasukkan.
    // =========================================================================

    /**
     * [PBI-016 & F-06] Menampilkan halaman riwayat mutasi stok, filter, dan KPI statistik
     */
    public function index(Request $request)
    {
        $query = StokMutasi::with(['stokBantuan', 'user'])->latest();

        // Filter berdasarkan kata kunci (pencarian di nama barang atau keterangan)
        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('keterangan', 'like', "%{$keyword}%")
                  ->orWhereHas('stokBantuan', function ($sub) use ($keyword) {
                      $sub->where('nama_barang', 'like', "%{$keyword}%");
                  });
            });
        }

        // Filter berdasarkan tipe mutasi (masuk / keluar)
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        // Filter rentang tanggal mutasi (PBI-018: Audit Riwayat Mutasi)
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        // Filter spesifik ID barang
        if ($request->filled('stok_bantuan_id')) {
            $query->where('stok_bantuan_id', $request->stok_bantuan_id);
        }

        // Data transaksi terpaginasi
        $mutasi = $query->paginate(15)->withQueryString();

        // Data master komoditas untuk dropdown filter
        $daftarBarang = StokBantuan::orderBy('nama_barang')->get();

        // Ringkasan KPI Statistik Mutasi Gudang
        $stats = [
            'total_transaksi_masuk'  => StokMutasi::where('tipe', 'masuk')->count(),
            'total_volume_masuk'     => StokMutasi::where('tipe', 'masuk')->sum('jumlah'),
            'total_transaksi_keluar' => StokMutasi::where('tipe', 'keluar')->count(),
            'total_komoditas'        => StokBantuan::count(),
        ];

        return view('stok-mutasi.index', compact('mutasi', 'daftarBarang', 'stats'));
    }

    /**
     * [PBI-016] Menampilkan form pencatatan mutasi masuk barang dari pengadaan / donatur
     */
    public function create()
    {
        $daftarBarang = StokBantuan::orderBy('nama_barang')->get();
        return view('stok-mutasi.create', compact('daftarBarang'));
    }

    /**
     * [PBI-016] Memproses penyimpanan mutasi masuk & otomatis menaikkan saldo stok gudang
     * Kriteria 1: Validasi nama barang, jumlah masuk, dan keterangan sumber barang.
     * Kriteria 2: Saldo stok_bantuan.jumlah otomatis bertambah (increment) secara konsisten (DB Transaction).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'stok_bantuan_id' => [
                'required',
                'exists:stok_bantuan,id',
            ],
            'jumlah' => [
                'required',
                'integer',
                'min:1',
            ],
            'keterangan' => [
                'required',
                'string',
                'min:5',
                'max:500',
            ],
        ], [
            'stok_bantuan_id.required' => 'Nama komoditas barang wajib dipilih.',
            'stok_bantuan_id.exists'   => 'Komoditas barang yang dipilih tidak terdaftar di sistem.',
            'jumlah.required'          => 'Jumlah volume barang masuk wajib diisi.',
            'jumlah.integer'           => 'Jumlah masuk harus berupa bilangan bulat positif.',
            'jumlah.min'               => 'Jumlah masuk minimal 1 unit/satuan.',
            'keterangan.required'      => 'Keterangan sumber barang (asal pengadaan/donasi) wajib diisi.',
            'keterangan.min'           => 'Keterangan sumber barang minimal 5 karakter agar informatif.',
            'keterangan.max'           => 'Keterangan sumber barang tidak boleh melebihi 500 karakter.',
        ]);

        // Tentukan ID user pencatat secara aman (Akun login, atau fallback akun Admin)
        $userId = $request->user()?->id;
        if (! $userId) {
            $adminUser = User::where('role', 'admin')->first()
                ?? User::first()
                ?? User::create([
                    'name'     => 'Helmi Arif (Operator Bansos)',
                    'email'    => 'operator.bansos@banyumaskab.go.id',
                    'password' => bcrypt('password123'),
                    'role'     => 'admin',
                ]);
            $userId = $adminUser->id;
        }

        $barang = null;

        // [Kriteria 2] Jalankan dalam Database Transaction agar saldo dan catatan mutasi selalu sinkron
        DB::transaction(function () use ($validated, $userId, &$barang) {
            $barang = StokBantuan::lockForUpdate()->findOrFail($validated['stok_bantuan_id']);

            // 1. Simpan riwayat mutasi masuk
            StokMutasi::create([
                'stok_bantuan_id' => $barang->id,
                'tipe'            => 'masuk',
                'jumlah'          => $validated['jumlah'],
                'keterangan'      => $validated['keterangan'],
                'user_id'         => $userId,
            ]);

            // 2. Tambah angka saldo fisik di gudang secara otomatis
            $barang->increment('jumlah', $validated['jumlah']);
            $barang->refresh();
        });

        $pesanSukses = "Mutasi masuk berhasil dicatat! Stok {$barang->nama_barang} bertambah +" . 
            number_format($validated['jumlah']) . " {$barang->satuan}. " .
            "(Total stok saat ini: " . number_format($barang->jumlah) . " {$barang->satuan}).";

        return redirect()->route('stok-mutasi.index')->with('success', $pesanSukses);
    }

    // =========================================================================
    // [PBI-017] FITUR MUTASI KELUAR MANUAL (Barang Rusak / Kadaluarsa / Susut)
    // Kriteria:
    // 1. Admin memilih barang, mengisi jumlah keluar, dan alasan pengeluaran.
    // 2. Sistem menolak jika jumlah keluar melebihi saldo stok saat ini.
    // 3. Saldo stok gudang otomatis berkurang sesuai jumlah yang dikeluarkan.
    // =========================================================================

    /**
     * [PBI-017] Menampilkan form pencatatan mutasi keluar manual
     */
    public function createKeluar()
    {
        $daftarBarang = StokBantuan::orderBy('nama_barang')->get();
        return view('stok-mutasi.create-keluar', compact('daftarBarang'));
    }

    /**
     * [PBI-017] Memproses mutasi keluar manual & validasi pencegahan stok minus
     * Acceptance Criteria:
     * 1. Admin memilih tipe keluar, mengisi jumlah barang, dan menulis alasan pengeluaran.
     * 2. Sistem mencegah pengeluaran jika jumlah melebihi stok yang tersedia.
     */
    public function storeKeluar(Request $request)
    {
        $validated = $request->validate([
            'stok_bantuan_id' => [
                'required',
                'exists:stok_bantuan,id',
            ],
            'tipe_keluar' => [
                'required',
                'string',
                'in:Barang Rusak,Kadaluarsa,Penyusutan / Selisih Fisik,Distribusi Darurat / Khusus,Lainnya',
            ],
            'jumlah' => [
                'required',
                'integer',
                'min:1',
            ],
            'keterangan' => [
                'required',
                'string',
                'min:5',
                'max:500',
            ],
        ], [
            'stok_bantuan_id.required' => 'Nama komoditas barang wajib dipilih.',
            'stok_bantuan_id.exists'   => 'Komoditas barang tidak ditemukan dalam sistem.',
            'tipe_keluar.required'     => 'Tipe pengeluaran barang wajib dipilih.',
            'tipe_keluar.in'           => 'Pilihan tipe pengeluaran barang tidak valid.',
            'jumlah.required'          => 'Jumlah volume barang keluar wajib diisi.',
            'jumlah.integer'           => 'Jumlah keluar harus berupa bilangan bulat positif.',
            'jumlah.min'               => 'Jumlah keluar minimal 1 unit/satuan.',
            'keterangan.required'      => 'Alasan atau keterangan pengeluaran wajib diisi.',
            'keterangan.min'           => 'Alasan pengeluaran minimal 5 karakter agar informatif.',
            'keterangan.max'           => 'Alasan pengeluaran tidak boleh melebihi 500 karakter.',
        ]);

        $stok = StokBantuan::findOrFail($validated['stok_bantuan_id']);

        // [Kriteria 2] Sistem mencegah pengeluaran jika jumlah melebihi stok yang tersedia
        if ($validated['jumlah'] > $stok->jumlah) {
            return back()
                ->withInput()
                ->withErrors([
                    'jumlah' => "Sistem menolak pengeluaran! Jumlah keluar ({$validated['jumlah']} {$stok->satuan}) melebihi stok yang tersedia di gudang ({$stok->jumlah} {$stok->satuan}).",
                ]);
        }

        $userId = $request->user()?->id 
            ?? User::where('role', 'admin')->first()?->id 
            ?? 1;

        $keteranganFormat = "[{$validated['tipe_keluar']}] " . trim($validated['keterangan']);

        // Eksekusi atomik dalam transaksi database dengan pesimis row locking
        DB::transaction(function () use ($validated, $userId, $keteranganFormat, &$stok) {
            $stokTerkunci = StokBantuan::lockForUpdate()->findOrFail($validated['stok_bantuan_id']);

            if ($validated['jumlah'] > $stokTerkunci->jumlah) {
                throw new \Exception("Stok tidak mencukupi untuk dikeluarkan.");
            }

            StokMutasi::create([
                'stok_bantuan_id' => $stokTerkunci->id,
                'tipe'            => 'keluar',
                'jumlah'          => $validated['jumlah'],
                'keterangan'      => $keteranganFormat,
                'user_id'         => $userId,
            ]);

            $stokTerkunci->decrement('jumlah', $validated['jumlah']);
            $stok = $stokTerkunci->fresh();
        });

        $pesanSukses = "Mutasi keluar berhasil dicatat! Stok {$stok->nama_barang} berkurang -{$validated['jumlah']} {$stok->satuan} " .
            "karena [{$validated['tipe_keluar']}]. (Sisa stok gudang saat ini: {$stok->jumlah} {$stok->satuan}).";

        return redirect()->route('stok-mutasi.index')->with('success', $pesanSukses);
    }
}
