<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use App\Models\Penyaluran;
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
        // Opsi tab status: 'disetujui' (default) atau 'disalurkan' (riwayat yang telah diserahkan)
        $tabStatus = $request->get('status', 'disetujui');

        $query = Distribusi::with(['paketBantuan', 'petugas'])
            ->withCount('penerima')
            ->where('status', $tabStatus);

        if ($currentPetugas) {
            $query->whereHas('petugas', function ($q) use ($currentPetugas) {
                $q->where('users.id', $currentPetugas->id);
            });
        }

        $daftarTugas = $query->latest('updated_at')->paginate(10)->withQueryString();

        return view('penyaluran.index', compact('daftarTugas', 'daftarPetugas', 'currentPetugas', 'tabStatus'));
    }

    /**
     * [PBI-025] AC 2: Melihat rincian tugas dan daftar nama warga (KPM)
     * yang wajib menerima bantuan pada rencana distribusi tersebut.
     */
    public function show($id)
    {
        $distribusi = Distribusi::with(['paketBantuan', 'petugas', 'pembuat', 'penyetuju', 'realisasi.user'])
            ->findOrFail($id);

        // [PBI-025] Kriteria 2: Ambil daftar nama warga (KPM) yang wajib menerima bantuan
        $daftarPenerima = $distribusi->penerima()->paginate(15);

        return view('penyaluran.show', compact('distribusi', 'daftarPenerima'));
    }

    /**
     * [PBI-026] Mencatat Realisasi Penyerahan Bantuan
     * AC 1: Petugas mengisi tanggal penyerahan, jumlah bantuan yang diserahkan, dan keterangan.
     * AC 2: Status rencana distribusi otomatis berubah menjadi 'disalurkan'.
     */
    public function storeRealisasi(Request $request, $id)
    {
        $distribusi = Distribusi::findOrFail($id);

        // [PBI-026] Validasi Kriteria 1: Tanggal penyerahan, jumlah bantuan, dan keterangan
        $validated = $request->validate([
            'tanggal_penyaluran' => 'required|date',
            'jumlah_disalurkan'  => 'required|integer|min:1',
            'keterangan'         => 'nullable|string|max:1000',
        ], [
            'tanggal_penyaluran.required' => 'Tanggal penyerahan wajib diisi.',
            'tanggal_penyaluran.date'     => 'Format tanggal penyerahan tidak valid.',
            'jumlah_disalurkan.required'  => 'Jumlah bantuan yang diserahkan wajib diisi.',
            'jumlah_disalurkan.integer'   => 'Jumlah bantuan harus berupa angka bulat.',
            'jumlah_disalurkan.min'       => 'Jumlah bantuan yang diserahkan minimal 1 paket.',
        ]);

        // Dapatkan ID petugas yang mencatat
        $userId = auth()->id() ?? optional(User::where('role', 'petugas')->first())->id;

        // [PBI-026] Kriteria 1: Simpan rekaman realisasi penyerahan resmi
        Penyaluran::create([
            'distribusi_id'      => $distribusi->id,
            'tanggal_penyaluran' => $validated['tanggal_penyaluran'],
            'jumlah_disalurkan'  => $validated['jumlah_disalurkan'],
            'keterangan'         => $validated['keterangan'] ?? null,
            'user_id'            => $userId,
        ]);

        // [PBI-026] Kriteria 2: Status rencana distribusi otomatis berubah menjadi 'disalurkan'
        $distribusi->update([
            'status' => 'disalurkan',
        ]);

        return redirect()->route('penyaluran.show', $distribusi->id)
            ->with('success', 'Realisasi penyerahan bantuan berhasil dicatat! Status rencana distribusi kini resmi berubah menjadi Disalurkan.');
    }
}
