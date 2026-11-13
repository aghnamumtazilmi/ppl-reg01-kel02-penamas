<?php

namespace Database\Seeders;

use App\Models\StokBantuan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StokBantuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Mengisi data awal komoditas pangan bansos & akun Admin Operator Bansos
     */
    public function run(): void
    {
        // 1. Akun Admin / Operator Bansos (Default untuk audit trail pencatat mutasi)
        $admin = User::firstOrCreate(
            ['email' => 'operator.bansos@banyumaskab.go.id'],
            [
                'name'     => 'Helmi Arif (Operator Gudang)',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
            ]
        );

        // 2. Daftar Komoditas Bahan Pangan Bantuan Dinsospermades Kab. Banyumas
        $komoditas = [
            ['nama_barang' => 'Beras Medium Ramos', 'satuan' => 'kg', 'jumlah' => 1500],
            ['nama_barang' => 'Beras Premium', 'satuan' => 'kg', 'jumlah' => 2000],
            ['nama_barang' => 'Minyak Goreng Sawit', 'satuan' => 'liter', 'jumlah' => 800],
            ['nama_barang' => 'Gula Pasir Kristal Putih', 'satuan' => 'kg', 'jumlah' => 600],
            ['nama_barang' => 'Telur Ayam Ras', 'satuan' => 'kg', 'jumlah' => 450],
            ['nama_barang' => 'Sarden Ikan Kaleng 425g', 'satuan' => 'kaleng', 'jumlah' => 1200],
            ['nama_barang' => 'Mie Instan Sedap / Indomie', 'satuan' => 'dus', 'jumlah' => 350],
            ['nama_barang' => 'Susu Kental Manis 370g', 'satuan' => 'kaleng', 'jumlah' => 500],
            ['nama_barang' => 'Garam Beryodium 250g', 'satuan' => 'bungkus', 'jumlah' => 400],
            ['nama_barang' => 'Kacang Hijau Kupas', 'satuan' => 'kg', 'jumlah' => 250],
        ];

        foreach ($komoditas as $item) {
            StokBantuan::firstOrCreate(
                ['nama_barang' => $item['nama_barang']],
                [
                    'satuan' => $item['satuan'],
                    'jumlah' => $item['jumlah'],
                ]
            );
        }
    }
}
