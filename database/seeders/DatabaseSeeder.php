<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PaketBantuan;
use App\Models\KomponenBantuan;
use App\Models\StokBantuan;
use App\Models\Penerima;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ─── Default Users (3 Roles) ───────────────────────────

        User::updateOrCreate(
            ['email' => 'pimpinan@penamas.test'],
            ['name' => 'Pimpinan PENAMAS', 'password' => Hash::make('password'), 'role' => 'pimpinan']
        );

        User::updateOrCreate(
            ['email' => 'admin@penamas.test'],
            ['name' => 'Admin PENAMAS', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'petugas@penamas.test'],
            ['name' => 'Petugas Utama (Budi)', 'password' => Hash::make('password'), 'role' => 'petugas']
        );

        User::updateOrCreate(
            ['email' => 'petugas2@penamas.test'],
            ['name' => 'Hendra Kurniawan', 'password' => Hash::make('password'), 'role' => 'petugas']
        );

        User::updateOrCreate(
            ['email' => 'petugas3@penamas.test'],
            ['name' => 'Nurul Hidayati', 'password' => Hash::make('password'), 'role' => 'petugas']
        );

        User::updateOrCreate(
            ['email' => 'petugas4@penamas.test'],
            ['name' => 'Fajar Prasetyo', 'password' => Hash::make('password'), 'role' => 'petugas']
        );

        User::updateOrCreate(
            ['email' => 'petugas5@penamas.test'],
            ['name' => 'Rini Anggraeni', 'password' => Hash::make('password'), 'role' => 'petugas']
        );

        // ─── Sample Penerima ───────────────────────────────────

        $penerimaData = [
            // Purwokerto Selatan
            ['nik' => '3302010101010001', 'nama' => 'Ahmad Suryadi', 'alamat' => 'Jl. Merdeka No. 10', 'kelurahan' => 'Purwokerto Kulon', 'kecamatan' => 'Purwokerto Selatan', 'no_hp' => '081234567890'],
            ['nik' => '3302010101010003', 'nama' => 'Budi Santoso', 'alamat' => 'Jl. Gatot Subroto No. 3', 'kelurahan' => 'Berkoh', 'kecamatan' => 'Purwokerto Selatan', 'no_hp' => '081234567891'],
            ['nik' => '3302010101010006', 'nama' => 'Sri Wahyuni', 'alamat' => 'Jl. Veteran No. 12', 'kelurahan' => 'Karangklesem', 'kecamatan' => 'Purwokerto Selatan', 'no_hp' => '081234567892'],

            // Purwokerto Timur
            ['nik' => '3302010101010002', 'nama' => 'Siti Aminah', 'alamat' => 'Jl. Pahlawan No. 5', 'kelurahan' => 'Purwokerto Wetan', 'kecamatan' => 'Purwokerto Timur', 'no_hp' => '081234567893'],
            ['nik' => '3302010101010004', 'nama' => 'Dewi Lestari', 'alamat' => 'Jl. Sudirman No. 15', 'kelurahan' => 'Sokanegara', 'kecamatan' => 'Purwokerto Timur', 'no_hp' => '081234567894'],
            ['nik' => '3302010101010005', 'nama' => 'Rahmat Hidayat', 'alamat' => 'Jl. Diponegoro No. 8', 'kelurahan' => 'Kranji', 'kecamatan' => 'Purwokerto Timur', 'no_hp' => '081234567895'],

            // Purwokerto Barat
            ['nik' => '3302010101010007', 'nama' => 'Bambang Supriyanto', 'alamat' => 'Jl. Pasirmuncang No. 4', 'kelurahan' => 'Pasirmuncang', 'kecamatan' => 'Purwokerto Barat', 'no_hp' => '081234567896'],
            ['nik' => '3302010101010008', 'nama' => 'Kusuma Wardani', 'alamat' => 'Jl. Bantarsoka No. 22', 'kelurahan' => 'Bantarsoka', 'kecamatan' => 'Purwokerto Barat', 'no_hp' => '081234567897'],

            // Sokaraja
            ['nik' => '3302010101010009', 'nama' => 'Slamet Riyadi', 'alamat' => 'Jl. Suparjo Rustam No. 7', 'kelurahan' => 'Sokaraja Kulon', 'kecamatan' => 'Sokaraja', 'no_hp' => '081234567898'],
            ['nik' => '3302010101010010', 'nama' => 'Tri Hastuti', 'alamat' => 'Jl. Jenderal Sudirman No. 34', 'kelurahan' => 'Sokaraja Tengah', 'kecamatan' => 'Sokaraja', 'no_hp' => '081234567899'],

            // Banyumas
            ['nik' => '3302010101010011', 'nama' => 'Hadi Purnomo', 'alamat' => 'Jl. Kejawar No. 11', 'kelurahan' => 'Kejawar', 'kecamatan' => 'Banyumas', 'no_hp' => '081234567810'],
            ['nik' => '3302010101010012', 'nama' => 'Endang Sulastri', 'alamat' => 'Jl. Alun-Alun Banyumas No. 2', 'kelurahan' => 'Sudagaran', 'kecamatan' => 'Banyumas', 'no_hp' => '081234567811'],
        ];

        foreach ($penerimaData as $data) {
            Penerima::updateOrCreate(
                ['nik' => $data['nik']],
                array_merge($data, ['kabupaten' => 'Banyumas', 'status' => 'aktif'])
            );
        }

        // ─── Sample Paket Bantuan ──────────────────────────────
        $paket1 = PaketBantuan::firstOrCreate(
            ['nama' => 'Paket Sembako A'],
            ['deskripsi' => 'Paket bantuan sembako dasar untuk keluarga']
        );
        KomponenBantuan::firstOrCreate(['paket_bantuan_id' => $paket1->id, 'nama_barang' => 'Beras'], ['satuan' => 'kg', 'jumlah' => 5]);
        KomponenBantuan::firstOrCreate(['paket_bantuan_id' => $paket1->id, 'nama_barang' => 'Minyak Goreng'], ['satuan' => 'liter', 'jumlah' => 2]);
        KomponenBantuan::firstOrCreate(['paket_bantuan_id' => $paket1->id, 'nama_barang' => 'Gula Pasir'], ['satuan' => 'kg', 'jumlah' => 1]);

        $paket2 = PaketBantuan::firstOrCreate(
            ['nama' => 'Paket Sembako B'],
            ['deskripsi' => 'Paket bantuan sembako lengkap untuk keluarga besar']
        );
        KomponenBantuan::firstOrCreate(['paket_bantuan_id' => $paket2->id, 'nama_barang' => 'Beras'], ['satuan' => 'kg', 'jumlah' => 10]);
        KomponenBantuan::firstOrCreate(['paket_bantuan_id' => $paket2->id, 'nama_barang' => 'Minyak Goreng'], ['satuan' => 'liter', 'jumlah' => 3]);
        KomponenBantuan::firstOrCreate(['paket_bantuan_id' => $paket2->id, 'nama_barang' => 'Gula Pasir'], ['satuan' => 'kg', 'jumlah' => 2]);
        KomponenBantuan::firstOrCreate(['paket_bantuan_id' => $paket2->id, 'nama_barang' => 'Tepung Terigu'], ['satuan' => 'kg', 'jumlah' => 1]);

        // ─── Sample Stok Bantuan ───────────────────────────────
        StokBantuan::firstOrCreate(['nama_barang' => 'Beras'], ['satuan' => 'kg', 'jumlah' => 500]);
        StokBantuan::firstOrCreate(['nama_barang' => 'Minyak Goreng'], ['satuan' => 'liter', 'jumlah' => 200]);
        StokBantuan::firstOrCreate(['nama_barang' => 'Gula Pasir'], ['satuan' => 'kg', 'jumlah' => 150]);
        StokBantuan::firstOrCreate(['nama_barang' => 'Tepung Terigu'], ['satuan' => 'kg', 'jumlah' => 100]);
    }
}
