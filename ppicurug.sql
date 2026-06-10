-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2026 at 07:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppicurug`
--

-- --------------------------------------------------------

--
-- Table structure for table `acara`
--

CREATE TABLE `acara` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_acara` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acara`
--

INSERT INTO `acara` (`id`, `nama_acara`, `tanggal`, `jam`, `keterangan`, `created_at`, `updated_at`) VALUES
(3, 'Kuliah Umum elektornika', '2026-06-27', '14:56:00', NULL, '2026-06-09 00:59:55', '2026-06-09 00:59:55'),
(4, 'Google Development On Campus', '2026-06-15', '04:30:00', 'Kegiatan Google Development On Campus', '2026-06-09 19:57:35', '2026-06-09 19:57:35');

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `modul` varchar(255) NOT NULL,
  `aksi` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`detail`)),
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `user_name`, `user_role`, `modul`, `aksi`, `deskripsi`, `detail`, `subject_type`, `subject_id`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 2, 'Penyelenggara', 'penyelenggara', 'poin', 'tambah', 'Tambah poin Prestasi untuk Selma Shakila Andyana Putri (NPM: 2322101976) — Kegiatan: k, Nilai: 1', '{\"npm\":\"2322101976\",\"nama_mahasiswa\":\"Selma Shakila Andyana Putri\",\"kelas\":\"2 RPLK\",\"kategori\":\"prestasi\",\"kegiatan\":\"k\",\"nilai\":1,\"tanggal\":\"2026-06-09\",\"pengasuh\":\"nufri\"}', 'App\\Models\\PoinMahasiswa', 1, '127.0.0.1', '2026-06-08 21:11:18', '2026-06-08 21:11:18'),
(2, 2, 'Penyelenggara', 'penyelenggara', 'poin', 'tambah', 'Tambah poin Prestasi untuk Justin Wismar Tobing (NPM: 2423102038) — Kegiatan: Lomba Scrable, Nilai: 3', '{\"npm\":\"2423102038\",\"nama_mahasiswa\":\"Justin Wismar Tobing\",\"kelas\":\"2 RPLK\",\"kategori\":\"prestasi\",\"kegiatan\":\"Lomba Scrable\",\"nilai\":3,\"tanggal\":\"2026-06-09\",\"pengasuh\":\"Hadyan\"}', 'App\\Models\\PoinMahasiswa', 2, '127.0.0.1', '2026-06-08 21:50:05', '2026-06-08 21:50:05'),
(3, NULL, 'Pengasuh', 'pengasuh', 'poin', 'tambah', 'Tambah poin Pelanggaran untuk Justin Wismar Tobing (NPM: 2423102038) — Kegiatan: Jam Malam, Nilai: 1', '{\"npm\":\"2423102038\",\"nama_mahasiswa\":\"Justin Wismar Tobing\",\"kelas\":\"2 RPLK\",\"kategori\":\"pelanggaran\",\"kegiatan\":\"Jam Malam\",\"nilai\":1,\"tanggal\":\"2026-06-08\",\"pengasuh\":\"Hadyan\"}', 'App\\Models\\PoinMahasiswa', 3, '127.0.0.1', '2026-06-08 21:51:42', '2026-06-08 21:51:42'),
(4, 110, 'Imas Purbasari', 'pengasuh', 'acara', 'buat', 'Buat acara baru: \"Kuliah Umum elektornika\" pada 27/06/2026 pukul 14:56', '{\"nama_acara\":\"Kuliah Umum elektornika\",\"tanggal\":\"2026-06-27\",\"jam\":\"14:56\",\"keterangan\":null}', 'App\\Models\\Acara', 3, '127.0.0.1', '2026-06-09 00:59:55', '2026-06-09 00:59:55'),
(5, 110, 'Imas Purbasari', 'pengasuh', 'acara', 'hapus', 'Hapus acara \"Kuliah Umum elektornika\" yang dijadwalkan pada 27/06/2026 pukul 14:56:00', '{\"nama_acara\":\"Kuliah Umum elektornika\",\"tanggal\":\"2026-06-27\",\"jam\":\"14:56:00\",\"keterangan\":null}', 'App\\Models\\Acara', 1, '127.0.0.1', '2026-06-09 01:00:10', '2026-06-09 01:00:10'),
(6, 110, 'Imas Purbasari', 'pengasuh', 'acara', 'hapus', 'Hapus acara \"Kuliah Umum elektornika\" yang dijadwalkan pada 27/06/2026 pukul 14:56:00', '{\"nama_acara\":\"Kuliah Umum elektornika\",\"tanggal\":\"2026-06-27\",\"jam\":\"14:56:00\",\"keterangan\":null}', 'App\\Models\\Acara', 2, '127.0.0.1', '2026-06-09 01:00:13', '2026-06-09 01:00:13'),
(7, 110, 'Imas Purbasari', 'pengasuh', 'surat', 'buat', 'Buat surat baru: \"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 “Mobile App and Web  Session”\" (Surat Proposal) dari Biro Siber kepada Pengasuhan', '{\"nomor_surat\":\"SENKORPSTAR\\/D41.007\\/PH.068\\/KM.05.03\\/IV\\/2026\",\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 \\u201cMobile App and Web  Session\\u201d\",\"pengirim\":\"Biro Siber\",\"penerima\":\"Pengasuhan\",\"tanggal_surat\":\"2026-04-23\",\"status\":\"Diproses\"}', 'App\\Models\\Surat', 1, '127.0.0.1', '2026-06-09 01:05:38', '2026-06-09 01:05:38'),
(8, 2, 'Penyelenggara', 'penyelenggara', 'acara', 'buat', 'Buat acara baru: \"Google Development On Campus\" pada 15/06/2026 pukul 04:30', '{\"nama_acara\":\"Google Development On Campus\",\"tanggal\":\"2026-06-15\",\"jam\":\"04:30\",\"keterangan\":\"Kegiatan Google Development On Campus\"}', 'App\\Models\\Acara', 4, '127.0.0.1', '2026-06-09 19:57:35', '2026-06-09 19:57:35'),
(9, 114, 'Arif Bagus Albudin', 'pengasuh', 'surat', 'ubah', 'Ubah surat \"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 “Mobile App and Web  Session”\"', '{\"nomor_surat\":\"SENKORPSTAR\\/D41.007\\/PH.068\\/KM.05.03\\/IV\\/2026\",\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 \\u201cMobile App and Web  Session\\u201d\",\"pengirim\":\"Biro Siber\",\"penerima\":\"Pengasuhan\",\"status_lama\":\"Diproses\",\"status_baru\":\"Diproses\"}', 'App\\Models\\Surat', 1, '127.0.0.1', '2026-06-09 20:01:54', '2026-06-09 20:01:54'),
(10, 2, 'Penyelenggara', 'penyelenggara', 'surat', 'ubah', 'Ubah surat \"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 “Mobile App and Web  Session”\"', '{\"nomor_surat\":\"SENKORPSTAR\\/D41.007\\/PH.068\\/KM.05.03\\/IV\\/2026\",\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 \\u201cMobile App and Web  Session\\u201d\",\"pengirim\":\"Biro Siber\",\"penerima\":\"Pengasuhan\",\"status_lama\":\"Diproses\",\"status_baru\":\"Diproses\"}', 'App\\Models\\Surat', 1, '127.0.0.1', '2026-06-09 20:03:28', '2026-06-09 20:03:28'),
(11, 2, 'Penyelenggara', 'penyelenggara', 'surat', 'ubah', 'Ubah surat \"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 “Mobile App and Web  Session”\"', '{\"nomor_surat\":\"SENKORPSTAR\\/D41.007\\/PH.068\\/KM.05.03\\/IV\\/2026\",\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 \\u201cMobile App and Web  Session\\u201d\",\"pengirim\":\"Biro Siber\",\"penerima\":\"Pengasuhan\",\"status_lama\":\"Diproses\",\"status_baru\":\"Diproses\"}', 'App\\Models\\Surat', 1, '127.0.0.1', '2026-06-09 20:03:38', '2026-06-09 20:03:38'),
(12, 114, 'Arif Bagus Albudin', 'pengasuh', 'surat', 'buat', 'Buat surat baru: \"Permohonan Izin Mengikuti Acara Build with  AI x JuaraVibeCoding: Breaking Limits, Building  Impact\" (Surat Proposal) dari Biro Siber kepada Pengasuhan', '{\"nomor_surat\":\"SENKORPSTAR\\/D41.009\\/PH.095\\/KM.05.03\\/V\\/2026\",\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara Build with  AI x JuaraVibeCoding: Breaking Limits, Building  Impact\",\"pengirim\":\"Biro Siber\",\"penerima\":\"Pengasuhan\",\"tanggal_surat\":\"2026-06-08\",\"status\":\"Diproses\"}', 'App\\Models\\Surat', 2, '127.0.0.1', '2026-06-09 20:11:24', '2026-06-09 20:11:24'),
(13, 2, 'Penyelenggara', 'penyelenggara', 'surat', 'setujui', 'Ubah status surat \"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 “Mobile App and Web  Session”\": Diproses → Disetujui', '{\"nomor_surat\":\"SENKORPSTAR\\/D41.007\\/PH.068\\/KM.05.03\\/IV\\/2026\",\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 \\u201cMobile App and Web  Session\\u201d\",\"pengirim\":\"Biro Siber\",\"penerima\":\"Pengasuhan\",\"status_lama\":\"Diproses\",\"status_baru\":\"Disetujui\"}', 'App\\Models\\Surat', 1, '127.0.0.1', '2026-06-09 20:11:51', '2026-06-09 20:11:51');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_03_09_032828_create_poin_mahasiswa_table', 1),
(6, '2026_03_09_130556_create_acara_table', 1),
(7, '2026_03_10_030000_create_surat_table', 1),
(8, '2026_03_10_040000_add_profile_fields_to_users_table', 1),
(9, '2026_05_10_000001_add_role_to_users_table', 1),
(10, '2026_06_01_000000_create_activity_logs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poin_mahasiswa`
--

CREATE TABLE `poin_mahasiswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `npm` varchar(20) NOT NULL,
  `nama_mahasiswa` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `kategori` enum('prestasi','pelanggaran') NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `nilai` int(11) NOT NULL,
  `pengasuh` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `poin_mahasiswa`
--

INSERT INTO `poin_mahasiswa` (`id`, `npm`, `nama_mahasiswa`, `kelas`, `kategori`, `kegiatan`, `tanggal`, `nilai`, `pengasuh`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, '2322101976', 'Selma Shakila Andyana Putri', '2 RPLK', 'prestasi', 'k', '2026-06-09', 1, 'nufri', 'kh', '2026-06-08 21:11:18', '2026-06-08 21:11:18'),
(2, '2423102038', 'Justin Wismar Tobing', '2 RPLK', 'prestasi', 'Lomba Scrable', '2026-06-09', 3, 'Hadyan', 'Menang lomba juara 1 scrable', '2026-06-08 21:50:05', '2026-06-08 21:50:05'),
(3, '2423102038', 'Justin Wismar Tobing', '2 RPLK', 'pelanggaran', 'Jam Malam', '2026-06-08', 1, 'Hadyan', 'Melanggar Jam Malam beraktivitas lebih dari jam 10', '2026-06-08 21:51:42', '2026-06-08 21:51:42');

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_surat` varchar(255) DEFAULT NULL,
  `jenis_surat` enum('Surat Proposal','Surat Izin','Surat Permohonan','Surat Keterangan','Surat Undangan','Surat Tugas','Surat Lainnya') NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `pengirim` varchar(255) NOT NULL,
  `penerima` varchar(255) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `tanggal_terima` date DEFAULT NULL,
  `status` enum('Diproses','Disetujui','Ditolak','Selesai') NOT NULL DEFAULT 'Diproses',
  `keterangan` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id`, `nomor_surat`, `jenis_surat`, `perihal`, `pengirim`, `penerima`, `tanggal_surat`, `tanggal_terima`, `status`, `keterangan`, `file_path`, `created_at`, `updated_at`) VALUES
(1, 'SENKORPSTAR/D41.007/PH.068/KM.05.03/IV/2026', 'Surat Proposal', 'Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 “Mobile App and Web  Session”', 'Biro Siber', 'Pengasuhan', '2026-04-23', '2026-06-10', 'Disetujui', 'Surat proposal pengajuan kegiatan GDGOC', 'surat/hfdgGpcIJxk5X2zt29MaytlNsMGmPRhmRe8XfPZ4.pdf', '2026-06-09 01:05:38', '2026-06-09 20:11:51'),
(2, 'SENKORPSTAR/D41.009/PH.095/KM.05.03/V/2026', 'Surat Proposal', 'Permohonan Izin Mengikuti Acara Build with  AI x JuaraVibeCoding: Breaking Limits, Building  Impact', 'Biro Siber', 'Pengasuhan', '2026-06-08', NULL, 'Diproses', 'Kegiatan GDGOC di Binus Alsut', 'surat/xddBPZg5yQEKlKl6G1jWBQkkkb2ngTvVdtTE0RKq.pdf', '2026-06-09 20:11:24', '2026-06-09 20:11:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `nama_panggilan` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'taruna',
  `no_telepon` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `nama_panggilan`, `email`, `role`, `no_telepon`, `jabatan`, `foto`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Satsuh', NULL, NULL, 'satsuh@ppicurug.ac.id', 'taruna', NULL, NULL, NULL, NULL, '$2y$12$kPusElN3Dts6MBXvZqhLQ.xDfnwUA8ic1i3HNzzMnLB72jloAVzpG', NULL, '2026-06-08 01:16:50', '2026-06-08 01:16:50'),
(2, 'Penyelenggara', 'penyelenggara', NULL, 'penyelenggara@poltekssn.ac.id', 'penyelenggara', NULL, 'Penyelenggara Pengasuhan', NULL, NULL, '$2y$12$CgGxZx/YFUG5w6rSOI9skeIW7MwSNQVs4qAZ4YF9Acih0cZBOGhgG', 'yzgJfR8uaKvEDNXLnApXM8R3ronL1xejSkzus4FlNwZ4n3c3YFt4Htw3HFK0', '2026-06-08 01:16:51', '2026-06-08 01:16:51'),
(4, 'Taruna Demo', 'taruna', NULL, 'taruna@poltekssn.ac.id', 'taruna', NULL, 'Taruna', NULL, NULL, '$2y$12$/lKVElrtij97q.Et0B4R6OQ/78CnNoKdjxYLH2c9YGO5ecLYER7wu', NULL, '2026-06-08 01:16:52', '2026-06-08 01:16:52'),
(5, 'Selma Shakila Andyana Putri', 'akila', 'Akila', 'selma.shakila@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$zRrCDFQAgs7GavalmvuyxOLUih8wIlGsJtLieMS0lCIMwkIiKdlty', NULL, '2026-06-08 01:16:54', '2026-06-08 01:16:54'),
(6, 'Achmad Fatih Binasiilah', 'fatih', 'Fatih', 'achmad.fatih@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$LHaRZfeOceMM8PG.hxm/e.ZOoDgBRN.VmRPNS4Hernb56Wnjvh6MS', NULL, '2026-06-08 01:16:54', '2026-06-08 01:16:54'),
(7, 'Ahmad Muflih Izfatara', 'muflih', 'Muflih', 'ahmad.muflih@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$gOajaRbhTuI.4BS2JuVOVuCNoUkzSpHnYKeUj..TphJgYhvxsta4i', NULL, '2026-06-08 01:16:55', '2026-06-08 01:16:55'),
(8, 'Boyke Charish Situmeang', 'boy', 'Boy', 'boyke.charish@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$cA/Hi0yiAWm7zS6KBnIBxe16LkPChV6mFo7MTFVHnY1G7pb9gF2i2', NULL, '2026-06-08 01:16:55', '2026-06-08 01:16:55'),
(9, 'Dini Riyani Oktavia', 'tavi', 'Tavi', 'dini.riyani@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$gDtVNf5H3Xe43.OaTdmC3.mHHYk6KBw8UE9M6ayoLFNwN8QFSxPfu', NULL, '2026-06-08 01:16:56', '2026-06-08 01:16:56'),
(10, 'Donny Rusdianysah', 'rusdi', 'Rusdi', 'donny.rusdianysah@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$03vUyE6G45a07J2g576JSe8lp0sO3.4OSdy4bbdpLs9O8V4q7jcJK', NULL, '2026-06-08 01:16:56', '2026-06-08 01:16:56'),
(11, 'Farhan Regian Cahya Muharam', 'aram', 'Aram', 'farhan.regian@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$XXaLTYIYX7gw79iUcJCJRuttHAyykXdYJTYqhN7qpe6Y4EdL5.FN.', NULL, '2026-06-08 01:16:56', '2026-06-08 01:16:56'),
(12, 'Farid Ali Wafi', 'alwa', 'Alwa', 'farid.ali@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$qgqqmjdD.hgfQV3IFoyRMuJz.OoKR543MpMnPTfIcBgLonHnz1As2', NULL, '2026-06-08 01:16:57', '2026-06-08 01:16:57'),
(13, 'Fathan Mawla Itzwa', 'fathan', 'Fathan', 'fathan.mawla@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$TA1sqmUUddiereQwvcakk.zPGCac5p3x6Uipe9udOl4bZoLUgSS4e', NULL, '2026-06-08 01:16:57', '2026-06-08 01:16:57'),
(14, 'Hany Mahsa Lysandra Tarigan', 'lysa', 'Lysa', 'hany.mahsa@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$Yj6EtEKsCKmA3CwlQxZjX.61ETPLAT2atQPwzWXvmk7ijqFCmf5aO', NULL, '2026-06-08 01:16:58', '2026-06-08 01:16:58'),
(15, 'Jonathan Kevin Binsar Pangaribuan', 'joke', 'Joke', 'jonathan.kevin@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$M9ERhVHMTRUXb6p.BaGeSOeBDaIAx5CsBOp5kNBh28FNoz6tzCBly', NULL, '2026-06-08 01:16:58', '2026-06-08 01:16:58'),
(16, 'Justin Wismar Tobing', 'justin', 'Justin', 'justin.wismar@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$dsCDC4kGPHQBMIeWATa8N.iPaKcnlUyU0TcBQ/tDh.pCFIU4LH.0O', NULL, '2026-06-08 01:16:58', '2026-06-08 01:16:58'),
(17, 'Marsantya Haleza Mawa', 'haleza', 'Haleza', 'marsantya.haleza@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$uVp9tYvlnFHqDdqVGXMb4.BKBiIBwDmIBajZESq6QbjMnwx7eTl1K', NULL, '2026-06-08 01:16:59', '2026-06-08 01:16:59'),
(18, 'Marsya Tsabitah Yustin', 'marsya', 'Marsya', 'marsya.tsabitah@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$OUPdFrnLGkzdUr/q8BNAZOsmtpizBogHMg5KYVZ5996vz1Fn7rOQC', NULL, '2026-06-08 01:16:59', '2026-06-08 01:16:59'),
(19, 'Muhammad Amirul Haqa Ardi', 'haqa', 'Haqa', 'muhammad.amirul@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$dhiwAp3uhHctthXDOBDDP.Tc1SG4jjxQnOi/aoX9FKv./UE/ldJu6', NULL, '2026-06-08 01:17:00', '2026-06-08 01:17:00'),
(20, 'Mutiara Cahyaning Utami', 'aya', 'Aya', 'mutiara.cahyaning@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$jzcQCSPsRnGcIH7m3NDk8uyCf7xTXQvc9d4qQ/lPtA5IoxMRRVldy', NULL, '2026-06-08 01:17:00', '2026-06-08 01:17:00'),
(21, 'Nufri Rafif', 'nufri', 'Nufri', 'nufri.rafif@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$JFRxCEeBjAuUgqCP0ehUAOxLftHxdUklXQepXkP0fYeF0KVkqWiC.', NULL, '2026-06-08 01:17:01', '2026-06-08 01:17:01'),
(22, 'Rezen Kova Renita Pratama', 'rezen', 'Rezen', 'rezen.kova@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$tGiI/4Tv.cUPN.EqlQFekeUfu.HA9r5yeF/VUBrG2bSzk3qOieYNC', NULL, '2026-06-08 01:17:01', '2026-06-08 01:17:01'),
(23, 'Ruben Gabe Aditya Panjaitan', 'ruben', 'Ruben', 'ruben.gabe@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$w.3CwF/RIgH5tSQ8aWObredKGY/KXnCmlqXCpSMOuo8M3PPHrWqOK', NULL, '2026-06-08 01:17:01', '2026-06-08 01:17:01'),
(24, 'Salsabila Syifa Farah Febrina', 'farah', 'Farah', 'salsabila.syifa@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$ehqhO5exa64rgBN966ddp.vF2zMF/bttr2eOArc.t3x9GgODIfYGK', NULL, '2026-06-08 01:17:02', '2026-06-08 01:17:02'),
(25, 'Zefanya Raditya Pratama', 'zefa', 'Zefa', 'zefanya.raditya@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$z4hfcBk2OM7zofb5QAoSD.BrYkM9M64UA0RBDbFXW7v2hMR4IH2PK', NULL, '2026-06-08 01:17:02', '2026-06-08 01:17:02'),
(26, 'Zhafran Riko Santoso', 'zhafran', 'Zhafran', 'zhafran.riko@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPLK', NULL, NULL, '$2y$12$opL25gKY9tXuqn9woc5VVOye/rb.7IzQIDgZTpXXFQj4gfXDY8om.', NULL, '2026-06-08 01:17:03', '2026-06-08 01:17:03'),
(27, 'Adam Raihan Prasedya', 'edya', 'Edya', 'adam.raihan@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$NBQgAGHzyfz2xOqPtff5u.aaoDVb/jy1tqBMWwZkfRlnsnfaujhiq', NULL, '2026-06-08 01:17:03', '2026-06-08 01:17:03'),
(28, 'Ahmad Ghani Nurkhadian', 'marnat', 'Marnat', 'ahmad.ghani@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$O8N8zTnIBJ/bciC5EjQ2Veqi2atRIsU0bLB92ipFrJSOa72i6TZxm', NULL, '2026-06-08 01:17:03', '2026-06-08 01:17:03'),
(29, 'Aiko Senyum Indra Nugraha', 'aiko', 'Aiko', 'aiko.senyum@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$c3NRsPxyBi35F6nyvufCGOzPgBQcZ5P0liCeWoVoOD/a3SuhmLZOS', NULL, '2026-06-08 01:17:04', '2026-06-08 01:17:04'),
(30, 'Aqilah Putri Meylani S', 'meyla', 'Meyla', 'aqilah.putri@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$gGnUfGJJVmiUJsFkwusD2OJOYiW4BBxbEnD3vmjh6WmqIMJq9wB4C', NULL, '2026-06-08 01:17:04', '2026-06-08 01:17:04'),
(31, 'Dimas Ardiyansyah', 'masdim', 'Masdim', 'dimas.ardiyansyah@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$HQ6XL0TzOBbcfvEI8kh4p.nIXC/wkP1vYJJadWMYGKO9HPu3GAbsm', NULL, '2026-06-08 01:17:05', '2026-06-08 01:17:05'),
(32, 'Edra Fernanda', 'eder', 'Eder', 'edra.fernanda@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$/zAABb4waNo/lHnJNTrQq.KZ3Vpof5pvMIJllwKo6.TNxhiD5ICYu', NULL, '2026-06-08 01:17:05', '2026-06-08 01:17:05'),
(33, 'Helza Aura Ferdani', 'helza', 'Helza', 'helza.aura@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$7kuRSGT9/Ic8Y7SRHGCF/eXVT/ZJ2ky06QMEW9DCtzRcnFR9ijf0S', NULL, '2026-06-08 01:17:05', '2026-06-08 01:17:05'),
(34, 'Ida Ayu Mas Putri Kemala Dewi', 'dayu', 'Dayu', 'ida.ayu@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$Er7RgwNuCV7/QrpBV83xU.fHVJE7n98moUU9Mkcnqi5VDmdTbUoi.', NULL, '2026-06-08 01:17:06', '2026-06-08 01:17:06'),
(35, 'Muhammad Fauzil Fadhil', 'uzil', 'Uzil', 'muhammad.fauzil@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$hXMI/D2242F2DvGmI0QiweAVE4/F3vor0c35LGtCRK3OtHRt7UYoW', NULL, '2026-06-08 01:17:06', '2026-06-08 01:17:06'),
(36, 'Ni Made Dwi Armalayanti', 'mala', 'Mala', 'ni.made@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$8IiSpa8TS8T9Xg5RWE//..S7DeVVeWnCx.KHPlq1tW5CJ9.ElZJqi', NULL, '2026-06-08 01:17:07', '2026-06-08 01:17:07'),
(37, 'Rafa Shafaudin Athaillah', 'udin', 'Udin', 'rafa.shafaudin@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$tZFaOCqAEsFEXOqXlCquQu2XkZWJXCKf.xD/EeGQt6AlzaAm4PreC', NULL, '2026-06-08 01:17:07', '2026-06-08 01:17:07'),
(38, 'Raffi Anantha Setiawan', 'anan', 'Anan', 'raffi.anantha@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$eoXQ2y2YEld9cupKumY0Xuk/pDxCxagdhCUpnUWDuqLUSpD7Zywcu', NULL, '2026-06-08 01:17:07', '2026-06-08 01:17:07'),
(39, 'Rahma Bima Algestiyano', 'alge', 'Alge', 'rahma.bima@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$9QHvnAj1ZYiZgs6hi63N.uTSmpsMzMpRw7ywbbDfOuBmU8kCXfBH2', NULL, '2026-06-08 01:17:08', '2026-06-08 01:17:08'),
(40, 'Rangga Firman Syarif', 'rf', 'RF', 'rangga.firman@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$ii.Z8PkUZiHm/nwRyXajDuOcXa5wa3XJj4PMxCmgP2SbYODaAXgV2', NULL, '2026-06-08 01:17:08', '2026-06-08 01:17:08'),
(41, 'Rizky Zakariya', 'riza', 'Riza', 'rizky.zakariya@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$rmpAvyYkpvnLkVhYC4gViefNvjyquLzXY1MKBazxtA7zjApjnwmQm', NULL, '2026-06-08 01:17:09', '2026-06-08 01:17:09'),
(42, 'Septian Izya Pradana', 'ayzi', 'Ayzi', 'septian.izya@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$wLD9p0l7M7mfc1c9b28UDeD9tGRwkAuidWljAZu.UUFPvy6vouf3y', NULL, '2026-06-08 01:17:09', '2026-06-08 01:17:09'),
(43, 'Septian Trio Laksana', 'trio', 'Trio', 'septian.trio@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$obo2doewRKFmarEQBvXGze/LINCHPogTwF3Ia2GS6k0nXuOUcUxcO', NULL, '2026-06-08 01:17:10', '2026-06-08 01:17:10'),
(44, 'Stevent Imanuel Ginting', 'nuel', 'Nuel', 'stevent.imanuel@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$gjxGTSwdbz1ghjtytdoRm.ssKcn48Y0ydgj7g6yMBcg/qHs97pq5K', NULL, '2026-06-08 01:17:10', '2026-06-08 01:17:10'),
(45, 'Syifa Maulia Fadila', 'syifa', 'Syifa', 'syifa.maulia@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$dCm/MrclW68vyE4wxH63y.9LzgSX/OTVNH320fzglZzLfuCHxgfJq', NULL, '2026-06-08 01:17:10', '2026-06-08 01:17:10'),
(46, 'Viki Maulana', 'kipli', 'Kipli', 'viki.maulana@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$7i/OgFJuOEAYtSfN2YQTQuXpYHvHHdIROJksV.ZBZGQwKnQXJLaxO', NULL, '2026-06-08 01:17:11', '2026-06-08 01:17:11'),
(47, 'Zamir Achmad Sachio', 'chio', 'Chio', 'zamir.achmad@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RPKK', NULL, NULL, '$2y$12$vZRRKHjEmj8rBRhl/YPYie862pXP66K/InigP7slF8KHRpybZZC0a', NULL, '2026-06-08 01:17:11', '2026-06-08 01:17:11'),
(48, 'Althaf Bilal Jubran', 'althaf', 'Althaf', 'althaf.bilal@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$fJ67vyVwWVVTcuwkEnRkvuBcdaPpAx5O4G3iozdrrgj.2UsgEQBJS', NULL, '2026-06-08 01:17:11', '2026-06-08 01:17:11'),
(49, 'Alyaa Mahiraah Ramadhani', 'hira', 'Hira', 'alyaa.mahiraah@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$fTxmQhDvMSmoZnDNPmMbVukRPOEwZP1aTyK2YIjlWhUrwmk4uF2v.', NULL, '2026-06-08 01:17:12', '2026-06-08 01:17:12'),
(50, 'Asyifa Alya Nabila', 'ayla', 'Ayla', 'asyifa.alya@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$hy.awd6OIolwTh6dCCJu0OgmVqt2VBzxVjuQYXJEI//BugWdjMLa2', NULL, '2026-06-08 01:17:12', '2026-06-08 01:17:12'),
(51, 'Daffa Zaidan Eto\'o', 'etoo', 'Etoo', 'daffa.zaidan@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$ua3GKbYJ.EPv0bu5Dh21x.WY9cTMlxVM/ptQTApwdvnNoygc14Phu', NULL, '2026-06-08 01:17:13', '2026-06-08 01:17:13'),
(52, 'Damar', 'damar', 'Damar', 'damar@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$O6NArC1LOsgKQoleTnQMAOvuDna9mLdNysUD8fcTKNRhL9./.VpWy', NULL, '2026-06-08 01:17:13', '2026-06-08 01:17:13'),
(53, 'Dava Anugrah Putra', 'bob', 'Bob', 'dava.anugrah@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$yNX.YoAsOMJ8yXl9cTDJsO/mcPOyIG4fkwnRR7PRaL9hBmBy7SBya', NULL, '2026-06-08 01:17:13', '2026-06-08 01:17:13'),
(54, 'Dimas Surya Pratama', 'dimsur', 'Dimsur', 'dimas.surya@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$JYrQuEBzd7y8thSkhxIXKOGLo5fdtK3WpD9oIKpe5C8SGleBL0aQi', NULL, '2026-06-08 01:17:14', '2026-06-08 01:17:14'),
(55, 'Falito Eriano Nainggolan', 'lito', 'Lito', 'falito.eriano@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$LoCsxD4Jb/0sFoHsbc674e2Hl4AL2T49Kg1f2XICscTI9UkUxkyDi', NULL, '2026-06-08 01:17:14', '2026-06-08 01:17:14'),
(56, 'Gita Olivia Silaban', 'ivi', 'Ivi', 'gita.olivia@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$FIP/1c.TV/uVI4g1KQ2JquIXm9JgFXwHFS3Knzc6UBKzq4BQHZTHq', NULL, '2026-06-08 01:17:15', '2026-06-08 01:17:15'),
(57, 'Hinggil Parahita', 'hinggil', 'Hinggil', 'hinggil.parahita@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$hRHcVWUrgGWUaO.B3kgCQO/f3cv0/q5s2dUeqWAn7.6N2N0pznLYe', NULL, '2026-06-08 01:17:15', '2026-06-08 01:17:15'),
(58, 'Luklu Miranda', 'luklu', 'Luklu', 'luklu.miranda@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$aJ8Ky3gh9UYXt4a2vz5R/uySXfGfHVv932bHjn6IqKmA/2EVTc3cu', NULL, '2026-06-08 01:17:16', '2026-06-08 01:17:16'),
(59, 'Muhammad Agung Nafsi Aminullah', 'nafsi', 'Nafsi', 'muhammad.agung@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$6UWRBDpiXmFyPqKY56NV4Os4qgEWypu4ITMqYvZMqZMGf9NVujO7K', NULL, '2026-06-08 01:17:16', '2026-06-08 01:17:16'),
(60, 'Muhammad Reza Al Ichwan', 'al', 'Al', 'muhammad.reza@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$2xcNsQAoEu5du0O3wD0OIOed6B1r72i6K3Guw9yh7PulWE2lxqlL2', NULL, '2026-06-08 01:17:16', '2026-06-08 01:17:16'),
(61, 'Mukhammad Rizal Maulana', 'lana', 'Lana', 'mukhammad.rizal@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$idcZR346bcpj.qjh.SEyLu0p9pvuXs/axbu825U1lmAftl7TbvrLO', NULL, '2026-06-08 01:17:17', '2026-06-08 01:17:17'),
(62, 'Raffelino Hizkia Marbun', 'lino', 'Lino', 'raffelino.hizkia@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$s7o3Q5bUgl/29i4ZKq8Lo.3AjuG./qSh1lclux0UZGQ.TrBLGlKEG', NULL, '2026-06-08 01:17:17', '2026-06-08 01:17:17'),
(63, 'Rahadian Ronggo Kusumo', 'goku', 'Goku', 'rahadian.ronggo@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$HrQoAqCC03igsp88xIOxd.szVOYWTsRYGOIB6o4UjW5L1cYIHvfTK', NULL, '2026-06-08 01:17:18', '2026-06-08 01:17:18'),
(64, 'Reiza Gerrard Rizki Ramadhan', 'gerrard', 'Gerrard', 'reiza.gerrard@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$Tb.MHYxIECAVkd0d4PkfSO72OkuNmNhqbafT3EbZuyRUcjqw2IlX.', NULL, '2026-06-08 01:17:18', '2026-06-08 01:17:18'),
(65, 'Retta Kresensia Br Sembiring', 'cia', 'Cia', 'retta.kresensia@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$XHgp87lS1zYFjd/zIb7R7.qknFl3oMuJxtAP8KiTsOdXbcvVO6UH6', NULL, '2026-06-08 01:17:18', '2026-06-08 01:17:18'),
(66, 'Rizky Herdiansyah Ramadhan', 'kiher', 'Kiher', 'rizky.herdiansyah@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$e5XQPcX01svyaMNk3PyI6efLpAzj3OvCwfvY8KsIvB1zQ6edrsp.C', NULL, '2026-06-08 01:17:19', '2026-06-08 01:17:19'),
(67, 'Yosapat Nainggolan', 'yosan', 'Yosan', 'yosapat.nainggolan@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$ljHsotr9SjymuBcrWxHrHOSutv1Q8.dRsZzSFTv79c144o2v/mDvS', NULL, '2026-06-08 01:17:19', '2026-06-08 01:17:19'),
(68, 'Zebi Nurlestari Asmoro', 'zebi', 'Zebi', 'zebi.nurlestari@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS A', NULL, NULL, '$2y$12$tEkRgbcIBkkC4pVXDoeM5eOHlnfky6TG.Y1Ff8eYId/M9AlwCWA/i', NULL, '2026-06-08 01:17:19', '2026-06-08 01:17:19'),
(69, 'Andreas Castropasu Sibarani', 'castro', 'Castro', 'andreas.castropasu@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$vz9gQD9fCffqTZ0R3SsQrunvF0MOlay3buFgQRcJSQmAkBBQ42A6C', NULL, '2026-06-08 01:17:20', '2026-06-08 01:17:20'),
(70, 'Aniparadja', 'anip', 'Anip', 'aniparadja@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$a6b.GPU2DUKPy/Rdc9Vpau5qapSdtPvT7IJR3Q3/xRgehIx/KceOi', NULL, '2026-06-08 01:17:20', '2026-06-08 01:17:20'),
(71, 'Arya Sinarta Sihite', 'narta', 'Narta', 'arya.sinarta@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$ICL7kiIHGKwnfClVy/OFCuRfbPJse6IWh3sjBmqQu66FGRru.xshe', NULL, '2026-06-08 01:17:21', '2026-06-08 01:17:21'),
(72, 'Asih Wulandaiva P', 'wulan', 'Wulan', 'asih.wulandaiva@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$.c3PnVMPAkLeUm1sMXL33uI727wNdO5GzEdQIE50J3ysNg5vuNEiK', NULL, '2026-06-08 01:17:21', '2026-06-08 01:17:21'),
(73, 'Aurel Dwi Cahyono', 'rely', 'Rely', 'aurel.dwi@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$rgkK2wpLOYXfAY7GA2yO.O5HH6qrtusstu1PpfEzqsXtaOeDtDS8C', NULL, '2026-06-08 01:17:21', '2026-06-08 01:17:21'),
(74, 'Bintang Nur Hidayah Putri', 'binta', 'Binta', 'bintang.nur@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$0emtOKsyabr6ctDYHoPyWeXV6N2LgpnTuaPuH5pQEkh0Y/OciYlqy', NULL, '2026-06-08 01:17:22', '2026-06-08 01:17:22'),
(75, 'Dinda Atika Rahmah', 'ika', 'Ika', 'dinda.atika@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$E5Qly.Ze910mV2kdHeGuCOZ5L6E2id9q/6WKwU5DCSJCExZoftbkm', NULL, '2026-06-08 01:17:22', '2026-06-08 01:17:22'),
(76, 'Evan Perwira Abednego', 'dego', 'Dego', 'evan.perwira@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$8oOdd9cY04z6RfQi9WprNuCo1cJ6ye25Ay6J61Wfs6DbjqR.G3oTu', NULL, '2026-06-08 01:17:23', '2026-06-08 01:17:23'),
(77, 'Haidar Fauzul Kusnadi', 'zul', 'Zul', 'haidar.fauzul@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$4zgP5iO4K9Z3MtxRqiOmwu6eJm61YuwSzxh14/rpXSOAZd30d0YEW', NULL, '2026-06-08 01:17:23', '2026-06-08 01:17:23'),
(78, 'Made Ayu Ratna D. S.', 'dweta', 'Dweta', 'made.ayu@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$AfRxWIncR2manVbbic1ZG.iY7IG6DeluyH.TSeCYtbnAKIBeA1B32', NULL, '2026-06-08 01:17:23', '2026-06-08 01:17:23'),
(79, 'Muhammad Azril', 'azril', 'Azril', 'muhammad.azril@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$KpgqbFPo5nN947XdTUwgXe15Wpq2dw3td0RiB8RpDdPKzSiUHOf5m', NULL, '2026-06-08 01:17:24', '2026-06-08 01:17:24'),
(80, 'Muhammad Dafa Ray Stahanif', 'ray', 'Ray', 'muhammad.dafa@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$gAdqUYG1F4.8M.DAGAK5E.wPok8WoSTtnrQ.2sFidzCe2PTySgHOe', NULL, '2026-06-08 01:17:24', '2026-06-08 01:17:24'),
(81, 'Muhammad Daniel Cello Pratama', 'cello', 'Cello', 'muhammad.daniel@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$N0y.Q1qI2RAkwWnjPHPAbODAub2D6L94DenVOn./X8xLbmD91cemK', NULL, '2026-06-08 01:17:25', '2026-06-08 01:17:25'),
(82, 'Muhammad Pandu Praja', 'praja', 'Praja', 'muhammad.pandu@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$sJkjqEGz19X9QFKzF5d/d.IqU/87TvKdKamF1APJbpPM/ar7UNDs.', NULL, '2026-06-08 01:17:25', '2026-06-08 01:17:25'),
(83, 'Muhammad Umar', 'emyu', 'Emyu', 'muhammad.umar@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$qwL.TKzP1OC9wJ5koZwjJ.94nKsVaiZmDxbjd3n.hFjg6gnOFU0/O', NULL, '2026-06-08 01:17:26', '2026-06-08 01:17:26'),
(84, 'Niswatun Nur Farida', 'niswa', 'Niswa', 'niswatun.nur@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$ERa54QHrZExv58MEsERHWucYYhPEdEXvZlFiEoKDdSCloxe24MJe2', NULL, '2026-06-08 01:17:26', '2026-06-08 01:17:26'),
(85, 'Putra Adhi Aqsha', 'aqsha', 'Aqsha', 'putra.adhi@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$W2TkwebMFYDFQ1nKN7wvlOrt6x0vzjUWCr6agMdS3O8ndBwFyG/P6', NULL, '2026-06-08 01:17:27', '2026-06-08 01:17:27'),
(86, 'Ruth Devina Graceila Hutabarat', 'ruth', 'Ruth', 'ruth.devina@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$TCrNlc0bLOt4J9dAa372IeCawqWwrPUD2jRy0QvElgtK7J6681m3K', NULL, '2026-06-08 01:17:27', '2026-06-08 01:17:27'),
(87, 'Sabina Ratu Putri', 'bina', 'Bina', 'sabina.ratu@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$eH9IQgCxj9Sgk9tbIsCmCep4BzYO7OuW9fvatEAS1hHY6ezHmvwhS', NULL, '2026-06-08 01:17:28', '2026-06-08 01:17:28'),
(88, 'Zahra\' Salsabila Fitria Merlyn', 'merlyn', 'Merlyn', 'zahra\'.salsabila@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RSK', NULL, NULL, '$2y$12$nnA2p/eMCPxukJ3e0H1uYeY9t8HkPpuCrqg/TOrOsoCosS9Q7yqT.', NULL, '2026-06-08 01:17:28', '2026-06-08 01:17:28'),
(89, 'Atika Rahma', 'tira', 'Tira', 'atika.rahma@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$eVH/I.luU4Eecj9Bhiqefu21tCDuk8acGlsuxX..IsJbMIisRZ8Ey', NULL, '2026-06-08 01:17:29', '2026-06-08 01:17:29'),
(90, 'Britania Paria Delta Siburian', 'tania', 'Tania', 'britania.paria@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$5lSv8P/E9gL5UeQGKLMEfuQc19nZtrfAPa0bwBJ9GIoo46L47SHn6', NULL, '2026-06-08 01:17:29', '2026-06-08 01:17:29'),
(91, 'Christine Nauli Febiana S', 'febi', 'Febi', 'christine.nauli@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$6jOtx4R8JFn6e3lz4NYuX.8arwxyEnSI5RagkO3hOhgzRpc3Tp5S2', NULL, '2026-06-08 01:17:30', '2026-06-08 01:17:30'),
(92, 'Della Risava Silaban', 'risav', 'Risav', 'della.risava@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$eJycAHWIqkgs5K9Nwy436.iiacAlrW5I1mvlXzjcNVeF2OS5Jf8bG', NULL, '2026-06-08 01:17:30', '2026-06-08 01:17:30'),
(93, 'Eulia Radifa Meilinawati', 'difa', 'Difa', 'eulia.radifa@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$KnUxm8vw7bu2S4sYyNKzfO6ar1Ow3nQLJIpBzXUjOBDovXJJgekCW', NULL, '2026-06-08 01:17:31', '2026-06-08 01:17:31'),
(94, 'Fakhri Ahmad Asyafi\'i', 'fri', 'Fri', 'fakhri.ahmad@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$jXJjQHojQxpDicYOjNU0Z.Sh6/WCzE7kD3E2UzdU7MlvxJ5hJaPw.', NULL, '2026-06-08 01:17:31', '2026-06-08 01:17:31'),
(95, 'Faris Rahmadin', 'fadin', 'Fadin', 'faris.rahmadin@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$54g2KyaZbMsYh9yF7SmXgu1NDAxLDmc96TbEqNWEjaE8LBklQ7L.S', NULL, '2026-06-08 01:17:31', '2026-06-08 01:17:31'),
(96, 'Hasan Almusanna Albaar', 'nasa', 'Nasa', 'hasan.almusanna@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$myQLv3kb.HFbkYoeunTc2e4xF/oD/yBmVJy9Y5NSAVEgaHQdF2vB.', NULL, '2026-06-08 01:17:32', '2026-06-08 01:17:32'),
(97, 'Irsyad Arif Firmansyah', 'irsyad', 'Irsyad', 'irsyad.arif@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$5bBfKXezprKYH2apO/46kOAGN29hksF57QAWqOSBw5VSUVEpA5U7G', NULL, '2026-06-08 01:17:32', '2026-06-08 01:17:32'),
(98, 'Jessica Avrilia Br Simatupang', 'jessi', 'Jessi', 'jessica.avrilia@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$tgr02velE5KLeDQC.lKiqOpgB8GlP/LVX..a68cdN0tGq.zl6Nf1m', NULL, '2026-06-08 01:17:33', '2026-06-08 01:17:33'),
(99, 'M. Adib Arkan', 'diboy', 'Diboy', 'm..adib@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$JeZ4GENp7aAx3VkYqgSGEuvxgkP2wpqWKNN1AMO6H5SwA5qynWZGC', NULL, '2026-06-08 01:17:33', '2026-06-08 01:17:33'),
(100, 'M. Deonardo Federicko', 'deo', 'Deo', 'm..deonardo@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$cxEURIeZPfQlvOeTQwtiFunWt5OFK1h8ElR.VMeN44Xy2Yw3pnlVi', NULL, '2026-06-08 01:17:34', '2026-06-08 01:17:34'),
(101, 'Michael Ridho Waster Pakpahan', 'waster', 'Waster', 'michael.ridho@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$197WT2KfRmQ96j.WSB3gf.mI8f.9PTobfGYxbWkmt56.Nn3w/Bor6', NULL, '2026-06-08 01:17:34', '2026-06-08 01:17:34'),
(102, 'Muhaimin Murdiyanto', 'imin', 'Imin', 'muhaimin.murdiyanto@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$Pt6eLrPoVgNUR.RzpnJ7jOKg0lXKV5iH0Y/xeHAfk2yDV7Rb4BNUy', NULL, '2026-06-08 01:17:34', '2026-06-08 01:17:34'),
(103, 'Muhammad Fernanda Irawan', 'feno', 'Feno', 'muhammad.fernanda@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$lpMXPVRrX7kvmutItpTfMu6JAG1Vjq1RtNJ9o3r8cGFu7R4kNZZLa', NULL, '2026-06-08 01:17:35', '2026-06-08 01:17:35'),
(104, 'Muhammad Rizq Dewangga', 'wangga', 'Wangga', 'muhammad.rizq@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$8NrYswMRZeKXBLWHsrVPzu4IiTE.y32mFTy/rq5.GWX32H1slyAHS', NULL, '2026-06-08 01:17:35', '2026-06-08 01:17:35'),
(105, 'Rivaldi Abdullah', 'valid', 'Valid', 'rivaldi.abdullah@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$uRBWIwQ9rru/JrsKh4D3y.hvPG9jUbfmQqG3JQh7PdghMypNag0p.', NULL, '2026-06-08 01:17:36', '2026-06-08 01:17:36'),
(106, 'Rizal Hadi Fadillah Riyadi', 'riyad', 'Riyad', 'rizal.hadi@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$tW/FAMdOg45ACY6rEm2CJuSZgeK5uo.FYW090GYuiLGeHTBf4jAKW', NULL, '2026-06-08 01:17:36', '2026-06-08 01:17:36'),
(107, 'Yahfi Al Farisy', 'alfa', 'Alfa', 'yahfi.al@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$8QUMCLjM/tMiBdPjJ5MiKuTA0g9nDVNa0lac7DN3hvt2AhPY2F1nm', NULL, '2026-06-08 01:17:37', '2026-06-08 01:17:37'),
(108, 'Yanuar Ubeth Taruna Wibawa', 'ubeth', 'Ubeth', 'yanuar.ubeth@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$FWlfcCzwP9CW3WJI82N4DOolFqkMSMVAAoK.N0p/o22EPBDjiIymC', NULL, '2026-06-08 01:17:37', '2026-06-08 01:17:37'),
(109, 'Yusuf Fahar Prasli Irsyad', 'fahar', 'Fahar', 'yusuf.fahar@student.poltekssn.ac.id', 'taruna', NULL, 'Taruna 2 RKS B', NULL, NULL, '$2y$12$KFdxXzptGEf7F2KmUlI4He9knqLkaqjm2lAntR.FNGZhnxdG8H/je', NULL, '2026-06-08 01:17:38', '2026-06-08 01:17:38'),
(110, 'Imas Purbasari', 'imas', NULL, 'imas.purbasari@poltekssn.ac.id', 'pengasuh', NULL, 'Ketua Tim A', NULL, NULL, '$2y$12$DE3DW4rfUDmfP1CsihhEYOw93TW6OkDi/TslGr4ph/vpDWPFiCgry', NULL, '2026-06-08 22:00:46', '2026-06-08 22:00:46'),
(113, 'Test User Delete', 'testdelete', NULL, 'testdelete@example.com', 'taruna', NULL, NULL, NULL, NULL, '$2y$12$zxctsxfuATXSM69D/0yQbeFlOgJDNYDc22DiTpV2IB0e/fCGSsAbm', NULL, '2026-06-08 22:15:18', '2026-06-08 22:15:18'),
(114, 'Arif Bagus Albudin', 'budi', NULL, 'arif.bagus@poltekssn.ac.id', 'pengasuh', NULL, 'Pengasuh Satria', NULL, NULL, '$2y$12$dpqnrQq/SQ8fmXnGJiNCReBh6cyjgJcDsGS1kXtDzQdgBx7bfI6kG', NULL, '2026-06-09 20:00:34', '2026-06-09 20:00:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acara`
--
ALTER TABLE `acara`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_modul_aksi_index` (`modul`,`aksi`),
  ADD KEY `activity_logs_user_id_index` (`user_id`),
  ADD KEY `activity_logs_created_at_index` (`created_at`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `poin_mahasiswa`
--
ALTER TABLE `poin_mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acara`
--
ALTER TABLE `acara`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poin_mahasiswa`
--
ALTER TABLE `poin_mahasiswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
