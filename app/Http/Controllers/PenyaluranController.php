<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use App\Models\User;
use Illuminate\Http\Request;

class PenyaluranController extends Controller
{
    /**
     * [PBI-025] AC 1: Melihat daftar tugas pembagian bantuan berstatus 'disetujui'
     * yang menugaskan petugas terkait.
     */
    public function index(Request $request)
    {
        // Dapatkan data petugas lapangan
        $daftarPetugas = User::where('role', 'petugas')->get();
        
        // Prioritaskan auth()->id() jika login, atau simulasi ganti petugas untuk kemudahan demo/testing
        $petugasId = $request->get('petugas_id', auth()->id() ?? optional($daftarPetugas->first())->id);
        $currentPetugas = $daftarPetugas->firstWhere('id', $petugasId) ?? $daftarPetugas->first();

        // [PBI-025] Kriteria 1: Hanya melihat rencana distribusi berstatus 'disetujui' yang menugaskan dirinya
        $query = Distribusi::with(['paketBantuan', 'petugas'])
            ->withCount('penerima')
            ->where('status', 'disetujui');

        if ($currentPetugas) {
            $query->whereHas('petugas', function ($q) use ($currentPetugas) {
                $q->where('users.id', $currentPetugas->id);
            });
        }

        $daftarTugas = $query->latest('tanggal_persetujuan')->paginate(10)->withQueryString();

        return view('penyaluran.index', compact('daftarTugas', 'daftarPetugas', 'currentPetugas'));
    }

    /**
     * [PBI-025] AC 2: Melihat rincian tugas dan daftar nama warga (KPM)
     * yang wajib menerima bantuan pada rencana distribusi tersebut.
     */
    public function show($id)
    {
        $distribusi = Distribusi::with(['paketBantuan', 'petugas', 'pembuat', 'penyetuju'])
            ->findOrFail($id);

        // [PBI-025] Kriteria 2: Ambil daftar nama warga (KPM) yang wajib menerima bantuan
        $daftarPenerima = $distribusi->penerima()->paginate(15);

        return view('penyaluran.show', compact('distribusi', 'daftarPenerima'));
    }
}
