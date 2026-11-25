<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use Illuminate\Http\Request;

class PenerimaController extends Controller
{
    /**
     * Daftar 27 Kecamatan Resmi di Wilayah Kabupaten Banyumas
     */
    private $kecamatanBanyumas = [
        'Ajibarang', 'Banyumas', 'Baturraden', 'Cilongok', 'Gumelar',
        'Jatilawang', 'Kalibagor', 'Karanglewas', 'Kebasen', 'Kedungbanteng',
        'Kembaran', 'Kemranjen', 'Lumbir', 'Patikraja', 'Pekuncen',
        'Purwojati', 'Purwokerto Barat', 'Purwokerto Selatan', 'Purwokerto Timur',
        'Purwokerto Utara', 'Rawalo', 'Sokaraja', 'Somagede', 'Sumbang',
        'Sumpiuh', 'Tambak', 'Wangon'
    ];

    // =========================================================================
    // [PBI-006] FITUR PENCARIAN & FILTER DATA PENERIMA
    // Kriteria:
    // 1. Kotak pencarian menampilkan hasil sesuai kata kunci NIK atau nama.
    // 2. Pilihan filter kecamatan hanya menampilkan warga di wilayah tersebut.
    // =========================================================================

    /**
     * [PBI-006] Halaman Tabel Daftar Penerima dengan Fitur Cari & Filter Kecamatan
     */
    public function index(Request $request)
    {
        $query = Penerima::query();

        // [PBI-006] Kriteria 1: Pencarian berdasarkan kata kunci NIK atau Nama
        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function($q) use ($keyword) {
                $q->where('nik', 'like', "%{$keyword}%")
                  ->orWhere('nama', 'like', "%{$keyword}%");
            });
        }

        // [PBI-006] Kriteria 2: Filter dropdown hanya menampilkan warga di kecamatan tersebut
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Fitur pendukung: Filter berdasarkan status (Aktif / Nonaktif)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ambil data dengan pagination dan pertahankan parameter query URL
        $penerima = $query->latest()->paginate(10)->withQueryString();

        // Sediakan daftar 27 kecamatan Kabupaten Banyumas untuk dropdown filter
        $daftarKecamatan = $this->kecamatanBanyumas;

        return view('penerima.index', compact('penerima', 'daftarKecamatan'));
    }

    // =========================================================================
    // [PBI-004] FITUR PENDAFTARAN PENERIMA BANTUAN BARU
    // Kriteria: Admin mengisi NIK 16 digit, nama, alamat, kelurahan, kecamatan.
    // Sistem menolak jika format NIK salah atau NIK sudah pernah terdaftar.
    // =========================================================================

    /**
     * [PBI-004] Menampilkan Form Pendaftaran Penerima Baru
     */
    public function create()
    {
        $daftarKecamatan = $this->kecamatanBanyumas;
        return view('penerima.create', compact('daftarKecamatan'));
    }

    /**
     * [PBI-004] Memproses Penyimpanan Data & Validasi NIK 16 Digit Unik
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => [
                'required',
                'numeric',
                'digits:16',            // AC 2: Validasi NIK wajib tepat 16 digit
                'unique:penerima,nik',  // AC 2: Validasi NIK belum pernah terdaftar
            ],
            'nama'      => 'required|string|max:255',
            'alamat'    => 'required|string',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'no_hp'     => 'nullable|string|max:20',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric'  => 'NIK harus berupa angka.',
            'nik.digits'   => 'Format NIK salah! NIK harus tepat 16 digit angka.',
            'nik.unique'   => 'Pendaftaran ditolak! NIK ini sudah pernah terdaftar sebagai penerima.',
            'nama.required' => 'Nama penerima wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kelurahan.required' => 'Kelurahan/Desa wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
        ]);

        $validated['kabupaten'] = $validated['kabupaten'] ?? 'Banyumas';
        $validated['status']    = 'aktif'; // Default pendaftaran awal adalah aktif

        Penerima::create($validated);

        return redirect()->route('penerima.index')->with('success', 'Data Keluarga Penerima Manfaat (KPM) baru berhasil didaftarkan!');
    }

    /**
     * [PBI-004] Halaman Formulir Import Data Penerima via Berkas Excel / CSV
     */
    public function importForm()
    {
        return view('penerima.import');
    }

    /**
     * [PBI-004] Mengunduh Berkas Template CSV Resmi Penerima Bantuan
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_data_penerima_penamas.csv"',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            
            // Header kolom
            fputcsv($handle, ['nik', 'nama', 'alamat', 'kelurahan', 'kecamatan', 'no_hp']);
            
            // Contoh baris pengisian
            fputcsv($handle, ['3302012304950001', 'Emanuel Slamet', 'RT 02 / RW 03, Jl. Gerilya No. 12', 'Purwokerto Kidul', 'Purwokerto Selatan', '081234567890']);
            fputcsv($handle, ['3302012304950002', 'Siti Rahmawati', 'RT 01 / RW 05, Desa Tambaksari', 'Tambaksari Kidul', 'Kembaran', '085712345678']);
            
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * [PBI-004] Memproses Impor Data Penerima dari Berkas Excel (.xlsx, .xls) atau CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt|max:5120',
        ], [
            'file.required' => 'Silakan pilih berkas yang ingin diunggah.',
            'file.mimes'    => 'Format berkas harus berupa .xlsx, .xls, atau .csv.',
            'file.max'      => 'Ukuran berkas maksimal 5 MB.',
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $path = $file->getRealPath();

        $rows = [];
        if ($extension === 'xlsx') {
            $rows = $this->parseXlsxFile($path);
        } else {
            $rows = $this->parseCsvFile($path);
        }

        if (empty($rows)) {
            return redirect()->back()->withErrors(['file' => 'Berkas kosong atau tidak dapat dibaca. Pastikan format berkas valid.']);
        }

        // Ambil header baris pertama
        $header = array_map(fn($h) => strtolower(trim((string)$h)), array_shift($rows));
        
        $nikIdx       = array_search('nik', $header);
        $namaIdx      = array_search('nama', $header);
        $alamatIdx    = array_search('alamat', $header);
        $kelurahanIdx = array_search('kelurahan', $header);
        $kecamatanIdx = array_search('kecamatan', $header);
        $noHpIdx      = array_search('no_hp', $header);

        // Fallback default index jika nama header tidak persis sama
        if ($nikIdx === false || $namaIdx === false) {
            $nikIdx = 0; $namaIdx = 1; $alamatIdx = 2; $kelurahanIdx = 3; $kecamatanIdx = 4; $noHpIdx = 5;
        }

        $sukses = 0;
        $dilewati = 0;
        $existingNiks = Penerima::pluck('nik')->flip()->toArray();
        $batchInsertedNiks = [];

        foreach ($rows as $row) {
            $nik = isset($row[$nikIdx]) ? preg_replace('/[^0-9]/', '', (string)$row[$nikIdx]) : '';
            $nama = isset($row[$namaIdx]) ? trim((string)$row[$namaIdx]) : '';
            $alamat = isset($row[$alamatIdx]) ? trim((string)$row[$alamatIdx]) : '';
            $kelurahan = isset($row[$kelurahanIdx]) ? trim((string)$row[$kelurahanIdx]) : '';
            $kecamatan = isset($row[$kecamatanIdx]) ? trim((string)$row[$kecamatanIdx]) : '';
            $noHp = isset($row[$noHpIdx]) ? trim((string)$row[$noHpIdx]) : null;

            // Validasi: NIK harus 16 digit angka dan nama terisi
            if (strlen($nik) !== 16 || empty($nama)) {
                $dilewati++;
                continue;
            }

            // Validasi duplikasi NIK
            if (isset($existingNiks[$nik]) || isset($batchInsertedNiks[$nik])) {
                $dilewati++;
                continue;
            }

            // Cocokkan kecamatan dengan daftar resmi Banyumas
            $kecamatanCocok = 'Purwokerto Selatan';
            foreach ($this->kecamatanBanyumas as $kecBanyumas) {
                if (stripos($kecamatan, $kecBanyumas) !== false) {
                    $kecamatanCocok = $kecBanyumas;
                    break;
                }
            }

            Penerima::create([
                'nik'       => $nik,
                'nama'      => $nama,
                'alamat'    => $alamat ?: 'Kabupaten Banyumas',
                'kelurahan' => $kelurahan ?: 'Kelurahan Setempat',
                'kecamatan' => $kecamatanCocok,
                'kabupaten' => 'Banyumas',
                'no_hp'     => $noHp,
                'status'    => 'aktif',
            ]);

            $batchInsertedNiks[$nik] = true;
            $sukses++;
        }

        $pesan = "Proses import selesai! {$sukses} data penerima berhasil ditambahkan.";
        if ($dilewati > 0) {
            $pesan .= " ({$dilewati} data dilewati karena NIK tidak 16 digit atau sudah terdaftar).";
        }

        return redirect()->route('penamas.penerima.index')->with('success', $pesan);
    }

    /**
     * Helper pembaca berkas CSV
     */
    private function parseCsvFile($filePath)
    {
        $rows = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            $firstLine = fgets($handle);
            rewind($handle);
            $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

            while (($data = fgetcsv($handle, 4000, $delimiter)) !== false) {
                if (isset($data[0])) {
                    $data[0] = preg_replace('/^\xEF\xBB\xBF/', '', $data[0]);
                }
                if (!empty(array_filter($data, fn($v) => trim((string)$v) !== ''))) {
                    $rows[] = array_map('trim', $data);
                }
            }
            fclose($handle);
        }
        return $rows;
    }

    /**
     * Helper pembaca berkas XLSX (Excel)
     */
    private function parseXlsxFile($filePath)
    {
        $zip = new \ZipArchive();
        if ($zip->open($filePath) !== true) {
            return [];
        }

        $sharedStrings = [];
        if (($idx = $zip->locateName('xl/sharedStrings.xml')) !== false) {
            $xml = simplexml_load_string($zip->getFromIndex($idx));
            if ($xml) {
                foreach ($xml->si as $si) {
                    if (isset($si->t)) {
                        $sharedStrings[] = (string)$si->t;
                    } elseif (isset($si->r)) {
                        $str = '';
                        foreach ($si->r as $r) {
                            $str .= (string)$r->t;
                        }
                        $sharedStrings[] = $str;
                    } else {
                        $sharedStrings[] = '';
                    }
                }
            }
        }

        $rows = [];
        if (($idx = $zip->locateName('xl/worksheets/sheet1.xml')) !== false) {
            $xml = simplexml_load_string($zip->getFromIndex($idx));
            if ($xml && isset($xml->sheetData->row)) {
                foreach ($xml->sheetData->row as $row) {
                    $rowData = [];
                    foreach ($row->c as $cell) {
                        $type = (string)$cell['t'];
                        $val = (string)$cell->v;
                        if ($type === 's' && isset($sharedStrings[(int)$val])) {
                            $val = $sharedStrings[(int)$val];
                        } elseif ($type === 'inlineStr' && isset($cell->is->t)) {
                            $val = (string)$cell->is->t;
                        }
                        $rowData[] = trim($val);
                    }
                    if (!empty(array_filter($rowData, fn($v) => trim((string)$v) !== ''))) {
                        $rows[] = $rowData;
                    }
                }
            }
        }
        $zip->close();
        return $rows;
    }

    // =========================================================================
    // [PBI-005] FITUR MENGUBAH DATA ALAMAT ATAU STATUS PENERIMA
    // Kriteria:
    // 1. Admin dapat mengedit data warga atau mengubah statusnya (aktif/nonaktif).
    // 2. Penerima nonaktif tidak muncul saat pembuatan rencana bantuan.
    // =========================================================================

    /**
     * [PBI-005] Menampilkan Form Edit untuk Mengubah Alamat & Status Penerima
     */
    public function edit($id)
    {
        $penerima = Penerima::findOrFail($id);
        $daftarKecamatan = $this->kecamatanBanyumas;
        return view('penerima.edit', compact('penerima', 'daftarKecamatan'));
    }

    /**
     * [PBI-005] Memproses Pembaruan Data Alamat & Perubahan Status (Aktif/Nonaktif)
     */
    public function update(Request $request, $id)
    {
        $penerima = Penerima::findOrFail($id);

        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'alamat'    => 'required|string',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'no_hp'     => 'nullable|string|max:20',
            'status'    => 'required|in:aktif,nonaktif', // Kriteria Utama PBI-005: Aktif / Nonaktif
        ], [
            'status.required' => 'Status penerima wajib ditentukan.',
            'status.in'       => 'Pilihan status hanya boleh "aktif" atau "nonaktif".',
            'nama.required'   => 'Nama penerima wajib diisi.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'kelurahan.required' => 'Kelurahan/Desa wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
        ]);

        $penerima->update($validated);

        return redirect()->route('penerima.index')->with('success', 'Data alamat dan status penerima berhasil diperbarui!');
    }
}
