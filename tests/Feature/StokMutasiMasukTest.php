<?php

namespace Tests\Feature;

use App\Models\StokBantuan;
use App\Models\StokMutasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StokMutasiMasukTest extends TestCase
{
    use RefreshDatabase;

    /**
     * [PBI-016] Test 1: Halaman form pencatatan mutasi masuk dapat diakses dengan sukses
     */
    public function test_halaman_catat_mutasi_masuk_dapat_diakses(): void
    {
        $response = $this->get(route('stok-mutasi.create'));

        $response->assertStatus(200);
        $response->assertSee('Pencatatan Mutasi Barang Masuk');
        $response->assertSee('PBI-016');
    }

    /**
     * [PBI-016] Test 2: Admin mencatat mutasi masuk dan angka stok di gudang otomatis bertambah
     * Acceptance Criteria:
     * - Admin memilih nama barang, mengisi jumlah masuk, dan keterangan sumber barang.
     * - Angka stok di gudang otomatis bertambah sesuai jumlah yang dimasukkan.
     */
    public function test_admin_mencatat_mutasi_masuk_dan_stok_gudang_otomatis_bertambah(): void
    {
        // 1. Arrange: Siapkan barang uji coba dengan saldo awal 100
        $barang = StokBantuan::create([
            'nama_barang' => 'Beras Uji Coba PBI-016',
            'satuan'      => 'kg',
            'jumlah'      => 100,
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'operator.test@banyumaskab.go.id'],
            [
                'name'     => 'Operator Bansos Test',
                'password' => bcrypt('password'),
                'role'     => 'admin',
            ]
        );

        // 2. Act: Kirim request POST mutasi masuk sebesar 50 unit
        $response = $this->actingAs($admin)->post(route('stok-mutasi.store'), [
            'stok_bantuan_id' => $barang->id,
            'jumlah'          => 50,
            'keterangan'      => 'Pengadaan APBD Dinsospermades Banyumas 2026',
        ]);

        // 3. Assert:
        // Redirect ke index dengan notifikasi sukses
        $response->assertRedirect(route('stok-mutasi.index'));
        $response->assertSessionHas('success');

        // [Kriteria 1] Catatan mutasi masuk tersimpan di tabel stok_mutasi
        $this->assertDatabaseHas('stok_mutasi', [
            'stok_bantuan_id' => $barang->id,
            'tipe'            => 'masuk',
            'jumlah'          => 50,
            'keterangan'      => 'Pengadaan APBD Dinsospermades Banyumas 2026',
        ]);

        // [Kriteria 2] Saldo stok gudang otomatis bertambah dari 100 menjadi 150
        $barang->refresh();
        $this->assertEquals(150, $barang->jumlah);
    }

    /**
     * [PBI-016] Test 4: Halaman riwayat menampilkan data mutasi dan KPI statistik
     */
    public function test_halaman_riwayat_mutasi_menampilkan_data_dan_kpi(): void
    {
        $barang = StokBantuan::create([
            'nama_barang' => 'Minyak Goreng Test',
            'satuan'      => 'liter',
            'jumlah'      => 500,
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'operator.kpi@banyumaskab.go.id'],
            [
                'name'     => 'Operator KPI',
                'password' => bcrypt('password'),
                'role'     => 'admin',
            ]
        );

        StokMutasi::create([
            'stok_bantuan_id' => $barang->id,
            'tipe'            => 'masuk',
            'jumlah'          => 200,
            'keterangan'      => 'Donasi BAZNAS Banyumas',
            'user_id'         => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get(route('stok-mutasi.index'));

        $response->assertStatus(200);
        $response->assertSee('Minyak Goreng Test');
        $response->assertSee('Donasi BAZNAS Banyumas');
        $response->assertSee('Catatan Keluar-Masuk Stok Pangan');
    }

    /**
     * [PBI-016] Test 4: Validasi menolak jika input kosong atau tidak valid
     */
    public function test_validasi_menolak_jika_input_tidak_lengkap(): void
    {
        $response = $this->post(route('stok-mutasi.store'), [
            'stok_bantuan_id' => '',
            'jumlah'          => 0, // Minimal 1
            'keterangan'      => '',
        ]);

        $response->assertSessionHasErrors(['stok_bantuan_id', 'jumlah', 'keterangan']);
    }
}
