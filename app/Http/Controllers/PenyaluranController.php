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
     * [PBI-026 & PBI-027] Mencatat Realisasi Penyerahan Bantuan & Unggah Foto Bukti
     * PBI-026 AC 1: Petugas mengisi tanggal penyerahan, jumlah bantuan yang diserahkan, dan keterangan.
     * PBI-026 AC 2: Status rencana distribusi otomatis berubah menjadi 'disalurkan'.
     * PBI-027 AC 1 & 2: Petugas dapat mengunggah berkas gambar foto serah terima bantuan & tersimpan aman.
     */
    public function storeRealisasi(Request $request, $id)
    {
        $distribusi = Distribusi::findOrFail($id);

        // Validasi input realisasi dan foto berkas gambar
        $validated = $request->validate([
            'tanggal_penyaluran' => 'required|date',
            'jumlah_disalurkan'  => 'required|integer|min:1',
            'keterangan'         => 'nullable|string|max:1000',
            'foto_bukti'         => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // PBI-027: maks 5MB
        ], [
            'tanggal_penyaluran.required' => 'Tanggal penyerahan wajib diisi.',
            'tanggal_penyaluran.date'     => 'Format tanggal penyerahan tidak valid.',
            'jumlah_disalurkan.required'  => 'Jumlah bantuan yang diserahkan wajib diisi.',
            'jumlah_disalurkan.integer'   => 'Jumlah bantuan harus berupa angka bulat.',
            'jumlah_disalurkan.min'       => 'Jumlah bantuan yang diserahkan minimal 1 paket.',
            'foto_bukti.image'            => 'Berkas foto bukti harus berupa file gambar.',
            'foto_bukti.mimes'            => 'Format foto harus berupa JPG, JPEG, atau PNG.',
            'foto_bukti.max'              => 'Ukuran foto maksimal adalah 5MB.',
        ]);

        // [PBI-027] Proses penyimpanan berkas gambar foto bukti secara aman di folder public/uploads/penyaluran
        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $fileName = 'bukti_' . $distribusi->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/penyaluran');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $fileName);
            $fotoPath = 'uploads/penyaluran/' . $fileName;
        }

        // Dapatkan ID petugas yang mencatat
        $userId = auth()->id() ?? optional(User::where('role', 'petugas')->first())->id;

        // [PBI-026 & PBI-027] Simpan rekaman realisasi penyerahan beserta path foto bukti
        Penyaluran::create([
            'distribusi_id'      => $distribusi->id,
            'tanggal_penyaluran' => $validated['tanggal_penyaluran'],
            'jumlah_disalurkan'  => $validated['jumlah_disalurkan'],
            'keterangan'         => $validated['keterangan'] ?? null,
            'foto_bukti'         => $fotoPath,
            'user_id'            => $userId,
        ]);

        // [PBI-026] Kriteria 2: Status rencana distribusi otomatis berubah menjadi 'disalurkan'
        $distribusi->update([
            'status' => 'disalurkan',
        ]);

        return redirect()->route('penyaluran.show', $distribusi->id)
            ->with('success', 'Realisasi penyerahan bantuan dan foto dokumentasi berhasil dicatat! Status distribusi resmi berubah menjadi Disalurkan.');
    }

    /**
     * [PBI-027] Mengunggah atau memperbarui foto bukti dokumentasi serah terima
     * pada tugas yang sudah disalurkan.
     */
    public function uploadFoto(Request $request, $id)
    {
        $distribusi = Distribusi::with('realisasi')->findOrFail($id);

        $request->validate([
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'foto_bukti.required' => 'Silakan pilih berkas foto bukti serah terima terlebih dahulu.',
            'foto_bukti.image'    => 'Berkas yang diunggah harus berupa file gambar.',
            'foto_bukti.mimes'    => 'Format foto harus berupa JPG, JPEG, atau PNG.',
            'foto_bukti.max'      => 'Ukuran foto maksimal adalah 5MB.',
        ]);

        // Proses penyimpanan berkas foto
        $file = $request->file('foto_bukti');
        $fileName = 'bukti_' . $distribusi->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('uploads/penyaluran');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $file->move($destinationPath, $fileName);
        $fotoPath = 'uploads/penyaluran/' . $fileName;

        // Update ke record realisasi
        if ($distribusi->realisasi) {
            $distribusi->realisasi->update(['foto_bukti' => $fotoPath]);
        } else {
            Penyaluran::create([
                'distribusi_id'      => $distribusi->id,
                'tanggal_penyaluran' => now()->toDateString(),
                'jumlah_disalurkan'  => $distribusi->penerima->count() ?: 1,
                'foto_bukti'         => $fotoPath,
                'user_id'            => auth()->id() ?? optional(User::where('role', 'petugas')->first())->id,
            ]);
            $distribusi->update(['status' => 'disalurkan']);
        }

        return redirect()->route('penyaluran.show', $distribusi->id)
            ->with('success', 'Foto dokumentasi bukti serah terima berhasil diunggah dan tersimpan aman!');
    }

    /**
     * [PBI-027] Menghapus berkas foto dokumentasi serah terima
     */
    public function deleteFoto($id)
    {
        $distribusi = Distribusi::with('realisasi')->findOrFail($id);

        if ($distribusi->realisasi && $distribusi->realisasi->foto_bukti) {
            $filePath = public_path($distribusi->realisasi->foto_bukti);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            $distribusi->realisasi->update(['foto_bukti' => null]);
        }

        return redirect()->route('penyaluran.show', $distribusi->id)
            ->with('success', 'Foto dokumentasi serah terima berhasil dihapus.');
    }
}
