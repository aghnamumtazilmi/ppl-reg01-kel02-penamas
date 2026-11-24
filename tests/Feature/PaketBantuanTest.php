<?php

namespace Tests\Feature;

use App\Models\Distribusi;
use App\Models\KomponenBantuan;
use App\Models\PaketBantuan;
use App\Models\StokBantuan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaketBantuanTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test halaman daftar paket bantuan dapat dimuat dengan sukses (HTTP 200).
     */
    public function test_paket_index_page_can_be_rendered(): void
    {
        $response = $this->get('/paket');
        $response->assertStatus(200);
        $response->assertSee('Kelola Paket Bantuan (F-03)');
        $response->assertSee('Isaf Khiyar Musyaffa');
    }

    /**
     * Test PBI-007: Admin dapat membuat paket bantuan baru beserta komponen barangnya.
     */
    public function test_pbi_007_can_create_paket_bantuan_with_components(): void
    {
        // Komoditas stok gudang untuk saran otomatis
        StokBantuan::create([
            'nama_barang' => 'Beras Pandan Wangi',
            'satuan' => 'kg',
            'jumlah' => 100,
        ]);

        $payload = [
            'nama' => 'Paket Sembako Dhuafa',
            'deskripsi' => 'Paket sembako khusus keluarga prasejahtera',
            'komponen' => [
                [
                    'nama_barang' => 'Beras Pandan Wangi',
                    'satuan' => 'kg',
                    'jumlah' => 5,
                ],
                [
                    'nama_barang' => 'Minyak Goreng',
                    'satuan' => 'liter',
                    'jumlah' => 2,
                ],
            ],
        ];

        $response = $this->post('/paket', $payload);

        $response->assertRedirect('/paket');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('paket_bantuan', [
            'nama' => 'Paket Sembako Dhuafa',
        ]);

        $paket = PaketBantuan::where('nama', 'Paket Sembako Dhuafa')->first();
        $this->assertNotNull($paket);
        $this->assertCount(2, $paket->komponen);

        $this->assertDatabaseHas('komponen_bantuan', [
            'paket_bantuan_id' => $paket->id,
            'nama_barang' => 'Beras Pandan Wangi',
            'satuan' => 'kg',
            'jumlah' => 5,
        ]);
    }

    /**
     * Test PBI-008: Admin dapat mengubah rincian barang dalam paket bantuan.
     */
    public function test_pbi_008_can_update_paket_bantuan_components(): void
    {
        $paket = PaketBantuan::create([
            'nama' => 'Paket Awal',
            'deskripsi' => 'Deskripsi lama',
        ]);

        $paket->komponen()->create([
            'nama_barang' => 'Beras',
            'satuan' => 'kg',
            'jumlah' => 5,
        ]);

        $updatePayload = [
            'nama' => 'Paket Revisi',
            'deskripsi' => 'Deskripsi baru',
            'komponen' => [
                [
                    'nama_barang' => 'Beras',
                    'satuan' => 'kg',
                    'jumlah' => 10, // diubah dari 5 jadi 10
                ],
                [
                    'nama_barang' => 'Gula Pasir',
                    'satuan' => 'kg',
                    'jumlah' => 2, // komponen baru
                ],
            ],
        ];

        $response = $this->put("/paket/{$paket->id}", $updatePayload);

        $response->assertRedirect('/paket');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('paket_bantuan', [
            'id' => $paket->id,
            'nama' => 'Paket Revisi',
        ]);

        $paket->refresh();
        $this->assertCount(2, $paket->komponen);
        $this->assertDatabaseHas('komponen_bantuan', [
            'paket_bantuan_id' => $paket->id,
            'nama_barang' => 'Gula Pasir',
            'jumlah' => 2,
        ]);
    }

    /**
     * Test PBI-009: Admin dapat menghapus paket bantuan yang belum pernah dipakai.
     */
    public function test_pbi_009_can_delete_unused_paket_bantuan(): void
    {
        $paket = PaketBantuan::create([
            'nama' => 'Paket Percobaan',
            'deskripsi' => 'Akan dihapus',
        ]);

        $paket->komponen()->create([
            'nama_barang' => 'Garam',
            'satuan' => 'bungkus',
            'jumlah' => 1,
        ]);

        $response = $this->delete("/paket/{$paket->id}");

        $response->assertRedirect('/paket');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('paket_bantuan', [
            'id' => $paket->id,
        ]);

        $this->assertDatabaseMissing('komponen_bantuan', [
            'paket_bantuan_id' => $paket->id,
        ]);
    }

    /**
     * Test PBI-009: Sistem mencegah penghapusan jika paket bantuan sudah pernah dipakai di jadwal distribusi.
     */
    public function test_pbi_009_cannot_delete_paket_bantuan_used_in_distribution(): void
    {
        $admin = User::create([
            'name' => 'Admin Bansos',
            'email' => 'admin_test@penamas.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $paket = PaketBantuan::create([
            'nama' => 'Paket Terpakai',
            'deskripsi' => 'Paket terikat distribusi',
        ]);

        // Hubungkan paket ke satu jadwal distribusi
        Distribusi::create([
            'kode' => 'DIST-20261124-9999',
            'periode' => 'November 2026',
            'wilayah' => 'Purwokerto Selatan',
            'paket_bantuan_id' => $paket->id,
            'jumlah_penerima' => 20,
            'status' => 'disetujui',
            'dibuat_oleh' => $admin->id,
        ]);

        $response = $this->delete("/paket/{$paket->id}");

        $response->assertRedirect('/paket');
        $response->assertSessionHas('error');

        // Pastikan paket TETAP ADA di database (tidak terhapus)
        $this->assertDatabaseHas('paket_bantuan', [
            'id' => $paket->id,
            'nama' => 'Paket Terpakai',
        ]);
    }
}
