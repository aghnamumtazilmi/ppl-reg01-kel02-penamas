<?php

namespace Tests\Feature;

use App\Models\Distribusi;
use App\Models\PaketBantuan;
use App\Models\Penerima;
use App\Models\StokBantuan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test halaman dashboard dapat diakses dengan sukses (HTTP 200).
     */
    public function test_dashboard_page_can_be_rendered(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Halaman Ringkasan (Dashboard)');
        $response->assertSee('Edwin Salman Hakim');
    }

    /**
     * Test PBI-013: Kotak ringkasan angka menampilkan total penerima, paket, dan stok barang secara akurat.
     */
    public function test_pbi_013_dashboard_displays_accurate_summary_metrics(): void
    {
        // 1. Setup sample penerima
        Penerima::create([
            'nik' => '3302010101010001',
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Pahlawan No. 1',
            'kelurahan' => 'Kranji',
            'kecamatan' => 'Purwokerto Timur',
            'status' => 'aktif',
        ]);
        Penerima::create([
            'nik' => '3302010101010002',
            'nama' => 'Siti Nurhaliza',
            'alamat' => 'Jl. Merdeka No. 2',
            'kelurahan' => 'Sokanegara',
            'kecamatan' => 'Purwokerto Timur',
            'status' => 'nonaktif',
        ]);

        // 2. Setup sample paket bantuan
        PaketBantuan::create([
            'nama' => 'Paket Sembako Ramadhan',
            'deskripsi' => 'Beras, minyak, gula',
        ]);

        // 3. Setup sample stok bantuan gudang
        StokBantuan::create([
            'nama_barang' => 'Beras Pandan Wangi',
            'satuan' => 'kg',
            'jumlah' => 250,
        ]);
        StokBantuan::create([
            'nama_barang' => 'Minyak Goreng Sawit',
            'satuan' => 'liter',
            'jumlah' => 50,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        // Assert data tertera di halaman
        $response->assertSee('2'); // Total 2 penerima
        $response->assertSee('1 Aktif'); // 1 penerima aktif
        $response->assertSee('1'); // 1 varian paket
        $response->assertSee('300'); // Total 300 stok (250 + 50)
    }

    /**
     * Test PBI-014: Menampilkan jumlah rencana distribusi yang berstatus Diajukan dan tombol aksi cepat.
     */
    public function test_pbi_014_dashboard_displays_pending_review_plans_for_pimpinan(): void
    {
        $admin = User::create([
            'name' => 'Admin Bansos',
            'email' => 'admin@penamas.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $paket = PaketBantuan::create([
            'nama' => 'Paket Beras Sejahtera',
            'deskripsi' => 'Beras 10 kg',
        ]);

        Distribusi::create([
            'kode' => 'DIST-20261124-0001',
            'periode' => 'November 2026',
            'wilayah' => 'Purwokerto Selatan',
            'paket_bantuan_id' => $paket->id,
            'jumlah_penerima' => 25,
            'status' => 'diajukan',
            'tanggal_pengajuan' => now(),
            'dibuat_oleh' => $admin->id,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        // Memastikan tertera pada kotak ringkasan & tabel review
        $response->assertSee('DIST-20261124-0001');
        $response->assertSee('Purwokerto Selatan');
        $response->assertSee('Tinjau Rencana');
    }

    /**
     * Test PBI-015: Menampilkan 5 aktivitas distribusi dan penyaluran terbaru dengan badge status.
     */
    public function test_pbi_015_dashboard_displays_latest_activities_with_status(): void
    {
        $admin = User::create([
            'name' => 'Admin Bansos',
            'email' => 'admin2@penamas.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $paket = PaketBantuan::create([
            'nama' => 'Paket Bantuan Reguler',
            'deskripsi' => 'Beras & Minyak',
        ]);

        Distribusi::create([
            'kode' => 'DIST-20261124-0002',
            'periode' => 'November 2026',
            'wilayah' => 'Banyumas',
            'paket_bantuan_id' => $paket->id,
            'jumlah_penerima' => 50,
            'status' => 'disalurkan',
            'dibuat_oleh' => $admin->id,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        // Memastikan aktivitas terbaru tertera beserta status badge
        $response->assertSee('DIST-20261124-0002');
        $response->assertSee('Kec. Banyumas');
        $response->assertSee('Disalurkan');
    }
}
