<?php

namespace Database\Seeders;

use App\Models\Distribusi;
use App\Models\PaketBantuan;
use App\Models\Penerima;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DistribusiDisetujuiSeeder extends Seeder
{
    /**
     * Seeder untuk menyiapkan data pengujian PBI-025, PBI-026, PBI-027
     */
    public function run(): void
    {
        // 1. Pastikan ada Akun Admin & Petugas Lapangan
        $admin = User::firstOrCreate(
            ['email' => 'admin@penamas.id'],
            [
                'name' => 'Administrator Penamas',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@penamas.id'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'petugas',
            ]
        );

        // 2. Pastikan ada Paket Bantuan
        $paket = PaketBantuan::firstOrCreate(
            ['nama' => 'Paket Sembako Beras 10kg'],
            [
                'deskripsi' => 'Bantuan pangan pokok berupa beras premium 10kg dan kebutuhan dasar pangan',
            ]
        );

        // 3. Pastikan ada Penerima Bantuan (KPM)
        $penerimaList = Penerima::where('status', 'aktif')->take(5)->get();
        if ($penerimaList->isEmpty()) {
            $penerima1 = Penerima::create([
                'nik' => '3302111203850001',
                'nama' => 'Slamet Riyadi',
                'alamat' => 'Jl. Gerilya No. 45 RT 02/RW 03',
                'kelurahan' => 'Karangpucung',
                'kecamatan' => 'Purwokerto Selatan',
                'kabupaten' => 'Banyumas',
                'status' => 'aktif',
            ]);
            $penerima2 = Penerima::create([
                'nik' => '3302111508900002',
                'nama' => 'Siti Aminah',
                'alamat' => 'Jl. Pahlawan Gg. Melati RT 01/RW 02',
                'kelurahan' => 'Tanjung',
                'kecamatan' => 'Purwokerto Selatan',
                'kabupaten' => 'Banyumas',
                'status' => 'aktif',
            ]);
            $penerimaList = collect([$penerima1, $penerima2]);
        }

        // 4. Buat Rencana Distribusi berstatus 'disetujui' (Kriteria PBI-025)
        $distribusi = Distribusi::firstOrCreate(
            ['kode' => 'DIST-20261116-0001'],
            [
                'periode' => 'November 2026',
                'wilayah' => 'Purwokerto Selatan',
                'paket_bantuan_id' => $paket->id,
                'jumlah_penerima' => $penerimaList->count(),
                'status' => 'disetujui', // Kriteria AC 1: Harus berstatus Disetujui
                'catatan' => 'Penyaluran bantuan beras tahap 1 untuk warga pra-sejahtera',
                'catatan_persetujuan' => 'Rencana distribusi telah ditinjau dan disetujui untuk disalurkan ke lapangan',
                'dibuat_oleh' => $admin->id,
                'disetujui_oleh' => $admin->id,
                'tanggal_pengajuan' => now()->subDays(2),
                'tanggal_persetujuan' => now()->subDay(),
            ]
        );

        // 5. Tugaskan Petugas Lapangan ke Distribusi ini (distribusi_petugas)
        $distribusi->petugas()->sync([$petugas->id]);

        // 6. Hubungkan Warga KPM ke Distribusi ini (distribusi_detail)
        $distribusi->penerima()->sync($penerimaList->pluck('id'));
    }
}
