-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 09 Nov 2025 pada 03.57
-- Versi server: 8.0.30
-- Versi PHP: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_program_crud`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `formulir`
--

CREATE TABLE `formulir` (
  `id_formulir` bigint NOT NULL,
  `id_karyawan` int NOT NULL,
  `tgl_formulir` date NOT NULL,
  `status` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `lama_cuti` int DEFAULT NULL,
  `jenis_cuti` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tgl_ijin` date DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `alasan_ijin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bukti` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `status_approved` char(1) DEFAULT '0',
  `alasan_penolakan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `formulir`
--

INSERT INTO `formulir` (`id_formulir`, `id_karyawan`, `tgl_formulir`, `status`, `tgl_mulai`, `tgl_selesai`, `lama_cuti`, `jenis_cuti`, `tgl_ijin`, `jam_mulai`, `jam_selesai`, `alasan_ijin`, `keterangan`, `bukti`, `status_approved`, `alasan_penolakan`) VALUES
(20, 19231641, '2025-05-26', 'Ijin', NULL, NULL, NULL, NULL, '2025-05-28', '07:00:00', '10:00:00', 'Urusan Keluarga', 'keperluan keluarga', '19231641-20250526.jpg', '2', 'kurang meyakinkan'),
(21, 19230018, '2025-04-26', 'Cuti', '2025-05-05', '2025-09-05', 90, 'Cuti Melahirkan', NULL, NULL, NULL, NULL, 'melahirkan', '19230018-20250426.png', '1', NULL),
(22, 19230018, '2025-04-27', 'Cuti', '2025-04-28', '2025-04-28', 1, 'Cuti Tahunan', NULL, NULL, NULL, NULL, 'ada perlu', NULL, '2', NULL),
(23, 19231641, '2025-05-02', 'Cuti', '2025-05-02', '2025-05-05', 2, 'Cuti Istri Melahirkan', NULL, NULL, NULL, NULL, 'istri melahirkan', NULL, '1', NULL),
(24, 19230018, '2025-05-04', 'Ijin', NULL, NULL, NULL, NULL, '2025-05-05', '10:00:00', '11:00:00', 'Dinas Luar', 'ingin ke bank', NULL, '1', NULL),
(25, 19231641, '2025-05-06', 'Cuti', '2025-05-07', '2025-05-07', 1, 'Cuti Tahunan', NULL, NULL, NULL, NULL, 'mau mudik', NULL, '1', NULL),
(27, 19231641, '2025-05-10', 'Cuti', '2025-05-21', '2025-05-23', 3, 'Cuti Menikah', NULL, NULL, NULL, NULL, 'get married', NULL, '1', NULL),
(28, 19231641, '2025-05-10', 'Ijin', NULL, NULL, NULL, NULL, '2025-05-05', '08:05:00', '10:00:00', 'Pulang Cepat', 'healing', NULL, '1', NULL),
(29, 19230018, '2025-05-10', 'Cuti', '2025-05-12', '2025-05-14', 3, 'Cuti Tahunan', NULL, NULL, NULL, NULL, 'keperluan keluarga', NULL, '1', NULL),
(30, 19232566, '2025-05-11', 'Cuti', '2025-05-13', '2025-05-14', 2, 'Cuti Tahunan', NULL, NULL, NULL, NULL, 'keperluan keluarga', NULL, '2', 'sertakan foto bukti'),
(31, 19231641, '2025-05-24', 'Ijin', NULL, NULL, NULL, NULL, '2025-05-05', '08:05:00', '12:00:00', 'Pulang Cepat', 'healing', '19231641-20250524.jpg', '0', NULL),
(38, 19230018, '2025-05-22', 'Ijin', NULL, NULL, NULL, NULL, '2025-05-23', '07:00:00', '11:08:00', 'Sakit', 'mau ke dokter', NULL, '0', NULL),
(39, 19232029, '2025-05-22', 'Ijin', NULL, NULL, NULL, NULL, '2025-05-23', '07:00:00', '06:00:00', 'Sakit', 'mau ke dokter', NULL, '0', NULL),
(51, 19230761, '2025-05-22', 'Cuti', '2025-05-23', '2025-05-23', 1, 'Cuti Tahunan', NULL, NULL, NULL, NULL, 'sasda', NULL, '0', NULL),
(53, 19232029, '2025-05-22', 'Ijin', NULL, NULL, NULL, NULL, '2025-05-23', '04:00:00', '06:07:00', 'Sakit', 'sakit', NULL, '0', NULL),
(55, 19230386, '2025-05-22', 'Cuti', '2025-05-26', '2025-05-26', 1, 'Cuti Tahunan', NULL, NULL, NULL, NULL, 'ingin pulang kampung', '19230386-20250522.jpg', '0', NULL),
(61, 19231641, '2025-05-26', 'Cuti', '2025-05-26', '2025-05-26', 1, 'Cuti Tahunan', NULL, NULL, NULL, NULL, 'pulang kampung unutk mengurus surat domisili', '19231641-20250526.jpg', '0', NULL),
(63, 19231641, '2025-05-24', 'Ijin', NULL, NULL, NULL, NULL, '2025-05-28', '05:00:00', '11:00:00', 'Urusan Keluarga', 'tes', NULL, '0', NULL),
(64, 19230866, '2025-05-24', 'Cuti', '2025-06-02', '2025-06-04', 3, 'Cuti Menikah', NULL, NULL, NULL, NULL, 'menikah', NULL, '0', NULL),
(67, 19232566, '2025-05-26', 'Cuti', '2025-05-27', '2025-05-27', 1, 'Cuti Tahunan', NULL, NULL, NULL, NULL, 'keperluan lain', '19232566-20250526.jpg', '1', NULL),
(69, 19232566, '2025-06-18', 'Cuti', '2025-06-19', '2025-06-19', 1, 'Cuti Tahunan', NULL, NULL, NULL, NULL, 'ingin liburan', NULL, '0', NULL),
(70, 19232566, '2025-06-20', 'Cuti', '2025-06-20', '2025-06-22', 1, 'Cuti Tahunan', NULL, NULL, NULL, NULL, 'mau healing', NULL, '2', 'lampirkan bukti'),
(71, 19232566, '2025-06-20', 'Ijin', NULL, NULL, NULL, NULL, '2025-06-25', '07:00:00', '12:00:00', 'Pulang Cepat', 'lagi ada keperluan', NULL, '0', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenkel` enum('Laki-Laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` enum('Quality Control','Production Control','Painting','Casting','Machining','HR','Engineering','Finance') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` enum('Admin','Staff','Operator','Leader','Foreman','Supervisor','Assistant Manager','Manager') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_perkawinan` enum('Lajang','Menikah','Bercerai') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pekerja` enum('Kontrak','Tetap') COLLATE utf8mb4_unicode_ci NOT NULL,
  `join` date NOT NULL,
  `end` date NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '$2y$12$Bd66WDCcAj22TaiyURMatOvDuO0F.Gifhf.9zahm5A2yvfFech5AW',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `foto` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `face_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `face_descriptor` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama`, `jenkel`, `alamat`, `no_hp`, `department`, `jabatan`, `status_perkawinan`, `status_pekerja`, `join`, `end`, `password`, `created_at`, `updated_at`, `foto`, `face_image`, `face_descriptor`) VALUES
(19230018, 'Friska Rani Puspa', 'Perempuan', 'pasir koja', '081234567890', 'HR', 'Admin', 'Menikah', 'Kontrak', '2025-04-18', '2035-04-18', '$2y$12$suEhp83lULvO6kl1UvZHveM3pdupGzGlY5qywPLGI3/Hhm55mSatG', '2025-04-17 17:22:05', '2025-05-21 14:36:50', '19230018.png', '', NULL),
(19230386, 'Vanny Valisa', 'Perempuan', 'karawang', '080880', 'Painting', 'Staff', 'Lajang', 'Kontrak', '2024-08-07', '2025-12-24', '$2y$12$5iaavn2MMZGsYBJqJ19nh.VRj5TQc94kJL1JGK9aM38akd02eBvdO', '2025-04-18 01:39:05', '2025-04-18 07:31:58', '19230386.jpg', '', NULL),
(19230761, 'Dinda Setya Ningrum', 'Perempuan', 'karawang, jawa barat', '080880', 'Production Control', 'Operator', 'Lajang', 'Tetap', '2025-02-05', '2025-12-30', '$2y$12$Bd66WDCcAj22TaiyURMatOvDuO0F.Gifhf.9zahm5A2yvfFech5AW', NULL, NULL, '19230761.png', '', NULL),
(19230866, 'Abdul Rohman', 'Laki-Laki', 'purwakarta', '081310022580', 'Machining', 'Staff', 'Lajang', 'Tetap', '2025-02-05', '2025-10-09', '$2y$12$z8JbQv.XkLUQ8/SBNJfab.1La2yD6iLFJHwo1Iks1Mw8WFARqvk/.', NULL, '2025-05-20 11:44:24', '19230866.jpg', '', NULL),
(19231641, 'Harel Agung Nugroho', 'Laki-Laki', 'bintang alam, teluk jambe timur', '081310022580', 'HR', 'Admin', 'Menikah', 'Tetap', '2024-09-03', '2026-04-29', '$2y$12$EBKfPmwZfvUKcF/7ri.jiOWcwXow26uRis7ZeeRP5PYdvTVlExQG2', '2025-04-17 17:23:37', '2025-05-20 11:46:23', '19231641.jpg', '', NULL),
(19232029, 'Aulia Sekar', 'Perempuan', 'bandung', '080880', 'Quality Control', 'Foreman', 'Lajang', 'Tetap', '2025-02-05', '2025-09-17', '$2y$12$ZzSRAZSIHV2YSzsnn0ImseaCHgUVlpshkgzxWAs3LvXkgpbBFZdnW', NULL, '2025-05-22 11:00:01', '19232029.jpg', '', NULL),
(19232045, 'Fadilah Mardotilah', 'Laki-Laki', 'cikarang', '1231', 'Casting', 'Operator', 'Lajang', 'Kontrak', '2024-12-10', '2025-10-20', '$2y$12$Bd66WDCcAj22TaiyURMatOvDuO0F.Gifhf.9zahm5A2yvfFech5AW', NULL, NULL, '19232045.jpg', '', NULL),
(19232566, 'Muhammad Afan Restu Kurnia', 'Laki-Laki', 'karawang, jawa barat', '081310022580', 'Quality Control', 'Staff', 'Lajang', 'Tetap', '2025-04-03', '2025-11-24', '$2y$12$nDVT52nCGtF1g2ltUp/TZeNR7MLWzZ/ecxGAbSKDemtPRW6EBx4Sa', NULL, '2025-06-20 13:30:14', '19232566.jpg', '', NULL),
(19982121, 'Imron', 'Laki-Laki', 'bekasi', '085812345678', 'HR', 'Staff', 'Bercerai', 'Tetap', '2025-04-03', '2025-09-03', '$2y$12$Bd66WDCcAj22TaiyURMatOvDuO0F.Gifhf.9zahm5A2yvfFech5AW', NULL, NULL, '19982121.png', '', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` int NOT NULL,
  `lokasi_kantor` varchar(255) NOT NULL,
  `radius` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `lokasi_kantor`, `radius`) VALUES
(1, '-6.232324841882836, 106.82985834326703', 30);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_10_24_110805_create_table_karyawan', 1),
(5, '2025_04_18_000546_create_presensi_table', 1),
(6, '2025_04_18_104009_add_shift_column_to_presensi_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id` bigint UNSIGNED NOT NULL,
  `id_karyawan` int NOT NULL,
  `tgl_presensi` date NOT NULL,
  `shift` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_in` time DEFAULT NULL,
  `jam_out` time DEFAULT NULL,
  `foto_in` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_out` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi_in` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi_out` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id`, `id_karyawan`, `tgl_presensi`, `shift`, `jam_in`, `jam_out`, `foto_in`, `foto_out`, `lokasi_in`, `lokasi_out`, `created_at`, `updated_at`) VALUES
(8, 19231641, '2025-04-18', '1', '13:31:29', '13:53:45', '19231641-2025-04-18-in.png', '19231641-2025-04-18-out.png', '-6.3333561,107.325766', '-6.3333561,107.325766', '2025-04-18 06:31:29', '2025-04-18 06:53:45'),
(12, 19230018, '2025-04-18', '1', '13:59:04', NULL, '19230018-2025-04-18-in.png', NULL, '-6.3333561,107.325766', NULL, '2025-04-18 06:59:04', '2025-04-18 06:59:04'),
(13, 19230386, '2025-04-18', '1', '14:30:29', NULL, '19230386-2025-04-18-in.png', NULL, '-6.3333561,107.325766', NULL, '2025-04-18 07:30:29', '2025-04-18 07:30:29'),
(16, 19231641, '2025-04-20', '1', '06:01:39', '06:38:35', '19231641-2025-04-20-in.png', '19231641-2025-04-20-out.png', '-6.332416,107.3205929', '-6.332416,107.3205929', '2025-04-19 23:01:39', '2025-04-19 23:38:35'),
(17, 19232566, '2025-04-20', '1', '06:37:49', '06:38:12', '19232566-2025-04-20-in.png', '19232566-2025-04-20-out.png', '-6.332416,107.3205929', '-6.332416,107.3205929', '2025-04-19 23:37:49', '2025-04-19 23:38:13'),
(18, 19232029, '2025-04-20', '2', '16:34:39', '03:37:01', '19232029-2025-04-20-in.png', '19232029-2025-04-20-out.png', '-6.3333415,107.325027', '-6.3333415,107.325027', '2025-04-20 09:34:39', '2025-04-20 09:37:02'),
(19, 19231641, '2025-04-22', '2', '18:18:32', '20:11:23', '19231641-2025-04-22-in.png', '19231641-2025-04-22-out.png', '-6.3327829,107.325027', '-6.3327829,107.325027', '2025-04-22 11:18:32', '2025-04-22 13:11:23'),
(22, 19231641, '2025-04-27', '1', '09:23:36', '10:46:25', '19231641-2025-04-27-in.png', '19231641-2025-04-27-out.png', '-6.3333561,107.325766', '-6.3333561,107.325766', '2025-04-27 02:23:36', '2025-04-27 03:46:25'),
(23, 19230018, '2025-04-27', '1', '09:30:41', NULL, '19230018-2025-04-27-in.png', NULL, '-6.3333561,107.325766', NULL, '2025-04-27 02:30:41', '2025-04-27 02:30:41'),
(24, 19231641, '2025-05-04', '1', '06:41:41', '06:55:18', '19231641-2025-05-04-in.png', '19231641-2025-05-04-out.png', '-6.3333561,107.325766', '-6.3333561,107.325766', '2025-05-03 23:41:41', '2025-05-03 23:55:18'),
(25, 19230866, '2025-05-04', '1', '06:44:17', '21:06:37', '19230866-2025-05-04-in.png', '19230866-2025-05-04-out.png', '-6.3333561,107.325766', '-6.3333415,107.325027', '2025-05-03 23:44:17', '2025-05-04 14:06:37'),
(26, 19232029, '2025-05-04', '1', '06:44:49', NULL, '19232029-2025-05-04-in.png', NULL, '-6.3333561,107.325766', NULL, '2025-05-03 23:44:49', '2025-05-03 23:44:49'),
(27, 19230761, '2025-05-04', '1', '06:45:27', NULL, '19230761-2025-05-04-in.png', NULL, '-6.3333561,107.325766', NULL, '2025-05-03 23:45:27', '2025-05-03 23:45:27'),
(28, 19232045, '2025-05-04', '1', '06:45:53', NULL, '19232045-2025-05-04-in.png', NULL, '-6.3333561,107.325766', NULL, '2025-05-03 23:45:53', '2025-05-03 23:45:53'),
(29, 19230018, '2025-05-04', '1', '06:46:19', '12:57:36', '19230018-2025-05-04-in.png', '19230018-2025-05-04-out.png', '-6.3333561,107.325766', '-6.3333561,107.325766', '2025-05-03 23:46:19', '2025-05-04 05:57:36'),
(30, 19982121, '2025-05-04', '2', '21:07:58', '23:09:22', '19982121-2025-05-04-in.png', '19982121-2025-05-04-out.png', '-6.3333415,107.325027', '-6.3333415,107.325027', '2025-05-04 14:07:58', '2025-05-04 14:09:23'),
(31, 19231641, '2025-05-10', '1', '06:06:47', '10:48:47', '19231641-2025-05-10-in.png', '19231641-2025-05-10-out.png', '-6.3315582,107.3205929', '-6.3340544,107.347968', '2025-05-09 23:06:47', '2025-05-10 03:48:47'),
(32, 19230018, '2025-05-10', '1', '06:19:17', '08:05:33', '19230018-2025-05-10-in.png', '19230018-2025-05-10-out.png', '-6.3315582,107.3205929', '-6.3315582,107.3205929', '2025-05-09 23:19:17', '2025-05-10 01:05:33'),
(33, 19232029, '2025-05-10', '1', '06:33:05', NULL, '19232029-2025-05-10-in.png', NULL, '-6.3315582,107.3205929', NULL, '2025-05-09 23:33:05', '2025-05-09 23:33:05'),
(34, 19232566, '2025-05-11', '1', '06:20:05', NULL, '19232566-2025-05-11-in.png', NULL, '-6.3333521,107.323549', NULL, '2025-05-10 23:20:05', '2025-05-10 23:20:05'),
(36, 19231641, '2025-05-12', '1', '06:20:59', NULL, '19231641-2025-05-12-in.png', NULL, '-6.3327454,107.3227391', NULL, '2025-05-11 23:20:59', '2025-05-11 23:20:59'),
(37, 19230761, '2025-05-12', '1', '06:22:38', NULL, '19230761-2025-05-12-in.png', NULL, '-6.3333561,107.325766', NULL, '2025-05-11 23:22:39', '2025-05-11 23:22:39'),
(38, 19982121, '2025-05-12', '1', '06:23:22', NULL, '19982121-2025-05-12-in.png', NULL, '-6.3333561,107.325766', NULL, '2025-05-11 23:23:22', '2025-05-11 23:23:22'),
(39, 19231641, '2025-05-17', '2', '17:25:38', NULL, '19231641-2025-05-17-in.png', NULL, '-6.3333561,107.325766', NULL, '2025-05-17 10:25:38', '2025-05-17 10:25:38'),
(40, 19231641, '2025-05-18', '1', '09:35:47', '09:35:49', '19231641-2025-05-18-in.png', '19231641-2025-05-18-out.png', '-6.3333561,107.325766', '-6.3333561,107.325766', '2025-05-18 02:35:48', '2025-05-18 02:35:50'),
(41, 19231641, '2025-05-20', '2', '17:11:22', '17:11:34', '19231641-2025-05-20-in.png', '19231641-2025-05-20-out.png', '-6.3333561,107.325766', '-6.3333561,107.325766', '2025-05-20 10:11:22', '2025-05-20 10:11:34'),
(42, 19231641, '2025-05-22', '2', '17:11:47', '17:58:34', '19231641-2025-05-22-in.png', '19231641-2025-05-22-out.png', '-6.3333561,107.325766', '-6.3333561,107.325766', '2025-05-22 10:11:48', '2025-05-22 10:58:34'),
(43, 19231641, '2025-06-11', '2', '20:43:59', NULL, '19231641-2025-06-11-in.png', NULL, '-6.3327673,107.32275', NULL, '2025-06-11 13:44:00', '2025-06-11 13:44:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2025-04-17 17:22:05', '$2y$12$7lDH8ot/lSyiTZlLjJn5GeBNh0hZfParzExGx2RuVzahGIwPoeSfy', 'qaQSp4lqMr', '2025-04-17 17:22:05', '2025-04-17 17:22:05');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `formulir`
--
ALTER TABLE `formulir`
  ADD PRIMARY KEY (`id_formulir`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indeks untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `formulir`
--
ALTER TABLE `formulir`
  MODIFY `id_formulir` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id_lokasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
