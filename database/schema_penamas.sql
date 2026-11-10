-- ============================================================
-- SKRIP BASIS DATA RESMI APLIKASI PENAMAS
-- Sistem Informasi Pengelolaan Bantuan Pangan Kab. Banyumas
-- Kelompok 2 (REG 01) - PPL
-- Target DBMS: MySQL 8.0+ / MariaDB 10.4+ / PostgreSQL Compatible
-- ============================================================

CREATE DATABASE IF NOT EXISTS `penamas` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `penamas`;

-- ------------------------------------------------------------
-- 1. TABEL USERS (Kelola Akun & Multi-Role: Pimpinan, Admin, Petugas)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('pimpinan', 'admin', 'petugas') NOT NULL DEFAULT 'petugas',
    `remember_token` VARCHAR(100) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`),
    INDEX `idx_users_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 2. TABEL PENERIMA (Keluarga Penerima Manfaat / KPM Banyumas)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `penerima` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nik` VARCHAR(16) NOT NULL,
    `nama` VARCHAR(255) NOT NULL,
    `alamat` TEXT NOT NULL,
    `kelurahan` VARCHAR(100) NOT NULL,
    `kecamatan` VARCHAR(100) NOT NULL,
    `kabupaten` VARCHAR(100) NOT NULL DEFAULT 'Banyumas',
    `no_hp` VARCHAR(20) NULL DEFAULT NULL,
    `status` ENUM('aktif', 'nonaktif') NOT NULL DEFAULT 'aktif',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `penerima_nik_unique` (`nik`),
    INDEX `idx_penerima_kecamatan` (`kecamatan`),
    INDEX `idx_penerima_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 3. TABEL PAKET BANTUAN (Definisi Paket Pangan)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `paket_bantuan` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(255) NOT NULL,
    `deskripsi` TEXT NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 4. TABEL KOMPONEN BANTUAN (Rincian Komoditas per Paket)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `komponen_bantuan` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `paket_bantuan_id` BIGINT UNSIGNED NOT NULL,
    `nama_barang` VARCHAR(255) NOT NULL,
    `satuan` VARCHAR(50) NOT NULL,
    `jumlah` DECIMAL(10,2) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `komponen_paket_bantuan_fk` (`paket_bantuan_id`),
    CONSTRAINT `fk_komponen_paket` FOREIGN KEY (`paket_bantuan_id`) REFERENCES `paket_bantuan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 5. TABEL STOK BANTUAN (Inventaris Persediaan Gudang)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `stok_bantuan` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama_barang` VARCHAR(255) NOT NULL,
    `satuan` VARCHAR(50) NOT NULL,
    `jumlah` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `stok_nama_barang_unique` (`nama_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 6. TABEL STOK MUTASI (Buku Besar Pergerakan Keluar/Masuk Gudang)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `stok_mutasi` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `stok_bantuan_id` BIGINT UNSIGNED NOT NULL,
    `tipe` ENUM('masuk', 'keluar') NOT NULL,
    `jumlah` INT NOT NULL,
    `keterangan` TEXT NULL DEFAULT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `stok_mutasi_stok_fk` (`stok_bantuan_id`),
    KEY `stok_mutasi_user_fk` (`user_id`),
    CONSTRAINT `fk_mutasi_stok` FOREIGN KEY (`stok_bantuan_id`) REFERENCES `stok_bantuan` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_mutasi_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 7. TABEL DISTRIBUSI (Rencana & Alur Persetujuan Distribusi)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `distribusi` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `kode` VARCHAR(50) NOT NULL,
    `periode` VARCHAR(50) NOT NULL,
    `wilayah` VARCHAR(100) NOT NULL,
    `paket_bantuan_id` BIGINT UNSIGNED NOT NULL,
    `jumlah_penerima` INT NOT NULL DEFAULT 0,
    `status` ENUM('draft', 'diajukan', 'disetujui', 'ditolak', 'disalurkan') NOT NULL DEFAULT 'draft',
    `catatan` TEXT NULL DEFAULT NULL,
    `catatan_persetujuan` TEXT NULL DEFAULT NULL,
    `dibuat_oleh` BIGINT UNSIGNED NOT NULL,
    `disetujui_oleh` BIGINT UNSIGNED NULL DEFAULT NULL,
    `tanggal_pengajuan` TIMESTAMP NULL DEFAULT NULL,
    `tanggal_persetujuan` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `distribusi_kode_unique` (`kode`),
    KEY `distribusi_paket_fk` (`paket_bantuan_id`),
    KEY `distribusi_dibuat_fk` (`dibuat_oleh`),
    KEY `distribusi_disetujui_fk` (`disetujui_oleh`),
    INDEX `idx_distribusi_status` (`status`),
    INDEX `idx_distribusi_wilayah` (`wilayah`),
    CONSTRAINT `fk_distribusi_paket` FOREIGN KEY (`paket_bantuan_id`) REFERENCES `paket_bantuan` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_distribusi_dibuat` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_distribusi_disetujui` FOREIGN KEY (`disetujui_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 8. TABEL DISTRIBUSI DETAIL (Pivot Distribusi - Penerima Sasaran KPM)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `distribusi_detail` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `distribusi_id` BIGINT UNSIGNED NOT NULL,
    `penerima_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `distribusi_detail_unique` (`distribusi_id`, `penerima_id`),
    CONSTRAINT `fk_detail_distribusi` FOREIGN KEY (`distribusi_id`) REFERENCES `distribusi` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_detail_penerima` FOREIGN KEY (`penerima_id`) REFERENCES `penerima` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 9. TABEL DISTRIBUSI PETUGAS (Pivot Distribusi - Petugas Lapangan)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `distribusi_petugas` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `distribusi_id` BIGINT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `distribusi_petugas_unique` (`distribusi_id`, `user_id`),
    CONSTRAINT `fk_petugas_distribusi` FOREIGN KEY (`distribusi_id`) REFERENCES `distribusi` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_petugas_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 10. TABEL PENYALURAN (Realisasi Serah Terima & Unggah Foto Bukti)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `penyaluran` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `distribusi_id` BIGINT UNSIGNED NOT NULL,
    `tanggal_penyaluran` DATE NOT NULL,
    `jumlah_disalurkan` INT NOT NULL,
    `keterangan` TEXT NULL DEFAULT NULL,
    `foto_bukti` VARCHAR(255) NULL DEFAULT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `penyaluran_distribusi_fk` (`distribusi_id`),
    KEY `penyaluran_user_fk` (`user_id`),
    CONSTRAINT `fk_penyaluran_distribusi` FOREIGN KEY (`distribusi_id`) REFERENCES `distribusi` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_penyaluran_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

