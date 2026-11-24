<?php

namespace Tests\Feature;

use App\Models\Distribusi;
use App\Models\PaketBantuan;
use App\Models\Penerima;
use App\Models\StokBantuan;
use App\Models\StokMutasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EndToEndPenamasFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ALUR 1: Modul Kelola Akun Pengguna (F-01: PBI-001, PBI-002, PBI-003 - Riyan)
     */
    public function test_01_alur_lengkap_kelola_akun_pengguna(): void
    {
        // 1. Registrasi Akun Baru (PBI-001)
        $registerResponse = $this->postJson('/api/users', [
            'name'                  => 'Budi Petugas Lapangan',
            'email'                 => 'budi.lapangan@penamas.id',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'petugas',
        ]);

        $registerResponse->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'Budi Petugas Lapangan')
            ->assertJsonPath('data.role', 'petugas');

        $userId = $registerResponse->json('data.id');

        // 2. Tampilkan Daftar Pengguna dengan Pencarian (PBI-001)
        $listResponse = $this->getJson('/api/users?search=Budi');
        $listResponse->assertStatus(200)
            ->assertJsonFragment(['email' => 'budi.lapangan@penamas.id']);

        // 3. Ubah Data dan Hak Akses Pengguna (PBI-002)
        $updateResponse = $this->putJson("/api/users/{$userId}", [
            'name'  => 'Budi Petugas Senior',
            'email' => 'budi.senior@penamas.id',
            'role'  => 'admin',
        ]);

        $updateResponse->assertStatus(200)
            ->assertJsonPath('data.name', 'Budi Petugas Senior')
            ->assertJsonPath('data.role', 'admin');

        // 4. Hapus Akun Pengguna (PBI-003)
        $deleteResponse = $this->deleteJson("/api/users/{$userId}");
        $deleteResponse->assertStatus(200);

        $this->assertDatabaseMissing('users', ['id' => $userId]);
    }

    /**
     * ALUR 2: Modul Kelola Data Penerima Bantuan (F-02: PBI-004, PBI-005, PBI-006 - Nayaka)
     */
    public function test_02_alur_lengkap_kelola_data_penerima_bantuan(): void
    {
        // 1. Buka Halaman Form Tambah Penerima
        $formResponse = $this->get(route('penerima.create'));
        $formResponse->assertStatus(200)
            ->assertSee('Pendaftaran Penerima Bantuan');

        // 2. Daftarkan Penerima Baru dengan NIK 16 Digit (PBI-004)
        $nikValid = '3302010101010001';
        $storeResponse = $this->post(route('penerima.store'), [
            'nik'       => $nikValid,
            'nama'      => 'Ahmad Sugeng Santoso',
            'alamat'    => 'Jl. Pahlawan RT 02 RW 03',
            'kelurahan' => 'Kranji',
            'kecamatan' => 'Purwokerto Timur',
            'no_hp'     => '081234567890',
        ]);

        $storeResponse->assertRedirect(route('penerima.index'));
        $this->assertDatabaseHas('penerima', [
            'nik'    => $nikValid,
            'status' => 'aktif',
        ]);

        $penerima = Penerima::where('nik', $nikValid)->first();

        // 3. Pencarian Berdasarkan NIK/Nama dan Filter Kecamatan (PBI-006)
        $searchResponse = $this->get(route('penerima.index', [
            'search'    => 'Ahmad Sugeng',
            'kecamatan' => 'Purwokerto Timur',
        ]));
        $searchResponse->assertStatus(200)
            ->assertSee('Ahmad Sugeng Santoso')
            ->assertSee($nikValid);

        // 4. Ubah Data Alamat & Status Penerima (PBI-005)
        $updateResponse = $this->put(route('penerima.update', $penerima->id), [
            'nama'      => 'Ahmad Sugeng Santoso',
            'alamat'    => 'Jl. Gerilya Barat No. 45',
            'kelurahan' => 'Kranji',
            'kecamatan' => 'Purwokerto Timur',
            'status'    => 'nonaktif', // Nonaktifkan penerima
        ]);

        $updateResponse->assertRedirect(route('penerima.index'));
        $penerima->refresh();
        $this->assertEquals('nonaktif', $penerima->status);
        $this->assertEquals('Jl. Gerilya Barat No. 45', $penerima->alamat);
    }

    /**
     * ALUR 3: Modul Master Stok Barang Gudang (F-04: PBI-010, PBI-011, PBI-012 - Aghna)
     */
    public function test_03_alur_lengkap_master_stok_barang_gudang(): void
    {
        // 1. Buka Halaman Form Tambah Komoditas (PBI-010)
        $formResponse = $this->get(route('stok.create'));
        $formResponse->assertStatus(200)
            ->assertSee('Catat Komoditas Pangan Baru');

        // 2. Daftarkan Komoditas Pangan Baru (PBI-010)
        $storeResponse = $this->post(route('stok.store'), [
            'nama_barang' => 'Minyak Goreng Sawit Murni',
            'satuan'      => 'liter',
            'jumlah'      => 250,
        ]);

        $storeResponse->assertRedirect(route('stok.index'));
        $this->assertDatabaseHas('stok_bantuan', [
            'nama_barang' => 'Minyak Goreng Sawit Murni',
            'satuan'      => 'liter',
            'jumlah'      => 250,
        ]);

        // 3. Pantau Daftar Sisa Stok Barang (PBI-011)
        $indexResponse = $this->get(route('stok.index', ['search' => 'Minyak Goreng Sawit']));
        $indexResponse->assertStatus(200)
            ->assertSee('Minyak Goreng Sawit Murni')
            ->assertSee('250');
    }

    /**
     * ALUR 4: Modul Mutasi Masuk Stok Gudang (F-06: PBI-016 - Helmi / User)
     * Acceptance Criteria:
     * - Admin memilih nama barang, mengisi jumlah masuk, dan keterangan sumber barang.
     * - Angka stok di gudang otomatis bertambah sesuai jumlah yang dimasukkan.
     */
    public function test_04_alur_lengkap_mutasi_masuk_stok_gudang(): void
    {
        $barang = StokBantuan::create([
            'nama_barang' => 'Beras Cadangan Pemerintah Daerah',
            'satuan'      => 'kg',
            'jumlah'      => 1000,
        ]);

        $admin = User::create([
            'name'     => 'Helmi Arif Operator',
            'email'    => 'helmi.operator@penamas.id',
            'password' => bcrypt('password123'),
            'role'     => 'admin',
        ]);

        // 1. Form Mutasi Masuk
        $formResponse = $this->actingAs($admin)->get(route('stok-mutasi.create'));
        $formResponse->assertStatus(200)
            ->assertSee('Pencatatan Mutasi Barang Masuk')
            ->assertSee('Beras Cadangan Pemerintah Daerah');

        // 2. Simpan Mutasi Masuk sebesar 500 kg
        $storeResponse = $this->actingAs($admin)->post(route('stok-mutasi.store'), [
            'stok_bantuan_id' => $barang->id,
            'jumlah'          => 500,
            'keterangan'      => 'Pengadaan APBD Dinsospermades Kab. Banyumas 2026',
        ]);

        $storeResponse->assertRedirect(route('stok-mutasi.index'));

        // [Kriteria 1] Tercatat di log stok_mutasi
        $this->assertDatabaseHas('stok_mutasi', [
            'stok_bantuan_id' => $barang->id,
            'tipe'            => 'masuk',
            'jumlah'          => 500,
            'keterangan'      => 'Pengadaan APBD Dinsospermades Kab. Banyumas 2026',
        ]);

        // [Kriteria 2] Saldo stok gudang otomatis bertambah dari 1000 menjadi 1500
        $barang->refresh();
        $this->assertEquals(1500, $barang->jumlah);

        // 3. Verifikasi muncul di halaman riwayat dan KPI bertambah
        $indexResponse = $this->actingAs($admin)->get(route('stok-mutasi.index'));
        $indexResponse->assertStatus(200)
            ->assertSee('Beras Cadangan Pemerintah Daerah')
            ->assertSee('Pengadaan APBD Dinsospermades');
    }

    /**
     * ALUR 5: Modul Mutasi Keluar Manual Stok Gudang (F-06: PBI-017 - Helmi / User)
     * Acceptance Criteria:
     * - Admin mengisi kuantitas keluar & alasan.
     * - Sistem menolak jika jumlah keluar melebihi saldo gudang.
     * - Saldo stok otomatis berkurang.
     */
    public function test_05_alur_lengkap_mutasi_keluar_manual_stok_gudang(): void
    {
        $barang = StokBantuan::create([
            'nama_barang' => 'Telur Ayam Rentan Rusak',
            'satuan'      => 'kg',
            'jumlah'      => 50,
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'admin.mutasi@penamas.id'],
            ['name' => 'Admin Mutasi', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        // 1. Coba keluarkan melebihi saldo (50 kg < 100 kg) -> Wajib ditolak!
        $rejectResponse = $this->actingAs($admin)->post(route('stok-mutasi.store-keluar'), [
            'stok_bantuan_id' => $barang->id,
            'jumlah'          => 100,
            'keterangan'      => 'Pemusnahan telur pecah akibat pengiriman',
        ]);

        $rejectResponse->assertSessionHasErrors(['jumlah']);
        $barang->refresh();
        $this->assertEquals(50, $barang->jumlah); // Saldo tetap aman

        // 2. Keluarkan dalam batas saldo (10 kg) -> Wajib berhasil
        $successResponse = $this->actingAs($admin)->post(route('stok-mutasi.store-keluar'), [
            'stok_bantuan_id' => $barang->id,
            'jumlah'          => 10,
            'keterangan'      => 'Pemusnahan telur retak / busuk saat sortasi gudang',
        ]);

        $successResponse->assertRedirect(route('stok-mutasi.index'));

        // Saldo berkurang dari 50 menjadi 40
        $barang->refresh();
        $this->assertEquals(40, $barang->jumlah);

        $this->assertDatabaseHas('stok_mutasi', [
            'stok_bantuan_id' => $barang->id,
            'tipe'            => 'keluar',
            'jumlah'          => 10,
        ]);
    }

    /**
     * ALUR 6: Proteksi Penghapusan Master Barang Jika Memiliki Mutasi (F-04: PBI-012)
     */
    public function test_06_proteksi_penghapusan_barang_yang_memiliki_mutasi(): void
    {
        $barang = StokBantuan::create([
            'nama_barang' => 'Gula Pasir Dilindungi',
            'satuan'      => 'kg',
            'jumlah'      => 100,
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'admin.guard@penamas.id'],
            ['name' => 'Admin Guard', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        // Buat mutasi masuk
        StokMutasi::create([
            'stok_bantuan_id' => $barang->id,
            'tipe'            => 'masuk',
            'jumlah'          => 100,
            'keterangan'      => 'Pengadaan awal',
            'user_id'         => $admin->id,
        ]);

        // Coba hapus barang lewat route stok.destroy
        $deleteResponse = $this->delete(route('stok.destroy', $barang->id));

        $deleteResponse->assertRedirect(route('stok.index'));
        $deleteResponse->assertSessionHas('error'); // Ditolak karena punya relasi mutasi!

        // Barang masih utuh di database
        $this->assertDatabaseHas('stok_bantuan', ['id' => $barang->id]);
    }

    /**
     * ALUR 7: Modul Penyaluran Bantuan Lapangan (F-09: PBI-025, PBI-026, PBI-027 - Nayaka)
     */
    public function test_07_alur_lengkap_penyaluran_bantuan_lapangan(): void
    {
        $petugas = User::create([
            'name'     => 'Petugas TKSK Lapangan',
            'email'    => 'tksk.lapangan@penamas.id',
            'password' => bcrypt('password123'),
            'role'     => 'petugas',
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'admin.dist@penamas.id'],
            ['name' => 'Admin Distribusi', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        $paket = PaketBantuan::create([
            'nama'      => 'Paket Sembako Tanggap Darurat',
            'deskripsi' => 'Beras, minyak, gula untuk korban bencana',
        ]);

        // Buat Rencana Distribusi berstatus 'disetujui'
        $distribusi = Distribusi::create([
            'kode'             => 'DIST-20261124-0001',
            'periode'          => 'November 2026',
            'wilayah'          => 'Kecamatan Baturraden',
            'paket_bantuan_id' => $paket->id,
            'jumlah_penerima'  => 5,
            'status'           => 'disetujui',
            'dibuat_oleh'      => $admin->id,
            'disetujui_oleh'   => $admin->id,
        ]);

        // Tugaskan petugas ke distribusi ini
        $distribusi->petugas()->attach($petugas->id);

        // 1. Petugas Melihat Daftar Tugas yang Ditugaskan (PBI-025 AC-1)
        $indexResponse = $this->actingAs($petugas)->get(route('penyaluran.index', ['petugas_id' => $petugas->id]));
        $indexResponse->assertStatus(200)
            ->assertSee('DIST-20261124-0001')
            ->assertSee('Kecamatan Baturraden');

        // 2. Petugas Melihat Rincian Tugas (PBI-025 AC-2)
        $showResponse = $this->actingAs($petugas)->get(route('penyaluran.show', $distribusi->id));
        $showResponse->assertStatus(200)
            ->assertSee('DIST-20261124-0001')
            ->assertSee('Paket Sembako Tanggap Darurat');

        // 3. Petugas Mencatat Realisasi Serah Terima (PBI-026)
        $realisasiResponse = $this->actingAs($petugas)->post(route('penyaluran.realisasi.store', $distribusi->id), [
            'tanggal_penyaluran' => '2026-11-24',
            'jumlah_disalurkan'  => 5,
            'keterangan'         => 'Bantuan berhasil diserahkan langsung ke seluruh KPM di Balai Desa',
        ]);

        $realisasiResponse->assertRedirect(route('penyaluran.show', $distribusi->id));

        // Verifikasi status distribusi berubah menjadi 'disalurkan' (PBI-026 AC-2)
        $distribusi->refresh();
        $this->assertEquals('disalurkan', $distribusi->status);

        $this->assertDatabaseHas('penyaluran', [
            'distribusi_id'     => $distribusi->id,
            'jumlah_disalurkan' => 5,
        ]);
    }
}
