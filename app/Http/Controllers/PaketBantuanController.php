<?php

namespace App\Http\Controllers;

use App\Models\PaketBantuan;
use App\Models\KomponenBantuan;
use App\Models\StokBantuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PaketBantuanController extends Controller
{
    /**
     * Menampilkan daftar paket bantuan (F-03).
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $query = PaketBantuan::with(['komponen'])
            ->withCount(['komponen', 'distribusi']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('komponen', function ($kq) use ($search) {
                      $kq->where('nama_barang', 'like', "%{$search}%");
                  });
            });
        }

        $paketList = $query->latest()->paginate(10)->withQueryString();

        $totalPaket = PaketBantuan::count();
        $totalKomponenItem = KomponenBantuan::count();

        return view('paket-bantuan.index', compact('paketList', 'search', 'totalPaket', 'totalKomponenItem'));
    }

    /**
     * Menampilkan formulir tambah paket bantuan baru (PBI-007).
     */
    public function create(): View
    {
        // Ambil saran nama barang komoditas dan satuan dari master stok gudang
        $komoditasList = StokBantuan::select('nama_barang', 'satuan')
            ->orderBy('nama_barang')
            ->get();

        return view('paket-bantuan.create', compact('komoditasList'));
    }

    /**
     * Menyimpan data paket bantuan dan komponen rincian barangnya (PBI-007).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'komponen' => 'required|array|min:1',
            'komponen.*.nama_barang' => 'required|string|max:255',
            'komponen.*.satuan' => 'required|string|max:50',
            'komponen.*.jumlah' => 'required|numeric|min:0.01',
        ], [
            'nama.required' => 'Nama paket bantuan wajib diisi.',
            'komponen.required' => 'Minimal harus menambahkan satu komponen barang bantuan.',
            'komponen.min' => 'Minimal harus menambahkan satu komponen barang bantuan.',
            'komponen.*.nama_barang.required' => 'Nama barang pada setiap baris wajib diisi.',
            'komponen.*.satuan.required' => 'Satuan barang wajib diisi.',
            'komponen.*.jumlah.required' => 'Jumlah barang wajib diisi.',
            'komponen.*.jumlah.min' => 'Jumlah barang minimal 0.01.',
        ]);

        DB::transaction(function () use ($validated) {
            $paket = PaketBantuan::create([
                'nama' => $validated['nama'],
                'deskripsi' => $validated['deskripsi'] ?? null,
            ]);

            foreach ($validated['komponen'] as $item) {
                $paket->komponen()->create([
                    'nama_barang' => trim($item['nama_barang']),
                    'satuan' => trim($item['satuan']),
                    'jumlah' => $item['jumlah'],
                ]);
            }
        });

        return redirect()->route('penamas.paket-bantuan.index')
            ->with('success', "Paket bantuan '{$validated['nama']}' berhasil dibuat beserta komponen barangnya.");
    }

    /**
     * Menampilkan formulir edit rincian paket bantuan (PBI-008).
     */
    public function edit(PaketBantuan $paketBantuan): View
    {
        $paketBantuan->load('komponen');

        $komoditasList = StokBantuan::select('nama_barang', 'satuan')
            ->orderBy('nama_barang')
            ->get();

        return view('paket-bantuan.edit', [
            'paket' => $paketBantuan,
            'komoditasList' => $komoditasList,
        ]);
    }

    /**
     * Memperbarui data paket dan daftar komponennya (PBI-008).
     */
    public function update(Request $request, PaketBantuan $paketBantuan): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'komponen' => 'required|array|min:1',
            'komponen.*.nama_barang' => 'required|string|max:255',
            'komponen.*.satuan' => 'required|string|max:50',
            'komponen.*.jumlah' => 'required|numeric|min:0.01',
        ], [
            'nama.required' => 'Nama paket bantuan wajib diisi.',
            'komponen.required' => 'Minimal harus menambahkan satu komponen barang bantuan.',
            'komponen.min' => 'Minimal harus menambahkan satu komponen barang bantuan.',
            'komponen.*.nama_barang.required' => 'Nama barang pada setiap baris wajib diisi.',
            'komponen.*.satuan.required' => 'Satuan barang wajib diisi.',
            'komponen.*.jumlah.required' => 'Jumlah barang wajib diisi.',
            'komponen.*.jumlah.min' => 'Jumlah barang minimal 0.01.',
        ]);

        DB::transaction(function () use ($validated, $paketBantuan) {
            $paketBantuan->update([
                'nama' => $validated['nama'],
                'deskripsi' => $validated['deskripsi'] ?? null,
            ]);

            // Hapus komponen lama dan simpan rincian komponen yang diperbarui
            $paketBantuan->komponen()->delete();

            foreach ($validated['komponen'] as $item) {
                $paketBantuan->komponen()->create([
                    'nama_barang' => trim($item['nama_barang']),
                    'satuan' => trim($item['satuan']),
                    'jumlah' => $item['jumlah'],
                ]);
            }
        });

        return redirect()->route('penamas.paket-bantuan.index')
            ->with('success', "Rincian barang paket bantuan '{$paketBantuan->nama}' berhasil diperbarui.");
    }

    /**
     * Menghapus paket bantuan dengan validasi aturan integritas data (PBI-009).
     */
    public function destroy(PaketBantuan $paketBantuan): RedirectResponse
    {
        // PBI-009 Aturan Integritas: Cegah penghapusan jika paket sudah pernah dipakai di jadwal distribusi
        if ($paketBantuan->distribusi()->exists()) {
            return redirect()->route('penamas.paket-bantuan.index')
                ->with('error', "Paket bantuan '{$paketBantuan->nama}' tidak dapat dihapus karena sudah terpakai pada riwayat rencana distribusi warga!");
        }

        $nama = $paketBantuan->nama;
        $paketBantuan->delete();

        return redirect()->route('penamas.paket-bantuan.index')
            ->with('success', "Paket bantuan '{$nama}' berhasil dihapus dari sistem.");
    }
}
