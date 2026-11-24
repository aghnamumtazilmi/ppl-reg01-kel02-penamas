<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use App\Models\PaketBantuan;
use App\Models\Penerima;
use App\Models\StokBantuan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan Halaman Ringkasan Dashboard Utama (F-05)
     * Mengakomodasi:
     * - PBI-013: Kotak Ringkasan Angka (Total Penerima, Paket Bantuan, Stok Gudang)
     * - PBI-014: Jumlah Rencana Bantuan Menunggu Persetujuan Pimpinan & Tombol Tinjau Cepat
     * - PBI-015: Tabel 5 Jadwal Aktivitas Distribusi & Penyaluran Terbaru Beserta Status
     */
    public function index(Request $request): View
    {
        // ─── PBI-013: Kotak Ringkasan Angka Utama ───────────────────────────
        $totalPenerima = Penerima::count();
        $penerimaAktif = Penerima::where('status', 'aktif')->count();
        $totalPaket = PaketBantuan::count();
        $totalStok = (int) StokBantuan::sum('jumlah');
        $totalKomoditas = StokBantuan::count();

        // Indikator Stok Menipis (<= 10 unit/kg/liter)
        $stokMenipis = StokBantuan::where('jumlah', '<=', 10)->get();

        // ─── PBI-014: Rencana Menunggu Persetujuan Pimpinan (Status: Diajukan) ───
        $pengajuanMenungguCount = Distribusi::where('status', 'diajukan')->count();
        $pengajuanMenunggu = Distribusi::with(['paketBantuan', 'pembuat'])
            ->where('status', 'diajukan')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->take(5)
            ->get();

        // ─── PBI-015: 5 Aktivitas Distribusi & Penyaluran Terbaru ──────────
        $aktivitasTerbaru = Distribusi::with(['paketBantuan', 'realisasi', 'pembuat'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        // Tambahan metrik capaian penyaluran
        $distribusiDisalurkanCount = Distribusi::where('status', 'disalurkan')->count();
        $distribusiDisetujuiCount = Distribusi::where('status', 'disetujui')->count();

        return view('dashboard', compact(
            'totalPenerima',
            'penerimaAktif',
            'totalPaket',
            'totalStok',
            'totalKomoditas',
            'stokMenipis',
            'pengajuanMenungguCount',
            'pengajuanMenunggu',
            'aktivitasTerbaru',
            'distribusiDisalurkanCount',
            'distribusiDisetujuiCount'
        ));
    }
}
