-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: ppicurug
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `ppicurug`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ppicurug` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `ppicurug`;

--
-- Table structure for table `acara`
--

DROP TABLE IF EXISTS `acara`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acara` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_acara` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acara`
--

LOCK TABLES `acara` WRITE;
/*!40000 ALTER TABLE `acara` DISABLE KEYS */;
INSERT INTO `acara` VALUES (4,'Google Development On Campus','2026-06-15','04:30:00','Kegiatan Google Development On Campus','2026-06-09 19:57:35','2026-06-09 23:32:22');
/*!40000 ALTER TABLE `acara` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `modul` varchar(255) NOT NULL,
  `aksi` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`detail`)),
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_modul_aksi_index` (`modul`,`aksi`),
  KEY `activity_logs_user_id_index` (`user_id`),
  KEY `activity_logs_created_at_index` (`created_at`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,2,'Penyelenggara','admin','poin','tambah','Tambah poin Prestasi untuk Selma Shakila Andyana Putri (NPM: 2322101976) ΓÇö Kegiatan: k, Nilai: 1','{\"npm\":\"2322101976\",\"nama_mahasiswa\":\"Selma Shakila Andyana Putri\",\"kelas\":\"2 RPLK\",\"kategori\":\"prestasi\",\"kegiatan\":\"k\",\"nilai\":1,\"tanggal\":\"2026-06-09\",\"pengasuh\":\"nufri\"}','App\\Models\\PoinMahasiswa',1,'127.0.0.1','2026-06-08 21:11:18','2026-06-08 21:11:18'),(2,2,'Penyelenggara','admin','poin','tambah','Tambah poin Prestasi untuk Justin Wismar Tobing (NPM: 2423102038) ΓÇö Kegiatan: Lomba Scrable, Nilai: 3','{\"npm\":\"2423102038\",\"nama_mahasiswa\":\"Justin Wismar Tobing\",\"kelas\":\"2 RPLK\",\"kategori\":\"prestasi\",\"kegiatan\":\"Lomba Scrable\",\"nilai\":3,\"tanggal\":\"2026-06-09\",\"pengasuh\":\"Hadyan\"}','App\\Models\\PoinMahasiswa',2,'127.0.0.1','2026-06-08 21:50:05','2026-06-08 21:50:05'),(3,NULL,'Pengasuh','pengasuh','poin','tambah','Tambah poin Pelanggaran untuk Justin Wismar Tobing (NPM: 2423102038) ΓÇö Kegiatan: Jam Malam, Nilai: 1','{\"npm\":\"2423102038\",\"nama_mahasiswa\":\"Justin Wismar Tobing\",\"kelas\":\"2 RPLK\",\"kategori\":\"pelanggaran\",\"kegiatan\":\"Jam Malam\",\"nilai\":1,\"tanggal\":\"2026-06-08\",\"pengasuh\":\"Hadyan\"}','App\\Models\\PoinMahasiswa',3,'127.0.0.1','2026-06-08 21:51:42','2026-06-08 21:51:42'),(4,NULL,'Imas Purbasari','pengasuh','acara','buat','Buat acara baru: \"Kuliah Umum elektornika\" pada 27/06/2026 pukul 14:56','{\"nama_acara\":\"Kuliah Umum elektornika\",\"tanggal\":\"2026-06-27\",\"jam\":\"14:56\",\"keterangan\":null}','App\\Models\\Acara',3,'127.0.0.1','2026-06-09 00:59:55','2026-06-09 00:59:55'),(5,NULL,'Imas Purbasari','pengasuh','acara','hapus','Hapus acara \"Kuliah Umum elektornika\" yang dijadwalkan pada 27/06/2026 pukul 14:56:00','{\"nama_acara\":\"Kuliah Umum elektornika\",\"tanggal\":\"2026-06-27\",\"jam\":\"14:56:00\",\"keterangan\":null}','App\\Models\\Acara',1,'127.0.0.1','2026-06-09 01:00:10','2026-06-09 01:00:10'),(6,NULL,'Imas Purbasari','pengasuh','acara','hapus','Hapus acara \"Kuliah Umum elektornika\" yang dijadwalkan pada 27/06/2026 pukul 14:56:00','{\"nama_acara\":\"Kuliah Umum elektornika\",\"tanggal\":\"2026-06-27\",\"jam\":\"14:56:00\",\"keterangan\":null}','App\\Models\\Acara',2,'127.0.0.1','2026-06-09 01:00:13','2026-06-09 01:00:13'),(7,NULL,'Imas Purbasari','pengasuh','surat','buat','Buat surat baru: \"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 ΓÇ£Mobile App and Web  SessionΓÇ¥\" (Surat Proposal) dari Biro Siber kepada Pengasuhan','{\"nomor_surat\":\"SENKORPSTAR\\/D41.007\\/PH.068\\/KM.05.03\\/IV\\/2026\",\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 \\u201cMobile App and Web  Session\\u201d\",\"pengirim\":\"Biro Siber\",\"penerima\":\"Pengasuhan\",\"tanggal_surat\":\"2026-04-23\",\"status\":\"Diproses\"}','App\\Models\\Surat',1,'127.0.0.1','2026-06-09 01:05:38','2026-06-09 01:05:38'),(8,2,'Penyelenggara','admin','acara','buat','Buat acara baru: \"Google Development On Campus\" pada 15/06/2026 pukul 04:30','{\"nama_acara\":\"Google Development On Campus\",\"tanggal\":\"2026-06-15\",\"jam\":\"04:30\",\"keterangan\":\"Kegiatan Google Development On Campus\"}','App\\Models\\Acara',4,'127.0.0.1','2026-06-09 19:57:35','2026-06-09 19:57:35'),(9,NULL,'Arif Bagus Albudin','pengasuh','surat','ubah','Ubah surat \"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 ΓÇ£Mobile App and Web  SessionΓÇ¥\"','{\"nomor_surat\":\"SENKORPSTAR\\/D41.007\\/PH.068\\/KM.05.03\\/IV\\/2026\",\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 \\u201cMobile App and Web  Session\\u201d\",\"pengirim\":\"Biro Siber\",\"penerima\":\"Pengasuhan\",\"status_lama\":\"Diproses\",\"status_baru\":\"Diproses\"}','App\\Models\\Surat',1,'127.0.0.1','2026-06-09 20:01:54','2026-06-09 20:01:54'),(10,2,'Penyelenggara','admin','surat','ubah','Ubah surat \"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 ΓÇ£Mobile App and Web  SessionΓÇ¥\"','{\"nomor_surat\":\"SENKORPSTAR\\/D41.007\\/PH.068\\/KM.05.03\\/IV\\/2026\",\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 \\u201cMobile App and Web  Session\\u201d\",\"pengirim\":\"Biro Siber\",\"penerima\":\"Pengasuhan\",\"status_lama\":\"Diproses\",\"status_baru\":\"Diproses\"}','App\\Models\\Surat',1,'127.0.0.1','2026-06-09 20:03:28','2026-06-09 20:03:28'),(11,2,'Penyelenggara','admin','surat','ubah','Ubah surat \"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 ΓÇ£Mobile App and Web  SessionΓÇ¥\"','{\"nomor_surat\":\"SENKORPSTAR\\/D41.007\\/PH.068\\/KM.05.03\\/IV\\/2026\",\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 \\u201cMobile App and Web  Session\\u201d\",\"pengirim\":\"Biro Siber\",\"penerima\":\"Pengasuhan\",\"status_lama\":\"Diproses\",\"status_baru\":\"Diproses\"}','App\\Models\\Surat',1,'127.0.0.1','2026-06-09 20:03:38','2026-06-09 20:03:38'),(12,NULL,'Arif Bagus Albudin','pengasuh','surat','buat','Buat surat baru: \"Permohonan Izin Mengikuti Acara Build with  AI x JuaraVibeCoding: Breaking Limits, Building  Impact\" (Surat Proposal) dari Biro Siber kepada Pengasuhan','{\"nomor_surat\":\"SENKORPSTAR\\/D41.009\\/PH.095\\/KM.05.03\\/V\\/2026\",\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara Build with  AI x JuaraVibeCoding: Breaking Limits, Building  Impact\",\"pengirim\":\"Biro Siber\",\"penerima\":\"Pengasuhan\",\"tanggal_surat\":\"2026-06-08\",\"status\":\"Diproses\"}','App\\Models\\Surat',2,'127.0.0.1','2026-06-09 20:11:24','2026-06-09 20:11:24'),(13,2,'Penyelenggara','admin','surat','setujui','Ubah status surat \"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 ΓÇ£Mobile App and Web  SessionΓÇ¥\": Diproses ΓåÆ Disetujui','{\"nomor_surat\":\"SENKORPSTAR\\/D41.007\\/PH.068\\/KM.05.03\\/IV\\/2026\",\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 \\u201cMobile App and Web  Session\\u201d\",\"pengirim\":\"Biro Siber\",\"penerima\":\"Pengasuhan\",\"status_lama\":\"Diproses\",\"status_baru\":\"Disetujui\"}','App\\Models\\Surat',1,'127.0.0.1','2026-06-09 20:11:51','2026-06-09 20:11:51'),(14,2,'Penyelenggara','admin','surat','tolak','Ubah status surat \"Permohonan Izin Mengikuti Acara Build with  AI x JuaraVibeCoding: Breaking Limits, Building  Impact\": Diproses ΓåÆ Ditolak','{\"nomor_surat\":\"SENKORPSTAR\\/D41.009\\/PH.095\\/KM.05.03\\/V\\/2026\",\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara Build with  AI x JuaraVibeCoding: Breaking Limits, Building  Impact\",\"pengirim\":\"Biro Siber\",\"penerima\":\"Pengasuhan\",\"status_lama\":\"Diproses\",\"status_baru\":\"Ditolak\"}','App\\Models\\Surat',2,'127.0.0.1','2026-06-09 23:28:06','2026-06-09 23:28:06'),(15,2,'Penyelenggara','admin','acara','ubah','Ubah acara \"Kuliah Umum elektornika\" ΓåÆ \"Kuliah Umum elektornika\" pada 27/06/2026 pukul 14:56','{\"nama_lama\":\"Kuliah Umum elektornika\",\"nama_baru\":\"Kuliah Umum elektornika\",\"tanggal\":\"2026-06-27\",\"jam\":\"14:56\",\"keterangan\":null}','App\\Models\\Acara',3,'127.0.0.1','2026-06-09 23:32:08','2026-06-09 23:32:08'),(16,2,'Penyelenggara','admin','acara','ubah','Ubah acara \"Google Development On Campus\" ΓåÆ \"Google Development On Campus\" pada 15/06/2026 pukul 04:30','{\"nama_lama\":\"Google Development On Campus\",\"nama_baru\":\"Google Development On Campus\",\"tanggal\":\"2026-06-15\",\"jam\":\"04:30\",\"keterangan\":\"Kegiatan Google Development On Campus\"}','App\\Models\\Acara',4,'127.0.0.1','2026-06-09 23:32:22','2026-06-09 23:32:22'),(17,2,'Penyelenggara','admin','acara','hapus','Hapus acara \"Kuliah Umum elektornika\" yang dijadwalkan pada 27/06/2026 pukul 14:56:00','{\"nama_acara\":\"Kuliah Umum elektornika\",\"tanggal\":\"2026-06-27\",\"jam\":\"14:56:00\",\"keterangan\":null}','App\\Models\\Acara',3,'127.0.0.1','2026-06-09 23:33:36','2026-06-09 23:33:36'),(18,2,'Penyelenggara','admin','poin','tambah','Tambah poin Prestasi untuk Zhafran Riko Santoso (NPM: 2423102095) ΓÇö Kegiatan: Lomba, Nilai: 3','{\"npm\":\"2423102095\",\"nama_mahasiswa\":\"Zhafran Riko Santoso\",\"kelas\":\"2 RPLK\",\"kategori\":\"prestasi\",\"kegiatan\":\"Lomba\",\"nilai\":3,\"tanggal\":\"2026-06-10\",\"pengasuh\":\"Penyelenggara\"}','App\\Models\\PoinMahasiswa',4,'127.0.0.1','2026-06-09 23:34:26','2026-06-09 23:34:26'),(19,2,'Penyelenggara','admin','poin','tambah','Tambah poin Pelanggaran untuk Zhafran Riko Santoso (NPM: 2423102095) ΓÇö Kegiatan: jam malam, Nilai: 1','{\"npm\":\"2423102095\",\"nama_mahasiswa\":\"Zhafran Riko Santoso\",\"kelas\":\"2 RPLK\",\"kategori\":\"pelanggaran\",\"kegiatan\":\"jam malam\",\"nilai\":1,\"tanggal\":\"2026-06-10\",\"pengasuh\":\"Penyelenggara\"}','App\\Models\\PoinMahasiswa',5,'127.0.0.1','2026-06-09 23:34:48','2026-06-09 23:34:48'),(20,2,'Penyelenggara','admin','poin','tambah','Tambah poin Pelanggaran untuk Justin Wismar Tobing (NPM: 2423102038) ΓÇö Kegiatan: jam malam, Nilai: 4','{\"npm\":\"2423102038\",\"nama_mahasiswa\":\"Justin Wismar Tobing\",\"kelas\":\"2 RPLK\",\"kategori\":\"pelanggaran\",\"kegiatan\":\"jam malam\",\"nilai\":4,\"tanggal\":\"2026-06-10\",\"pengasuh\":\"Penyelenggara\"}','App\\Models\\PoinMahasiswa',6,'127.0.0.1','2026-06-10 00:40:55','2026-06-10 00:40:55'),(21,2,'Penyelenggara','admin','poin','tambah','Tambah poin Prestasi untuk Gita Olivia Silaban (NPM: 2423102028) ΓÇö Kegiatan: Lomba, Nilai: 4','{\"npm\":\"2423102028\",\"nama_mahasiswa\":\"Gita Olivia Silaban\",\"kelas\":\"2 RKS A\",\"kategori\":\"prestasi\",\"kegiatan\":\"Lomba\",\"nilai\":4,\"tanggal\":\"2026-06-10\",\"pengasuh\":\"Penyelenggara\"}','App\\Models\\PoinMahasiswa',7,'127.0.0.1','2026-06-10 00:49:34','2026-06-10 00:49:34'),(22,2,'Penyelenggara','admin','poin','tambah','Tambah poin Prestasi untuk Jonathan Kevin Binsar Pangaribuan (NPM: 2423102037) ΓÇö Kegiatan: Lomba Code The Future, Nilai: 3','{\"npm\":\"2423102037\",\"nama_mahasiswa\":\"Jonathan Kevin Binsar Pangaribuan\",\"kelas\":\"2 RPLK\",\"kategori\":\"prestasi\",\"kegiatan\":\"Lomba Code The Future\",\"nilai\":3,\"tanggal\":\"2026-05-30\",\"pengasuh\":\"Penyelenggara\"}','App\\Models\\PoinMahasiswa',8,'127.0.0.1','2026-06-10 04:48:26','2026-06-10 04:48:26'),(23,2,'Penyelenggara','admin','poin','tambah','Tambah poin Prestasi untuk Jonathan Kevin Binsar Pangaribuan (NPM: 2423102037) ΓÇö Kegiatan: Lomba Gunadarma Code Week, Nilai: 3','{\"npm\":\"2423102037\",\"nama_mahasiswa\":\"Jonathan Kevin Binsar Pangaribuan\",\"kelas\":\"2 RPLK\",\"kategori\":\"prestasi\",\"kegiatan\":\"Lomba Gunadarma Code Week\",\"nilai\":3,\"tanggal\":\"2025-07-30\",\"pengasuh\":\"Penyelenggara\"}','App\\Models\\PoinMahasiswa',9,'127.0.0.1','2026-06-10 04:51:17','2026-06-10 04:51:17'),(24,15,'Jonathan Kevin Binsar Pangaribuan','taruna','surat','ajukan','Taruna \"Jonathan Kevin Binsar Pangaribuan\" mengajukan Surat Proposal: \"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 ΓÇ£Mobile App and Web  SessionΓÇ¥\"','{\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 \\u201cMobile App and Web  Session\\u201d\",\"pengirim\":\"Jonathan Kevin Binsar Pangaribuan\"}','App\\Models\\Surat',3,'127.0.0.1','2026-06-10 05:24:01','2026-06-10 05:24:01'),(25,NULL,'Arif Bagus Albudin','pengasuh','surat','setujui','Ubah status surat \"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 ΓÇ£Mobile App and Web  SessionΓÇ¥\": Diproses ΓåÆ Disetujui','{\"nomor_surat\":null,\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 \\u201cMobile App and Web  Session\\u201d\",\"pengirim\":\"Jonathan Kevin Binsar Pangaribuan\",\"penerima\":\"Satuan Pengasuhan\",\"status_lama\":\"Diproses\",\"status_baru\":\"Disetujui\",\"catatan_pengasuhan\":null}','App\\Models\\Surat',3,'127.0.0.1','2026-06-10 05:24:33','2026-06-10 05:24:33'),(26,2,'Penyelenggara','admin','surat','hapus','Hapus surat \"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 ΓÇ£Mobile App and Web  SessionΓÇ¥\" (Surat Proposal) dari Jonathan Kevin Binsar Pangaribuan ΓÇö Status terakhir: Disetujui','{\"nomor_surat\":null,\"jenis_surat\":\"Surat Proposal\",\"perihal\":\"Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 \\u201cMobile App and Web  Session\\u201d\",\"pengirim\":\"Jonathan Kevin Binsar Pangaribuan\",\"penerima\":\"Satuan Pengasuhan\",\"status\":\"Disetujui\"}','App\\Models\\Surat',3,'127.0.0.1','2026-06-17 03:34:09','2026-06-17 03:34:09'),(27,2,'Penyelenggara','admin','poin','tambah','Tambah poin Prestasi untuk Abel Ihsan Renjiro (NPM: 2524102097) ΓÇö Kegiatan: Sertifikasi Akademik/Non-akademik Tingkat Nasional, Nilai: 0.7','{\"npm\":\"2524102097\",\"nama_mahasiswa\":\"Abel Ihsan Renjiro\",\"kelas\":\"1 RKS A\",\"kategori\":\"prestasi\",\"kegiatan\":\"Sertifikasi Akademik\\/Non-akademik Tingkat Nasional\",\"nilai\":0.7,\"tanggal\":\"2026-06-17\",\"pengasuh\":\"Penyelenggara\"}','App\\Models\\PoinMahasiswa',10,'127.0.0.1','2026-06-17 03:35:52','2026-06-17 03:35:52'),(28,2,'Penyelenggara','admin','database mahasiswa','ubah','Mengubah username, nama panggilan, password pada data Taruna',NULL,NULL,NULL,NULL,'2026-06-17 03:48:52','2026-06-17 03:48:52'),(29,NULL,'Imas Purbasari','pengasuh','log pergerakan','ubah','Mengubah status kembali untuk Ahmad Muflih Izfatara (olahraga)',NULL,NULL,NULL,NULL,'2026-08-16 07:35:45','2026-08-16 07:35:45'),(30,2,'Penyelenggara','admin','akses','ubah','Akses \"Duty Taruna\" untuk pengasuh ditutup','{\"fitur\":\"duty_taruna\",\"diizinkan\":\"0\"}',NULL,NULL,'127.0.0.1','2026-08-17 08:37:04','2026-08-17 08:37:04'),(31,167,'Pengasuh','pengasuh','poin','tambah','Pengusulan poin Pelanggaran (-) (ringan) untuk Abel Ihsan Renjiro ΓÇö Menggunakan sandal / pakaian non-standar di area terlarang [5 poin] (menunggu validasi Admin Pusbangkar)','{\"npm\":\"2524102097\",\"nama_mahasiswa\":\"Abel Ihsan Renjiro\",\"kategori\":\"pelanggaran\",\"tingkat\":\"ringan\",\"kegiatan\":\"Menggunakan sandal \\/ pakaian non-standar di area terlarang\",\"nilai\":5,\"status_validasi\":\"menunggu_validasi\"}','App\\Models\\PoinMahasiswa',17,'127.0.0.1','2026-08-27 01:22:06','2026-08-27 01:22:06'),(32,167,'Pengasuh','pengasuh','poin','tambah','Pengusulan poin Pelanggaran (-) (ringan) untuk Abel Ihsan Renjiro ΓÇö Tidak memakai papan nama / badge / pin taruna [5 poin] (menunggu validasi Admin Pusbangkar)','{\"npm\":\"2524102097\",\"nama_mahasiswa\":\"Abel Ihsan Renjiro\",\"kategori\":\"pelanggaran\",\"tingkat\":\"ringan\",\"kegiatan\":\"Tidak memakai papan nama \\/ badge \\/ pin taruna\",\"nilai\":5,\"status_validasi\":\"menunggu_validasi\"}','App\\Models\\PoinMahasiswa',18,'127.0.0.1','2026-08-27 01:22:27','2026-08-27 01:22:27'),(33,169,'Admin','admin','akses','ubah','Akses \"Duty Taruna\" untuk pengasuh dibuka','{\"fitur\":\"duty_taruna\",\"diizinkan\":\"1\"}',NULL,NULL,'127.0.0.1','2026-09-06 06:33:00','2026-09-06 06:33:00'),(34,169,'Admin','admin','poin','validasi_setujui','Admin memvalidasi usulan poin pelanggaran Abel Ihsan Renjiro (disetujui)','{\"poin_id\":18,\"status_validasi\":\"disetujui\",\"catatan_validasi\":null}','App\\Models\\PoinMahasiswa',18,'127.0.0.1','2026-09-06 08:24:17','2026-09-06 08:24:17');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `akses_fitur`
--

DROP TABLE IF EXISTS `akses_fitur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `akses_fitur` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fitur` varchar(255) NOT NULL,
  `diizinkan` tinyint(1) NOT NULL DEFAULT 1,
  `diubah_oleh` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `akses_fitur_fitur_unique` (`fitur`),
  KEY `akses_fitur_diubah_oleh_foreign` (`diubah_oleh`),
  CONSTRAINT `akses_fitur_diubah_oleh_foreign` FOREIGN KEY (`diubah_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `akses_fitur`
--

LOCK TABLES `akses_fitur` WRITE;
/*!40000 ALTER TABLE `akses_fitur` DISABLE KEYS */;
INSERT INTO `akses_fitur` VALUES (1,'duty_taruna',1,169,'2026-08-17 08:37:04','2026-09-06 06:33:00');
/*!40000 ALTER TABLE `akses_fitur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apel`
--

DROP TABLE IF EXISTS `apel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apel` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `sesi` enum('pagi','malam','khusus') NOT NULL,
  `sesi_unik` varchar(10) DEFAULT NULL,
  `nama_apel` varchar(255) DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `pembina` varchar(255) NOT NULL,
  `pembina_user_id` bigint(20) unsigned DEFAULT NULL,
  `lokasi` varchar(255) NOT NULL,
  `informasi` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `dibuat_oleh` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `apel_tanggal_sesi_unik_unique` (`tanggal`,`sesi_unik`),
  KEY `apel_pembina_user_id_foreign` (`pembina_user_id`),
  KEY `apel_dibuat_oleh_foreign` (`dibuat_oleh`),
  KEY `apel_tanggal_index` (`tanggal`),
  CONSTRAINT `apel_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `apel_pembina_user_id_foreign` FOREIGN KEY (`pembina_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apel`
--

LOCK TABLES `apel` WRITE;
/*!40000 ALTER TABLE `apel` DISABLE KEYS */;
/*!40000 ALTER TABLE `apel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `berita_taruna`
--

DROP TABLE IF EXISTS `berita_taruna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `berita_taruna` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `kategori` enum('pengumuman','prestasi','kegiatan','informasi','lainnya') NOT NULL DEFAULT 'informasi',
  `ringkasan` text DEFAULT NULL,
  `konten` longtext NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `berita_taruna_slug_unique` (`slug`),
  KEY `berita_taruna_user_id_foreign` (`user_id`),
  CONSTRAINT `berita_taruna_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `berita_taruna`
--

LOCK TABLES `berita_taruna` WRITE;
/*!40000 ALTER TABLE `berita_taruna` DISABLE KEYS */;
/*!40000 ALTER TABLE `berita_taruna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `duty_taruna`
--

DROP TABLE IF EXISTS `duty_taruna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `duty_taruna` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `minggu_mulai` date NOT NULL,
  `mahasiswa_id` bigint(20) unsigned NOT NULL,
  `diinput_oleh` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `duty_taruna_minggu_mulai_mahasiswa_id_unique` (`minggu_mulai`,`mahasiswa_id`),
  KEY `duty_taruna_mahasiswa_id_foreign` (`mahasiswa_id`),
  KEY `duty_taruna_diinput_oleh_foreign` (`diinput_oleh`),
  KEY `duty_taruna_minggu_mulai_index` (`minggu_mulai`),
  CONSTRAINT `duty_taruna_diinput_oleh_foreign` FOREIGN KEY (`diinput_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `duty_taruna_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `duty_taruna`
--

LOCK TABLES `duty_taruna` WRITE;
/*!40000 ALTER TABLE `duty_taruna` DISABLE KEYS */;
/*!40000 ALTER TABLE `duty_taruna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jadwal_pengasuh`
--

DROP TABLE IF EXISTS `jadwal_pengasuh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jadwal_pengasuh` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `pengasuh_id` bigint(20) unsigned NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jadwal_pengasuh_tanggal_unique` (`tanggal`),
  KEY `jadwal_pengasuh_pengasuh_id_foreign` (`pengasuh_id`),
  KEY `jadwal_pengasuh_tanggal_index` (`tanggal`),
  CONSTRAINT `jadwal_pengasuh_pengasuh_id_foreign` FOREIGN KEY (`pengasuh_id`) REFERENCES `pengasuh` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal_pengasuh`
--

LOCK TABLES `jadwal_pengasuh` WRITE;
/*!40000 ALTER TABLE `jadwal_pengasuh` DISABLE KEYS */;
/*!40000 ALTER TABLE `jadwal_pengasuh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kelas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kelas_nama_kelas_unique` (`nama_kelas`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas`
--

LOCK TABLES `kelas` WRITE;
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
INSERT INTO `kelas` VALUES (1,'2 RPLK','2026-06-17 01:55:09','2026-06-17 01:55:09'),(2,'2 RPKK','2026-06-17 01:55:55','2026-06-17 01:55:55'),(3,'2 RKS A','2026-06-17 01:56:07','2026-06-17 01:56:07'),(4,'2 RSK','2026-06-17 01:56:21','2026-06-17 01:56:21'),(5,'2 RKS B','2026-06-17 01:56:35','2026-06-17 01:56:35'),(6,'1 RKS A','2026-06-17 01:59:20','2026-06-17 01:59:20'),(7,'1 RKS B','2026-06-17 02:09:51','2026-06-17 02:09:51'),(8,'1 RPLK','2026-06-17 02:09:59','2026-06-17 02:09:59'),(9,'1 RSK','2026-06-17 02:10:07','2026-06-17 02:10:07'),(10,'1 RPKK','2026-06-17 02:10:22','2026-06-17 02:10:22');
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keluhan_barak`
--

DROP TABLE IF EXISTS `keluhan_barak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keluhan_barak` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `prodi` varchar(10) NOT NULL,
  `asrama` varchar(50) NOT NULL,
  `lorong` varchar(50) NOT NULL,
  `nomor_barak` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Diajukan',
  `catatan_pengasuhan` text DEFAULT NULL,
  `taruna_baca` tinyint(1) NOT NULL DEFAULT 0,
  `lampiran` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`lampiran`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `keluhan_barak_user_id_foreign` (`user_id`),
  KEY `keluhan_barak_tanggal_pengajuan_index` (`tanggal_pengajuan`),
  KEY `keluhan_barak_status_index` (`status`),
  CONSTRAINT `keluhan_barak_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keluhan_barak`
--

LOCK TABLES `keluhan_barak` WRITE;
/*!40000 ALTER TABLE `keluhan_barak` DISABLE KEYS */;
/*!40000 ALTER TABLE `keluhan_barak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `konsinyir`
--

DROP TABLE IF EXISTS `konsinyir`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `konsinyir` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` bigint(20) unsigned NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `lama_hari` int(10) unsigned NOT NULL,
  `keterangan` text DEFAULT NULL,
  `diinput_oleh` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `konsinyir_mahasiswa_id_foreign` (`mahasiswa_id`),
  KEY `konsinyir_diinput_oleh_foreign` (`diinput_oleh`),
  KEY `konsinyir_tanggal_mulai_index` (`tanggal_mulai`),
  CONSTRAINT `konsinyir_diinput_oleh_foreign` FOREIGN KEY (`diinput_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `konsinyir_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `konsinyir`
--

LOCK TABLES `konsinyir` WRITE;
/*!40000 ALTER TABLE `konsinyir` DISABLE KEYS */;
/*!40000 ALTER TABLE `konsinyir` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_pergerakan`
--

DROP TABLE IF EXISTS `log_pergerakan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_pergerakan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `npm` varchar(255) DEFAULT NULL,
  `prodi` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) NOT NULL,
  `subkategori` varchar(255) NOT NULL,
  `keterangan_keluhan` text DEFAULT NULL,
  `nama_ekskul` varchar(255) DEFAULT NULL,
  `jumlah_anggota` int(11) NOT NULL DEFAULT 1,
  `daftar_anggota` text DEFAULT NULL,
  `lokasi_kegiatan` varchar(255) DEFAULT NULL,
  `rute` varchar(255) DEFAULT NULL,
  `pengikut` text DEFAULT NULL,
  `foto_keberangkatan` varchar(255) DEFAULT NULL,
  `waktu_berangkat` datetime NOT NULL,
  `estimasi_kembali` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'berangkat',
  `waktu_kembali` datetime DEFAULT NULL,
  `foto_kembali` varchar(255) DEFAULT NULL,
  `catatan_kembali` text DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `verified_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_pergerakan_user_id_foreign` (`user_id`),
  CONSTRAINT `log_pergerakan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_pergerakan`
--

LOCK TABLES `log_pergerakan` WRITE;
/*!40000 ALTER TABLE `log_pergerakan` DISABLE KEYS */;
INSERT INTO `log_pergerakan` VALUES (1,NULL,'Selma Shakila Andyana Putri','2322101976','RPLK','perizinan','Kesehatan','Pemeriksaan kesehatan rutin ke Poliklinik PPI Curug',NULL,1,NULL,NULL,NULL,NULL,NULL,'2026-08-16 13:44:13','2026-08-16 15:44:13','kembali','2026-08-16 14:29:52',NULL,NULL,NULL,NULL,'2026-08-16 07:29:13','2026-08-16 07:29:52'),(2,NULL,'Achmad Fatih Binasiilah','2423101991','RPLK','ekstrakurikuler','Wajib',NULL,'Marching Band',12,'Fatih, Muflih, Joke, Jiro, Farhan, dll','Lapangan Utama Hanggar PPI Curug',NULL,NULL,NULL,'2026-08-16 13:09:13','2026-08-16 15:09:13','berangkat',NULL,NULL,NULL,NULL,NULL,'2026-08-16 07:29:13','2026-08-16 07:29:13'),(3,NULL,'Ahmad Muflih Izfatara','2423101994','RPLK','olahraga','Mandiri',NULL,NULL,1,NULL,NULL,'Rute Lari Luar Kampus Curug (Perimeter Bandara)','4 orang (Joke, Castro, Althaf, Edya)',NULL,'2026-08-16 13:59:13',NULL,'kembali','2026-08-16 14:35:45',NULL,NULL,NULL,110,'2026-08-16 07:29:13','2026-08-16 07:35:45');
/*!40000 ALTER TABLE `log_pergerakan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mahasiswa`
--

DROP TABLE IF EXISTS `mahasiswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mahasiswa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `npm` varchar(20) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `kelas` varchar(255) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `prodi` varchar(255) NOT NULL,
  `tingkat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mahasiswa_npm_unique` (`npm`),
  KEY `mahasiswa_user_id_foreign` (`user_id`),
  CONSTRAINT `mahasiswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mahasiswa`
--

LOCK TABLES `mahasiswa` WRITE;
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;
INSERT INTO `mahasiswa` VALUES (1,5,'2322101976','Selma Shakila Andyana Putri','Akila','2 RPLK','L','RPLK','2','2026-08-16 08:06:58','2026-08-16 08:06:58'),(2,6,'2423101991','Achmad Fatih Binasiilah','Fatih','2 RPLK','L','RPLK','2','2026-08-16 08:06:58','2026-08-16 08:06:58'),(3,7,'2423101994','Ahmad Muflih Izfatara','Muflih','2 RPLK','L','RPLK','2','2026-08-16 08:06:58','2026-08-16 08:06:58'),(4,8,'2423102007','Boyke Charish Situmeang','Boy','2 RPLK','L','RPLK','2','2026-08-16 08:06:58','2026-08-16 08:06:58'),(5,9,'2423102017','Dini Riyani Oktavia','Tavi','2 RPLK','L','RPLK','2','2026-08-16 08:06:58','2026-08-16 08:06:58'),(6,10,'2423102018','Donny Rusdianysah','Rusdi','2 RPLK','L','RPLK','2','2026-08-16 08:06:58','2026-08-16 08:06:58'),(7,11,'2423102024','Farhan Regian Cahya Muharam','Aram','2 RPLK','L','RPLK','2','2026-08-16 08:06:58','2026-08-16 08:06:58'),(8,12,'2423102025','Farid Ali Wafi','Alwa','2 RPLK','L','RPLK','2','2026-08-16 08:06:58','2026-08-16 08:06:58'),(9,13,'2423102027','Fathan Mawla Itzwa','Fathan','2 RPLK','L','RPLK','2','2026-08-16 08:06:58','2026-08-16 08:06:58'),(10,14,'2423102030','Hany Mahsa Lysandra Tarigan','Lysa','2 RPLK','L','RPLK','2','2026-08-16 08:06:58','2026-08-16 08:06:58'),(11,15,'2423102037','Jonathan Kevin Binsar Pangaribuan','Joke','2 RPLK','L','RPLK','2','2026-08-16 08:06:58','2026-08-16 08:06:58'),(12,16,'2423102038','Justin Wismar Tobing','Justin','2 RPLK','L','RPLK','2','2026-08-16 08:06:58','2026-08-16 08:06:58'),(13,17,'2423102043','Marsantya Haleza Mawa','Haleza','2 RPLK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(14,18,'2423102044','Marsya Tsabitah Yustin','Marsya','2 RPLK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(15,19,'2423102048','Muhammad Amirul Haqa Ardi','Haqa','2 RPLK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(16,20,'2423102059','Mutiara Cahyaning Utami','Aya','2 RPLK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(17,21,'2423102062','Nufri Rafif','Nufri','2 RPLK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(18,22,'2423102072','Rezen Kova Renita Pratama','Rezen','2 RPLK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(19,23,'2423102077','Ruben Gabe Aditya Panjaitan','Ruben','2 RPLK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(20,24,'2423102080','Salsabila Syifa Farah Febrina','Farah','2 RPLK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(21,25,'2423102094','Zefanya Raditya Pratama','Zefa','2 RPLK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(22,26,'2423102095','Zhafran Riko Santoso','Zhafran','2 RPLK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(23,27,'2423101992','Adam Raihan Prasedya','Edya','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(24,28,'2423101993','Ahmad Ghani Nurkhadian','Marnat','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(25,29,'2423101995','Aiko Senyum Indra Nugraha','Aiko','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(26,30,'2423102000','Aqilah Putri Meylani S','Meyla','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(27,31,'2423102014','Dimas Ardiyansyah','Masdim','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(28,32,'2423102019','Edra Fernanda','Eder','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(29,33,'2423102032','Helza Aura Ferdani','Helza','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(30,34,'2423102034','Ida Ayu Mas Putri Kemala Dewi','Dayu','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(31,35,'2423102052','Muhammad Fauzil Fadhil','Uzil','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(32,36,'2423102060','Ni Made Dwi Armalayanti','Mala','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(33,37,'2423102064','Rafa Shafaudin Athaillah','Udin','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(34,38,'2423102066','Raffi Anantha Setiawan','Anan','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(35,39,'2423102068','Rahma Bima Algestiyano','Alge','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(36,40,'2423102069','Rangga Firman Syarif','RF','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(37,41,'2423102076','Rizky Zakariya','Riza','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(38,42,'2423102082','Septian Izya Pradana','Ayzi','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(39,43,'2423102083','Septian Trio Laksana','Trio','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(40,44,'2423102084','Stevent Imanuel Ginting','Nuel','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(41,45,'2423102085','Syifa Maulia Fadila','Syifa','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(42,46,'2423102086','Viki Maulana','Kipli','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(43,47,'2423102092','Zamir Achmad Sachio','Chio','2 RPKK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(44,48,'2423101996','Althaf Bilal Jubran','Althaf','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(45,49,'2423101997','Alyaa Mahiraah Ramadhani','Hira','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(46,50,'2423102003','Asyifa Alya Nabila','Ayla','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(47,51,'2423102010','Daffa Zaidan Eto\'o','Etoo','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(48,52,'2423102011','Damar','Damar','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(49,53,'2423102012','Dava Anugrah Putra','Bob','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(50,54,'2423102015','Dimas Surya Pratama','Dimsur','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(51,55,'2423102023','Falito Eriano Nainggolan','Lito','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(52,56,'2423102028','Gita Olivia Silaban','Ivi','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(53,57,'2423102033','Hinggil Parahita','Hinggil','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(54,58,'2423102039','Luklu Miranda','Luklu','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(55,59,'2423102047','Muhammad Agung Nafsi Aminullah','Nafsi','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(56,60,'2423102055','Muhammad Reza Al Ichwan','Al','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(57,61,'2423102058','Mukhammad Rizal Maulana','Lana','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(58,62,'2423102065','Raffelino Hizkia Marbun','Lino','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(59,63,'2423102067','Rahadian Ronggo Kusumo','Goku','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(60,64,'2423102070','Reiza Gerrard Rizki Ramadhan','Gerrard','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(61,65,'2423102071','Retta Kresensia Br Sembiring','Cia','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(62,66,'2423102075','Rizky Herdiansyah Ramadhan','Kiher','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(63,67,'2423102089','Yosapat Nainggolan','Yosan','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(64,68,'2423102093','Zebi Nurlestari Asmoro','Zebi','2 RKS A','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(65,69,'2423101998','Andreas Castropasu Sibarani','Castro','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(66,70,'2423101999','Aniparadja','Anip','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(67,71,'2423102001','Arya Sinarta Sihite','Narta','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(68,72,'2423102002','Asih Wulandaiva P','Wulan','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(69,73,'2423102005','Aurel Dwi Cahyono','Rely','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(70,74,'2423102006','Bintang Nur Hidayah Putri','Binta','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(71,75,'2423102016','Dinda Atika Rahmah','Ika','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(72,76,'2423102021','Evan Perwira Abednego','Dego','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(73,77,'2423102029','Haidar Fauzul Kusnadi','Zul','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(74,78,'2423102042','Made Ayu Ratna D. S.','Dweta','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(75,79,'2423102049','Muhammad Azril','Azril','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(76,80,'2423102050','Muhammad Dafa Ray Stahanif','Ray','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(77,81,'2423102051','Muhammad Daniel Cello Pratama','Cello','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(78,82,'2423102054','Muhammad Pandu Praja','Praja','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(79,83,'2423102057','Muhammad Umar','Emyu','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(80,84,'2423102061','Niswatun Nur Farida','Niswa','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(81,85,'2423102063','Putra Adhi Aqsha','Aqsha','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(82,86,'2423102078','Ruth Devina Graceila Hutabarat','Ruth','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(83,87,'2423102079','Sabina Ratu Putri','Bina','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(84,88,'2423102091','Zahra\' Salsabila Fitria Merlyn','Merlyn','2 RSK','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(85,89,'2423102004','Atika Rahma','Tira','2 RKS B','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(86,90,'2423102008','Britania Paria Delta Siburian','Tania','2 RKS B','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(87,91,'2423102009','Christine Nauli Febiana S','Febi','2 RKS B','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(88,92,'2423102013','Della Risava Silaban','Risav','2 RKS B','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(89,93,'2423102020','Eulia Radifa Meilinawati','Difa','2 RKS B','L','RPLK','2','2026-08-16 08:06:59','2026-08-16 08:06:59'),(90,94,'2423102022','Fakhri Ahmad Asyafi\'i','Fri','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(91,95,'2423102026','Faris Rahmadin','Fadin','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(92,96,'2423102031','Hasan Almusanna Albaar','Nasa','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(93,97,'2423102035','Irsyad Arif Firmansyah','Irsyad','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(94,98,'2423102036','Jessica Avrilia Br Simatupang','Jessi','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(95,99,'2423102040','M. Adib Arkan','Diboy','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(96,100,'2423102041','M. Deonardo Federicko','Deo','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(97,101,'2423102045','Michael Ridho Waster Pakpahan','Waster','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(98,102,'2423102046','Muhaimin Murdiyanto','Imin','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(99,103,'2423102053','Muhammad Fernanda Irawan','Feno','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(100,104,'2423102056','Muhammad Rizq Dewangga','Wangga','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(101,105,'2423102073','Rivaldi Abdullah','Valid','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(102,106,'2423102074','Rizal Hadi Fadillah Riyadi','Riyad','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(103,107,'2423102087','Yahfi Al Farisy','Alfa','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(104,108,'2423102088','Yanuar Ubeth Taruna Wibawa','Ubeth','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(105,109,'2423102090','Yusuf Fahar Prasli Irsyad','Fahar','2 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(106,115,'2524102097','Abel Ihsan Renjiro','Jiro','1 RKS A','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(107,116,'2524102099','Alifiarka Shinta Basmalama','Alifiarka','1 RKS A','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(108,117,'2524102106','Aurora Harnov','Aurora','1 RKS A','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(109,118,'2524102107','Azkhia Bagir Alfarisi','Azki','1 RKS A','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(110,119,'2524102112','Diky Dwi Saputra Ginting','Diky','1 RKS A','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(111,120,'2504102114','Farhan Fadly','Farhan','1 RKS A','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(112,121,'2524102117','Hamuda Fahri','Hamud','1 RKS A','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(113,122,'2524102125','Muhammad Faridfayyad Danial','Muhammad','1 RKS A','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(114,123,'2524102126','Mutiara Ayudya Yuwan','Mutiara','1 RKS A','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(115,124,'2524102132','Olfifaisa Mahaliya Sholeha','Olfifaisa','1 RKS A','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(116,125,'2524102145','Yemima Elira Puteri','Yemima','1 RKS A','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(117,126,'2524102096','Abdul Hafizh Burmelli','Abdul','1 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(118,127,'2524102100','Amanda Dwi Agnistyanida','Amanda','1 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(119,128,'2524102103','Arya Bima Rafa Hanindityo','Arya','1 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(120,129,'2524102111','Christian Natanael Sirait','Christian','1 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(121,130,'2524102113','Dimas Zaki Anwar','Dimas','1 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(122,131,'2524102116','Farrel Evan Lase','Farrel','1 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(123,132,'2524102118','Hizkia Partogi Sihombing','Hizkia','1 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(124,133,'2524102119','Jhe Jian Karenina Sashu','Jhe','1 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(125,134,'2524102127','Nabilah','Nabilah','1 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(126,135,'2524102133','Philip Simanjuntak','Philip','1 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(127,136,'2524102134','Qoidatul Husna Mazidah','Qoidatul','1 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(128,137,'2524102143','Tsania Naja Afifah','Tsania','1 RKS B','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(129,138,'2524102104','Atalla Arya Harimurti Sulistyo','Atalla','1 RPKK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(130,139,'2524102120','Keifa Dinnaya Nadya Shafwa','Keifa','1 RPKK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(131,140,'2524102122','M. Hilmi Taqiyyuddin','Hilmi','1 RPKK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(132,141,'2524102129','Nasywa Larisa','Nasywa','1 RPKK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(133,142,'2524102146','Nayla Rachmawati','Nayla','1 RPKK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(134,143,'2524102130','Nicholas Zen','Nicholas','1 RPKK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(135,144,'2524102139','Said Irfan Halim','Said','1 RPKK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(136,145,'2524102098','Al Mayra Bilahizza Yusuf','Almayra','1 RPLK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(137,146,'2524102101','Annisa Kireida Mahtabila','Annisa','1 RPLK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(138,147,'2524102102','Arga Samuel Simanjuntak','Arga','1 RPLK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(139,148,'2524102105','Atha Syahda Alhaibah','Atha','1 RPLK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(140,149,'2524102109','Bonar Judika Marbun','Bonar','1 RPLK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(141,150,'2524102124','Muhamad Haikal Masriqi','Muhamad','1 RPLK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(142,151,'2524102131','Odette Pinandita Gunawan','Odette','1 RPLK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(143,152,'2524102135','Queentania Dara Chulfikar','Queentania','1 RPLK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(144,153,'2524102137','Rasya Naufal','Rasya','1 RPLK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(145,154,'2524102138','Rizki Nanda Syahputra Pasaribu','Rizki','1 RPLK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(146,155,'2524102108','Balqis Aqilla Nur Asy-Syifa','Balqis','1 RSK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(147,156,'2524102110','Bunga Aulia','Bunga','1 RSK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(148,157,'2524102115','Farrel Andhika Putra','Farrel','1 RSK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(149,158,'2524102121','Lasro Yogi Situmorang','Lasro','1 RSK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(150,159,'2524102123','Maretta Marid Cahyaning Cantika','Maretta','1 RSK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(151,160,'2524102128','Naila Ratnafuri','Naila','1 RSK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(152,161,'2524102136','Rajendra Edmund Daniel','Rajendra','1 RSK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(153,162,'2524102141','Sausan Nuha Thufailah','Sausan','1 RSK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(154,163,'2524102142','Talita Azalia Dhafa','Talita','1 RSK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00'),(155,164,'2524102144','Voleta Aura','Voleta','1 RSK','L','RPLK','2','2026-08-16 08:07:00','2026-08-16 08:07:00');
/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2026_03_09_032828_create_poin_mahasiswa_table',1),(6,'2026_03_09_130556_create_acara_table',1),(7,'2026_03_10_030000_create_surat_table',1),(8,'2026_03_10_040000_add_profile_fields_to_users_table',1),(9,'2026_05_10_000001_add_role_to_users_table',1),(10,'2026_06_01_000000_create_activity_logs_table',1),(11,'2026_06_10_121344_add_taruna_fields_to_surat_table',2),(12,'2026_06_17_085348_create_kelas_table',3),(13,'2026_06_17_085357_add_mahasiswa_fields_to_users_table',3),(14,'2024_01_01_000001_create_berita_taruna_table',4),(15,'2026_06_12_064812_change_nilai_column_type_in_poin_mahasiswa_table',4),(16,'2026_08_14_041740_add_prodi_to_users_table',5),(17,'2026_08_14_042340_create_mahasiswa_table',5),(18,'2026_08_14_042341_add_mahasiswa_id_to_poin_mahasiswa_table',5),(19,'2026_08_14_043310_add_npm_nickname_kelas_to_mahasiswa_table',5),(20,'2026_08_16_110110_create_apel_table',5),(21,'2026_08_16_114050_rename_role_penyelenggara_to_admin',5),(22,'2026_08_16_130526_create_pengasuh_table',6),(23,'2026_08_16_130527_create_jadwal_pengasuh_table',6),(24,'2026_08_16_132333_create_akses_fitur_table',6),(25,'2026_08_16_132333_create_duty_taruna_table',6),(26,'2026_08_16_134311_create_konsinyir_table',6),(27,'2026_08_16_143000_create_log_pergerakan_table',7),(28,'2026_08_16_150000_add_validation_and_pttt_fields_to_poin_mahasiswa_table',8),(29,'2026_08_16_140000_create_keluhan_barak_table',9),(30,'2026_08_17_051718_create_reward_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengasuh`
--

DROP TABLE IF EXISTS `pengasuh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengasuh` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `hari` enum('senin','selasa','rabu','kamis','jumat','sabtu','minggu') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengasuh_hari_unique` (`hari`),
  KEY `pengasuh_user_id_foreign` (`user_id`),
  CONSTRAINT `pengasuh_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengasuh`
--

LOCK TABLES `pengasuh` WRITE;
/*!40000 ALTER TABLE `pengasuh` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengasuh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poin_mahasiswa`
--

DROP TABLE IF EXISTS `poin_mahasiswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poin_mahasiswa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` bigint(20) unsigned DEFAULT NULL,
  `npm` varchar(20) NOT NULL,
  `nama_mahasiswa` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `kategori` enum('prestasi','pelanggaran') NOT NULL,
  `tingkat` varchar(255) DEFAULT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `nilai` double(8,2) NOT NULL,
  `status_validasi` varchar(255) NOT NULL DEFAULT 'disetujui',
  `pengasuh` varchar(255) NOT NULL,
  `diajukan_oleh_id` bigint(20) unsigned DEFAULT NULL,
  `divalidasi_oleh_id` bigint(20) unsigned DEFAULT NULL,
  `waktu_validasi` datetime DEFAULT NULL,
  `catatan_validasi` text DEFAULT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `poin_mahasiswa_mahasiswa_id_foreign` (`mahasiswa_id`),
  CONSTRAINT `poin_mahasiswa_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poin_mahasiswa`
--

LOCK TABLES `poin_mahasiswa` WRITE;
/*!40000 ALTER TABLE `poin_mahasiswa` DISABLE KEYS */;
INSERT INTO `poin_mahasiswa` VALUES (1,NULL,'2322101976','Selma Shakila Andyana Putri','2 RPLK','prestasi',NULL,'k','2026-06-09',1.00,'disetujui','nufri',NULL,NULL,NULL,NULL,NULL,'kh','2026-06-08 21:11:18','2026-06-08 21:11:18'),(2,NULL,'2423102038','Justin Wismar Tobing','2 RPLK','prestasi',NULL,'Lomba Scrable','2026-06-09',3.00,'disetujui','Hadyan',NULL,NULL,NULL,NULL,NULL,'Menang lomba juara 1 scrable','2026-06-08 21:50:05','2026-06-08 21:50:05'),(3,NULL,'2423102038','Justin Wismar Tobing','2 RPLK','pelanggaran',NULL,'Jam Malam','2026-06-08',1.00,'disetujui','Hadyan',NULL,NULL,NULL,NULL,NULL,'Melanggar Jam Malam beraktivitas lebih dari jam 10','2026-06-08 21:51:42','2026-06-08 21:51:42'),(4,NULL,'2423102095','Zhafran Riko Santoso','2 RPLK','prestasi',NULL,'Lomba','2026-06-10',3.00,'disetujui','Penyelenggara',NULL,NULL,NULL,NULL,NULL,'Lomba scrable','2026-06-09 23:34:26','2026-06-09 23:34:26'),(5,NULL,'2423102095','Zhafran Riko Santoso','2 RPLK','pelanggaran',NULL,'jam malam','2026-06-10',1.00,'disetujui','Penyelenggara',NULL,NULL,NULL,NULL,NULL,'melanggar jam malam','2026-06-09 23:34:48','2026-06-09 23:34:48'),(6,NULL,'2423102038','Justin Wismar Tobing','2 RPLK','pelanggaran',NULL,'jam malam','2026-06-10',4.00,'disetujui','Penyelenggara',NULL,NULL,NULL,NULL,NULL,'melanggar jam malam','2026-06-10 00:40:55','2026-06-10 00:40:55'),(7,NULL,'2423102028','Gita Olivia Silaban','2 RKS A','prestasi',NULL,'Lomba','2026-06-10',4.00,'disetujui','Penyelenggara',NULL,NULL,NULL,NULL,NULL,'Lomba Hackathon','2026-06-10 00:49:34','2026-06-10 00:49:34'),(8,NULL,'2423102037','Jonathan Kevin Binsar Pangaribuan','2 RPLK','prestasi',NULL,'Lomba Code The Future','2026-05-30',3.00,'disetujui','Penyelenggara',NULL,NULL,NULL,NULL,NULL,'Juara 3 Capture The Flag cabang Lomba Hackathon','2026-06-10 04:48:26','2026-06-10 04:48:26'),(9,NULL,'2423102037','Jonathan Kevin Binsar Pangaribuan','2 RPLK','prestasi',NULL,'Lomba Gunadarma Code Week','2025-07-30',3.00,'disetujui','Penyelenggara',NULL,NULL,NULL,NULL,NULL,'Juara Harapan 1 Lomba Gunadarma Code Week cabang lomba Hackathon','2026-06-10 04:51:17','2026-06-10 04:51:17'),(10,NULL,'2524102097','Abel Ihsan Renjiro','1 RKS A','prestasi',NULL,'Sertifikasi Akademik/Non-akademik Tingkat Nasional','2026-06-17',0.70,'disetujui','Penyelenggara',NULL,NULL,NULL,NULL,NULL,'lombaa nasional','2026-06-17 03:35:52','2026-06-17 03:35:52'),(11,1,'2322101976','Selma Shakila Andyana Putri','2 RPLK','pelanggaran','sedang','Keluar asrama tanpa izin dinas (Pesiar Liar)','2026-08-16',20.00,'disetujui','Pengasuh Demo',NULL,NULL,NULL,NULL,NULL,NULL,'2026-08-16 08:07:12','2026-08-16 08:07:12'),(12,1,'2322101976','Selma Shakila Andyana Putri','2 RPLK','pelanggaran','sedang','Merokok di lingkungan asrama','2026-08-16',20.00,'disetujui','Pengasuh Demo',NULL,NULL,NULL,NULL,NULL,NULL,'2026-08-16 08:07:12','2026-08-16 08:07:12'),(13,1,'2322101976','Selma Shakila Andyana Putri','2 RPLK','pelanggaran','ringan','Terlambat apel pagi','2026-08-16',10.00,'disetujui','Pengasuh Demo',NULL,NULL,NULL,NULL,NULL,NULL,'2026-08-16 08:07:12','2026-08-16 08:07:12'),(14,1,'2322101976','Selma Shakila Andyana Putri','2 RPLK','prestasi','nasional','Juara 1 Lomba Karya Tulis Ilmiah Nasional Aviation','2026-08-16',30.00,'disetujui','Pengasuh Demo',NULL,NULL,NULL,NULL,NULL,NULL,'2026-08-16 08:07:12','2026-08-16 08:07:12'),(15,1,'2322101976','Selma Shakila Andyana Putri','2 RPLK','pelanggaran','berat','Tindakan indisipliner berat perpeloncoan','2026-08-16',50.00,'disetujui','Pengasuh Demo',NULL,NULL,NULL,NULL,NULL,NULL,'2026-08-16 08:07:24','2026-08-16 08:07:24'),(16,1,'2322101976','Selma Shakila Andyana Putri','2 RPLK','pelanggaran','ringan','Atribut seragam tidak lengkap saat dinas jaga','2026-08-16',5.00,'disetujui','Imas Purbasari',110,2,'2026-08-16 15:07:35',NULL,NULL,NULL,'2026-08-16 08:07:35','2026-08-16 08:07:35'),(17,106,'2524102097','Abel Ihsan Renjiro','1 RKS A','pelanggaran','ringan','Menggunakan sandal / pakaian non-standar di area terlarang','2026-08-27',5.00,'menunggu_validasi','Pengasuh',167,NULL,NULL,NULL,NULL,'menggunakan sandal','2026-08-27 01:22:06','2026-08-27 01:22:06'),(18,106,'2524102097','Abel Ihsan Renjiro','1 RKS A','pelanggaran','ringan','Tidak memakai papan nama / badge / pin taruna','2026-08-27',5.00,'disetujui','Pengasuh',167,169,'2026-09-06 15:24:17',NULL,NULL,'tidak memakai papan nama','2026-08-27 01:22:27','2026-09-06 08:24:17');
/*!40000 ALTER TABLE `poin_mahasiswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reward`
--

DROP TABLE IF EXISTS `reward`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reward` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `mahasiswa_id` bigint(20) unsigned DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `npm` varchar(20) DEFAULT NULL,
  `prodi` varchar(10) DEFAULT NULL,
  `tingkat` varchar(5) DEFAULT NULL,
  `jenis` enum('individu','kelompok') NOT NULL DEFAULT 'individu',
  `jumlah_anggota` int(10) unsigned DEFAULT NULL,
  `kategori` varchar(20) NOT NULL,
  `tanggal_prestasi` date NOT NULL,
  `keterangan` text NOT NULL,
  `dokumen` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`dokumen`)),
  `status` varchar(20) NOT NULL DEFAULT 'Diajukan',
  `catatan_pengasuhan` text DEFAULT NULL,
  `taruna_baca` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reward_user_id_foreign` (`user_id`),
  KEY `reward_mahasiswa_id_foreign` (`mahasiswa_id`),
  KEY `reward_tanggal_prestasi_index` (`tanggal_prestasi`),
  KEY `reward_status_index` (`status`),
  CONSTRAINT `reward_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reward_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reward`
--

LOCK TABLES `reward` WRITE;
/*!40000 ALTER TABLE `reward` DISABLE KEYS */;
/*!40000 ALTER TABLE `reward` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat`
--

DROP TABLE IF EXISTS `surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surat` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `diajukan_oleh` varchar(255) DEFAULT NULL,
  `nomor_surat` varchar(255) DEFAULT NULL,
  `jenis_surat` enum('Surat Proposal','Surat Izin','Surat Permohonan','Surat Keterangan','Surat Undangan','Surat Tugas','Surat Lainnya') NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `pengirim` varchar(255) NOT NULL,
  `penerima` varchar(255) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `tanggal_terima` date DEFAULT NULL,
  `status` enum('Diproses','Disetujui','Ditolak','Selesai') NOT NULL DEFAULT 'Diproses',
  `keterangan` text DEFAULT NULL,
  `catatan_pengasuhan` text DEFAULT NULL,
  `taruna_baca` tinyint(1) NOT NULL DEFAULT 0,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat`
--

LOCK TABLES `surat` WRITE;
/*!40000 ALTER TABLE `surat` DISABLE KEYS */;
INSERT INTO `surat` VALUES (1,NULL,NULL,'SENKORPSTAR/D41.007/PH.068/KM.05.03/IV/2026','Surat Proposal','Permohonan Izin Mengikuti Acara  Build  with  AI  Bogor  2026 ΓÇ£Mobile App and Web  SessionΓÇ¥','Biro Siber','Pengasuhan','2026-04-23','2026-06-10','Disetujui','Surat proposal pengajuan kegiatan GDGOC',NULL,0,'surat/hfdgGpcIJxk5X2zt29MaytlNsMGmPRhmRe8XfPZ4.pdf','2026-06-09 01:05:38','2026-06-09 20:11:51'),(2,NULL,NULL,'SENKORPSTAR/D41.009/PH.095/KM.05.03/V/2026','Surat Proposal','Permohonan Izin Mengikuti Acara Build with  AI x JuaraVibeCoding: Breaking Limits, Building  Impact','Biro Siber','Pengasuhan','2026-06-08',NULL,'Ditolak','Kegiatan GDGOC di Binus Alsut',NULL,0,'surat/xddBPZg5yQEKlKl6G1jWBQkkkb2ngTvVdtTE0RKq.pdf','2026-06-09 20:11:24','2026-06-09 23:28:06');
/*!40000 ALTER TABLE `surat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `npm` varchar(255) DEFAULT NULL,
  `kelas_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `nama_panggilan` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'taruna',
  `no_telepon` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `prodi` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_npm_unique` (`npm`),
  KEY `users_kelas_id_foreign` (`kelas_id`),
  CONSTRAINT `users_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,NULL,NULL,'Penyelenggara Pengasuhan','penyelenggara',NULL,'penyelenggara@ppicurug.ac.id','admin',NULL,'Penyelenggara Pengasuhan',NULL,'profile/NaxnbWKdiHr1RYD5BbJjQitszVUM2T49lUooGPzA.png',NULL,'$2y$12$JjiU3ppRS/vp51OhUTFma.9eMUhID0r4CubRxF57JSwKjrMMUj5CO','IxZ7yyV4QRchLd5zrxP4RGMJRhmY32nnQK0WbDSXxtso1J6JW3oH64JwKQjC','2026-06-08 01:16:51','2026-08-27 00:34:27'),(5,'2322101976',1,'Selma Shakila Andyana Putri','akila','Akila','selma.shakila@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$94SSxPzgQNsf5m21EQ0v7OkS.xk5x67jc1zEqN4SUmk4jpwBwrME.',NULL,'2026-06-08 01:16:54','2026-06-17 01:55:44'),(6,'2423101991',1,'Achmad Fatih Binasiilah','fatih','Fatih','achmad.fatih@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$b5V2bOJVFc7ghSmS8g9DauuKewPvuEO76fPugNHC9lSRTvC91G89K',NULL,'2026-06-08 01:16:54','2026-06-17 01:55:44'),(7,'2423101994',1,'Ahmad Muflih Izfatara','muflih','Muflih','ahmad.muflih@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$/viziYxHYpu54NYDAjGrEeDzeg.x3URzKkwYGMWCvVXREAtViqxXq',NULL,'2026-06-08 01:16:55','2026-06-17 01:55:45'),(8,'2423102007',1,'Boyke Charish Situmeang','boy','Boy','boyke.charish@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$Z/thHLtLmhnluScuwpIiU.kHg85q13E.BJD0B/5j4QvL3dgazA..S',NULL,'2026-06-08 01:16:55','2026-06-17 01:55:45'),(9,'2423102017',1,'Dini Riyani Oktavia','tavi','Tavi','dini.riyani@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$8CXa8HCmwnk0gMu/SHltCO4FTjelYKSxtdZGKwFMJDSvd.MSqGz7W',NULL,'2026-06-08 01:16:56','2026-06-17 01:55:46'),(10,'2423102018',1,'Donny Rusdianysah','rusdi','Rusdi','donny.rusdianysah@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$eLDeDAIEAWMb2cgtu.mZDeC4KCrpSQna2OAu4JbdpY0dhyWCpKZte',NULL,'2026-06-08 01:16:56','2026-06-17 01:55:47'),(11,'2423102024',1,'Farhan Regian Cahya Muharam','aram','Aram','farhan.regian@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$L2G3lUQi3k5sKK5K12au/us0BeF1S5pphbvvebRehT27cTBURDoFG',NULL,'2026-06-08 01:16:56','2026-06-17 01:55:47'),(12,'2423102025',1,'Farid Ali Wafi','alwa','Alwa','farid.ali@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$8Ldf.RSH3eMTmZez7Yi15O2Lrp8cmc.w29090v1wMoPlec0eR/J.m',NULL,'2026-06-08 01:16:57','2026-06-17 01:55:47'),(13,'2423102027',1,'Fathan Mawla Itzwa','fathan','Fathan','fathan.mawla@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$DDx9so6v6Ld38994IiEu8eBNvjpZ1Ufa2AnqlWMjmp.oBq2/4COei',NULL,'2026-06-08 01:16:57','2026-06-17 01:55:48'),(14,'2423102030',1,'Hany Mahsa Lysandra Tarigan','lysa','Lysa','hany.mahsa@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$Qq3pX7.LDRj0qAcu0AL/oOomXV8RqBThlnd2ZhkgNFYux5aQ9PQlq',NULL,'2026-06-08 01:16:58','2026-06-17 01:55:48'),(15,'2423102037',1,'Jonathan Kevin Binsar Pangaribuan','joke','Joke','jonathan.kevin@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$E.UPqC5LW45XrCOGBTBqzeN5/ajIVIxj4NnQyt3KmMrpKofKG3F7W',NULL,'2026-06-08 01:16:58','2026-06-17 01:55:49'),(16,'2423102038',1,'Justin Wismar Tobing','justin','Justin','justin.wismar@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$nnCs/idaT834yE7dtBmD6eOcAtKQ48VQ9NPMPjqb/PKaPw8.P0Ve.',NULL,'2026-06-08 01:16:58','2026-06-17 01:55:50'),(17,'2423102043',1,'Marsantya Haleza Mawa','haleza','Haleza','marsantya.haleza@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$NKGHeKHu1m9gQlXs3vahhOfXBDLVLSB109OheQ2mN6vwwmlfvLD5q',NULL,'2026-06-08 01:16:59','2026-06-17 01:55:50'),(18,'2423102044',1,'Marsya Tsabitah Yustin','marsya','Marsya','marsya.tsabitah@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$A5KWOx61TPvK/06iJujXv.bWkHo8Rkej61FySi1BMibYvith4gaX.',NULL,'2026-06-08 01:16:59','2026-06-17 01:55:51'),(19,'2423102048',1,'Muhammad Amirul Haqa Ardi','haqa','Haqa','muhammad.amirul@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$HHC1LXIGIBodsSs4E9RzBeiz1NXCtEsDKsF4MOpVMtZIK0ZCVGI02',NULL,'2026-06-08 01:17:00','2026-06-17 01:55:51'),(20,'2423102059',1,'Mutiara Cahyaning Utami','aya','Aya','mutiara.cahyaning@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$eX5G2ESn1UOOqmwlKudz7uLK7I/QhoMn7Xddd/pOhP3T0hSsJAzom',NULL,'2026-06-08 01:17:00','2026-06-17 01:55:52'),(21,'2423102062',1,'Nufri Rafif','nufri','Nufri','nufri.rafif@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$CCshv58i5mTA5lFZ.J9Co.JObKIZVeGQ23tBWL96n6DBiNWrJqt0.',NULL,'2026-06-08 01:17:01','2026-06-17 01:55:52'),(22,'2423102072',1,'Rezen Kova Renita Pratama','rezen','Rezen','rezen.kova@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$JcbIw/SexUBImUHKTtj9zOF2WVzk9WVulO5YGn9ZsxeR.qS0w6amK',NULL,'2026-06-08 01:17:01','2026-06-17 01:55:53'),(23,'2423102077',1,'Ruben Gabe Aditya Panjaitan','ruben','Ruben','ruben.gabe@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$znL6y244LY73jOW8.02/.ezhch1YsFlX4zRwihHIi8vC8w6hjPyAm',NULL,'2026-06-08 01:17:01','2026-06-17 01:55:53'),(24,'2423102080',1,'Salsabila Syifa Farah Febrina','farah','Farah','salsabila.syifa@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$UPcnd1rn12UtzaCySzZ7LuBvGXxyz2/2eXaV1ck8y8kTY7RSqvvUe',NULL,'2026-06-08 01:17:02','2026-06-17 01:55:54'),(25,'2423102094',1,'Zefanya Raditya Pratama','zefa','Zefa','zefanya.raditya@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$vORXrQh3dJIXoPSUsGALC.tLsk.D3Ij4YpNsnMFQ0b8oLw86HE/5S',NULL,'2026-06-08 01:17:02','2026-06-17 01:55:54'),(26,'2423102095',1,'Zhafran Riko Santoso','zhafran','Zhafran','zhafran.riko@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPLK',NULL,NULL,NULL,'$2y$12$S1/tB1oSMYAukRe0/.4I1O.II85IXUU0.K3Bc9G9EHPDGz7ig7XT2',NULL,'2026-06-08 01:17:03','2026-06-17 01:55:55'),(27,'2423101992',2,'Adam Raihan Prasedya','edya','Edya','adam.raihan@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$vhg2.zIrV7k0ti3tU9s6p.9gbQk8e5i9Zf8aEfHwO1Fp4PlG5uz2u',NULL,'2026-06-08 01:17:03','2026-06-17 01:55:55'),(28,'2423101993',2,'Ahmad Ghani Nurkhadian','marnat','Marnat','ahmad.ghani@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$z52MAPQ9CSWlsZ4nRHGcmerB.GWfFwFUPfYRi2/6KKr770HK4qKyq',NULL,'2026-06-08 01:17:03','2026-06-17 01:55:56'),(29,'2423101995',2,'Aiko Senyum Indra Nugraha','aiko','Aiko','aiko.senyum@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$4Tjs2GvArCiok2zAtEXHv.2X6k14S8Fx.7Hlr1x98uFNhCZafsuES',NULL,'2026-06-08 01:17:04','2026-06-17 01:55:56'),(30,'2423102000',2,'Aqilah Putri Meylani S','meyla','Meyla','aqilah.putri@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$8lyvVuE7PHQv4LUtIn0NYOghpOnnZyZJQwsz4eXZAZtpTPoDe5BJe',NULL,'2026-06-08 01:17:04','2026-06-17 01:55:57'),(31,'2423102014',2,'Dimas Ardiyansyah','masdim','Masdim','dimas.ardiyansyah@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$19BSqIc2Q5LgHdnHs1KJXu8FJ4ishtVMNKdBVmkTJFp9XP/FwzSii',NULL,'2026-06-08 01:17:05','2026-06-17 01:55:57'),(32,'2423102019',2,'Edra Fernanda','eder','Eder','edra.fernanda@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$KAuYCtp1KDvFnH.Ua0CMU.K/Cm0OGzuoq7ezKH/oaqKldTf3Au.mO',NULL,'2026-06-08 01:17:05','2026-06-17 01:55:57'),(33,'2423102032',2,'Helza Aura Ferdani','helza','Helza','helza.aura@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$TzRFoU51.tdfP5x9.0wHI.DMiIbV15REXqQQk8lkSt9LchMpd3BRu',NULL,'2026-06-08 01:17:05','2026-06-17 01:55:58'),(34,'2423102034',2,'Ida Ayu Mas Putri Kemala Dewi','dayu','Dayu','ida.ayu@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$kTx8GzHj0o/IwHhD3snozeDEd.vKxf0LFZRS2qqsb82JMOO/YTU/u',NULL,'2026-06-08 01:17:06','2026-06-17 01:55:58'),(35,'2423102052',2,'Muhammad Fauzil Fadhil','uzil','Uzil','muhammad.fauzil@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$1JOpku2CJDu4hu/RMCeVwesfISAGHSsY7bOhwiCyWMis4oL2DtQyS',NULL,'2026-06-08 01:17:06','2026-06-17 01:55:59'),(36,'2423102060',2,'Ni Made Dwi Armalayanti','mala','Mala','ni.made@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$7RoIihQovb4D8nQuLNZwzOfY2v2LwAgbTyIgsRLIHXFepJdV0fuTW',NULL,'2026-06-08 01:17:07','2026-06-17 01:55:59'),(37,'2423102064',2,'Rafa Shafaudin Athaillah','udin','Udin','rafa.shafaudin@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$yfCPoqJTu6g6dkHqEIurKexPbQgq7WDMXyvzIokmZocql49LE.jQ6',NULL,'2026-06-08 01:17:07','2026-06-17 01:56:00'),(38,'2423102066',2,'Raffi Anantha Setiawan','anan','Anan','raffi.anantha@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$JvJtY6YzoKWofmdyqAO1netaj85BzHdxuHIBVsO86io4g9x1n2JAW',NULL,'2026-06-08 01:17:07','2026-06-17 01:56:01'),(39,'2423102068',2,'Rahma Bima Algestiyano','alge','Alge','rahma.bima@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$m4qdEb4DnLOsp.EOuw00HOgFwUcPsu9t2K4nVaGg8auH39kQ7xXLi',NULL,'2026-06-08 01:17:08','2026-06-17 01:56:01'),(40,'2423102069',2,'Rangga Firman Syarif','rf','RF','rangga.firman@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$7.EwgjiLteKDpKtKMuki7.5m9NabKzhzQs3UAfualEiWIT0A1IaK.',NULL,'2026-06-08 01:17:08','2026-06-17 01:56:02'),(41,'2423102076',2,'Rizky Zakariya','riza','Riza','rizky.zakariya@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$uEhiHfI6.Mc0RuMCsjkbWOm6BZLYlLMHUxeaPYs4QoADw7y2wNwPO',NULL,'2026-06-08 01:17:09','2026-06-17 01:56:03'),(42,'2423102082',2,'Septian Izya Pradana','ayzi','Ayzi','septian.izya@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$1iCDqA/lUgVG4GAbejo1ceadPuWoDMnZ8W95Ki5Xo8mn1nzapoRiC',NULL,'2026-06-08 01:17:09','2026-06-17 01:56:04'),(43,'2423102083',2,'Septian Trio Laksana','trio','Trio','septian.trio@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$1WhegMU.Bv7QFKa.L26Ttef9B58ETioKTdAOxNPXw9CivuhukLnT.',NULL,'2026-06-08 01:17:10','2026-06-17 01:56:05'),(44,'2423102084',2,'Stevent Imanuel Ginting','nuel','Nuel','stevent.imanuel@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$foNhFuGFQ2y0rUt98qmmWegEO596ggfXjKFJei.06kukMNpwMNgha',NULL,'2026-06-08 01:17:10','2026-06-17 01:56:05'),(45,'2423102085',2,'Syifa Maulia Fadila','syifa','Syifa','syifa.maulia@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$CBsTlHA.Os1rKXlKZbKBs.dmJe7EdilZX5duDwc.UTSCr1r85kbvW',NULL,'2026-06-08 01:17:10','2026-06-17 01:56:07'),(46,'2423102086',2,'Viki Maulana','kipli','Kipli','viki.maulana@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$SnwcMGCdF1g0ATjr7JKtXO0wNhE3sNzQtBx./XM/sWUj2V29MFpn.',NULL,'2026-06-08 01:17:11','2026-06-17 01:56:07'),(47,'2423102092',2,'Zamir Achmad Sachio','chio','Chio','zamir.achmad@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RPKK',NULL,NULL,NULL,'$2y$12$QNhK591dOI8QRxhS.2FR2.aU7PIV5fAyRNLuKUADSL3dI2C8qGBgq',NULL,'2026-06-08 01:17:11','2026-06-17 01:56:07'),(48,'2423101996',3,'Althaf Bilal Jubran','althaf','Althaf','althaf.bilal@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$l9fSzllxMEOW6eMprGPIrO3bCIfP6.3gKRcdnBdzcKx1eMFpH0Lpm',NULL,'2026-06-08 01:17:11','2026-06-17 01:56:08'),(49,'2423101997',3,'Alyaa Mahiraah Ramadhani','hira','Hira','alyaa.mahiraah@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$JOUrkPjjnoJL4naWWIuiH.bvw1FRNrvjdxjM/TEV.NG4mZs4eU6nq',NULL,'2026-06-08 01:17:12','2026-06-17 01:56:08'),(50,'2423102003',3,'Asyifa Alya Nabila','ayla','Ayla','asyifa.alya@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$96q7dr7Q1F4FLjYRmnPWQOCU49ii...8O6G/4qyJk3cZpqLAX1obm',NULL,'2026-06-08 01:17:12','2026-06-17 01:56:09'),(51,'2423102010',3,'Daffa Zaidan Eto\'o','etoo','Etoo','daffa.zaidan@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$mTxRm7IE2pCKft70LBt/T.qZuOx2jPOA2HqiXgjH7N1vGclq1gC82',NULL,'2026-06-08 01:17:13','2026-06-17 01:56:09'),(52,'2423102011',3,'Damar','damar','Damar','damar@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$SVMZyKIIO2Xfflmrsb1o8OfmjRZcegU/cYVLVyhtnY7LXmOIAuI5S',NULL,'2026-06-08 01:17:13','2026-06-17 01:56:09'),(53,'2423102012',3,'Dava Anugrah Putra','bob','Bob','dava.anugrah@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$LwpFoLtaKm4WscD9BnE3xePkA/bG0Jnr9fow.I3zydKP0umbZBwp.',NULL,'2026-06-08 01:17:13','2026-06-17 01:56:10'),(54,'2423102015',3,'Dimas Surya Pratama','dimsur','Dimsur','dimas.surya@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$xvQV11fAEfDCdH1DIwBUm.fZ05/tUJ/VBGfXPG2AkjtZbvuMtDH.i',NULL,'2026-06-08 01:17:14','2026-06-17 01:56:10'),(55,'2423102023',3,'Falito Eriano Nainggolan','lito','Lito','falito.eriano@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$94pUMZ3zl690285YY7cMuesM6K.MkuRluQw3Id.GIMNlw5zmr19tm',NULL,'2026-06-08 01:17:14','2026-06-17 01:56:11'),(56,'2423102028',3,'Gita Olivia Silaban','ivi','Ivi','gita.olivia@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$HE../VkpFqwVdoqkg0OhbOMiI2APcpvhb9AMAJ/S4.A9mLhE6y/je',NULL,'2026-06-08 01:17:15','2026-06-17 01:56:11'),(57,'2423102033',3,'Hinggil Parahita','hinggil','Hinggil','hinggil.parahita@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$yVBh4RsZS2AwOgeA7oNTHO95UjV3SNXaEylMpvfkxFbGzxg77d5eW',NULL,'2026-06-08 01:17:15','2026-06-17 01:56:12'),(58,'2423102039',3,'Luklu Miranda','luklu','Luklu','luklu.miranda@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$MZ4jYQV7yBphOH7OPhIlJ.rX/3Varqatxk5X3VjtStXZrTx/6yUge',NULL,'2026-06-08 01:17:16','2026-06-17 01:56:12'),(59,'2423102047',3,'Muhammad Agung Nafsi Aminullah','nafsi','Nafsi','muhammad.agung@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$dknc/gXuoY8e0N5MDcl2geuBQIyraABzcg6Tovex3EEPVkfOKJCDa',NULL,'2026-06-08 01:17:16','2026-06-17 01:56:13'),(60,'2423102055',3,'Muhammad Reza Al Ichwan','al','Al','muhammad.reza@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$dnUk7AUnyKSYuyvB1CgAye68d.Wp.TZWCz8uGWYBk1ds16uKdnoRq',NULL,'2026-06-08 01:17:16','2026-06-17 01:56:14'),(61,'2423102058',3,'Mukhammad Rizal Maulana','lana','Lana','mukhammad.rizal@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$Y6al/TaFfGv87fZD9jOQFOKkCVOKATQ9E4pbsY.iot1/ecGg3Ifiu',NULL,'2026-06-08 01:17:17','2026-06-17 01:56:15'),(62,'2423102065',3,'Raffelino Hizkia Marbun','lino','Lino','raffelino.hizkia@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$KMRVX7JuWjV6xM30pLxEr.ghOELN4y8aL6gifqOAwbALfqluyqw6K',NULL,'2026-06-08 01:17:17','2026-06-17 01:56:15'),(63,'2423102067',3,'Rahadian Ronggo Kusumo','goku','Goku','rahadian.ronggo@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$V0qZANyMPIyNI0gTbwgWL.z15qhu3Whtuqq9GnT6eyl3S0nDCdfQK',NULL,'2026-06-08 01:17:18','2026-06-17 01:56:16'),(64,'2423102070',3,'Reiza Gerrard Rizki Ramadhan','gerrard','Gerrard','reiza.gerrard@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$Br4NbGbvAIVdFyUatVs8SePpsn8hLy/RDSnnmLOaHAALESmt1EhQ2',NULL,'2026-06-08 01:17:18','2026-06-17 01:56:17'),(65,'2423102071',3,'Retta Kresensia Br Sembiring','cia','Cia','retta.kresensia@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$dGDUoFtIEbLhZ9.m8A.1kOdMed1qCXrVfVFFGkV8Ro6ORQP21fKNa',NULL,'2026-06-08 01:17:18','2026-06-17 01:56:17'),(66,'2423102075',3,'Rizky Herdiansyah Ramadhan','kiher','Kiher','rizky.herdiansyah@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$ClJPkT8npOGeaHtRzKOnwu8EuY2PNBKswcedN9AHaAOzgN1.fTpHq',NULL,'2026-06-08 01:17:19','2026-06-17 01:56:18'),(67,'2423102089',3,'Yosapat Nainggolan','yosan','Yosan','yosapat.nainggolan@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$XPdeUAWfzeXpr5VUUfX55.7b74ee85NPJVx94h5SYwoLvPjFtU8tm',NULL,'2026-06-08 01:17:19','2026-06-17 01:56:20'),(68,'2423102093',3,'Zebi Nurlestari Asmoro','zebi','Zebi','zebi.nurlestari@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS A',NULL,NULL,NULL,'$2y$12$.MQN4Dy0BypBqyfcIBs7eOVMYLFC/iGm5UZOG9tBMOWWgeesJlvAq',NULL,'2026-06-08 01:17:19','2026-06-17 01:56:21'),(69,'2423101998',4,'Andreas Castropasu Sibarani','castro','Castro','andreas.castropasu@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$5OchQcwrnpSKyXRfYdzBb.g.kaDoIDGWSyiR/BTjtsdkIu.Kkj3xe',NULL,'2026-06-08 01:17:20','2026-06-17 01:56:22'),(70,'2423101999',4,'Aniparadja','anip','Anip','aniparadja@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$yQvPleagp/c6J.UnwS4La.oN1Sxgrl/TSi2mqUqatMzxN/KJuyQQ6',NULL,'2026-06-08 01:17:20','2026-06-17 01:56:23'),(71,'2423102001',4,'Arya Sinarta Sihite','narta','Narta','arya.sinarta@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$CuC9vlhNyEHS0neP1xaK1OBrE.PIwnBGCkYHRgZmQsVyKk64Blr8C',NULL,'2026-06-08 01:17:21','2026-06-17 01:56:23'),(72,'2423102002',4,'Asih Wulandaiva P','wulan','Wulan','asih.wulandaiva@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$RskdBDJYYEhM08xxhQiT9OjDmu8xCRP3HtHmJ0hItsPeDxN9taTSi',NULL,'2026-06-08 01:17:21','2026-06-17 01:56:24'),(73,'2423102005',4,'Aurel Dwi Cahyono','rely','Rely','aurel.dwi@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$TWq7HGrGN78UfkhGg5lqOeueWJOkk2AVDl.J2hK5SqRgtn6gDmVlm',NULL,'2026-06-08 01:17:21','2026-06-17 01:56:25'),(74,'2423102006',4,'Bintang Nur Hidayah Putri','binta','Binta','bintang.nur@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$fL.ERBDoO759UPMowmEGHuvRKgA1I2PtHb/PQtEnfmOOkGNSc1PRK',NULL,'2026-06-08 01:17:22','2026-06-17 01:56:26'),(75,'2423102016',4,'Dinda Atika Rahmah','ika','Ika','dinda.atika@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$Dw2cPG5PAN1ucA/sVNDeQuxEM4kY3pDZv/.24cETboBAHEuPQbTOm',NULL,'2026-06-08 01:17:22','2026-06-17 01:56:27'),(76,'2423102021',4,'Evan Perwira Abednego','dego','Dego','evan.perwira@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$Fo1.FFXO4VibqhgsY9Q/2eiJhu6.tfzS6HnuVTuF91qGh8XRzWycC',NULL,'2026-06-08 01:17:23','2026-06-17 01:56:28'),(77,'2423102029',4,'Haidar Fauzul Kusnadi','zul','Zul','haidar.fauzul@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$i.nQUFOR5aWVII0tyZIDYuGR4pPqZYZIXnX8XcbFAGodOY/7rCiH6',NULL,'2026-06-08 01:17:23','2026-06-17 01:56:29'),(78,'2423102042',4,'Made Ayu Ratna D. S.','dweta','Dweta','made.ayu@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$bhb0VWy/2LqfntBOsLmxIekd5ODWyu.tzqcsne7Derbt5T/iu7sXi',NULL,'2026-06-08 01:17:23','2026-06-17 01:56:30'),(79,'2423102049',4,'Muhammad Azril','azril','Azril','muhammad.azril@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$TLL3RFocvMKbOC2wYL8nQOYKpbnfkx3RbL1BRiJT8NdqbJClEIQA2',NULL,'2026-06-08 01:17:24','2026-06-17 01:56:30'),(80,'2423102050',4,'Muhammad Dafa Ray Stahanif','ray','Ray','muhammad.dafa@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$tVJ0Ka9gjvG9C7TcBhp1wOrCLrCZwvOrhBMxdnQs252J6Vd5FzlMm',NULL,'2026-06-08 01:17:24','2026-06-17 01:56:31'),(81,'2423102051',4,'Muhammad Daniel Cello Pratama','cello','Cello','muhammad.daniel@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$CDf1xkqy0KRsiJIhPMDrCuUBWTNBX8tqrtbPJ7YX/ApPMDyD8uR36',NULL,'2026-06-08 01:17:25','2026-06-17 01:56:31'),(82,'2423102054',4,'Muhammad Pandu Praja','praja','Praja','muhammad.pandu@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$hZvfcjLR8Md7g1Pz6fCK4uYct2WhoU2n2JsIF2BhKerDUdEDMPd4W',NULL,'2026-06-08 01:17:25','2026-06-17 01:56:32'),(83,'2423102057',4,'Muhammad Umar','emyu','Emyu','muhammad.umar@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$txSUH1SJllr1MPlGPf3MzezGyNCIPbsTKd.KyRLl3vFz2O5Ghiv/q',NULL,'2026-06-08 01:17:26','2026-06-17 01:56:32'),(84,'2423102061',4,'Niswatun Nur Farida','niswa','Niswa','niswatun.nur@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$Rw6ZYOe3tCfYk32/e2BRcuQS64iCpzot97vFFlscpftb6z1ssNxN2',NULL,'2026-06-08 01:17:26','2026-06-17 01:56:33'),(85,'2423102063',4,'Putra Adhi Aqsha','aqsha','Aqsha','putra.adhi@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$yRUJnJhULjafRYqgdYEqpOGVih9z82MFxaSXaayDF5DoCvNQG8cvO',NULL,'2026-06-08 01:17:27','2026-06-17 01:56:33'),(86,'2423102078',4,'Ruth Devina Graceila Hutabarat','ruth','Ruth','ruth.devina@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$3WGyPIQQpAhv9dFsoWZOZ.6nDZxZ4VD78Xh5TvpqVYuR7hajsBfAG',NULL,'2026-06-08 01:17:27','2026-06-17 01:56:34'),(87,'2423102079',4,'Sabina Ratu Putri','bina','Bina','sabina.ratu@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$LetXpAM3VKOj2jC1vZxSZeGK5gNPxoot06bZ/Zb6n3QREHUzPsoCe',NULL,'2026-06-08 01:17:28','2026-06-17 01:56:34'),(88,'2423102091',4,'Zahra\' Salsabila Fitria Merlyn','merlyn','Merlyn','zahra\'.salsabila@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RSK',NULL,NULL,NULL,'$2y$12$KqjOsgHwwtBVtuBgynY4jOdZz9ujq6VPiv0.dQeErWjKW5JYphZci',NULL,'2026-06-08 01:17:28','2026-06-17 01:56:35'),(89,'2423102004',5,'Atika Rahma','tira','Tira','atika.rahma@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$K9fcnXJ6jCc807NOmZmXCubC6GxZ4zc.GOptDxiVwD9B3qoW1ZTtO',NULL,'2026-06-08 01:17:29','2026-06-17 01:56:35'),(90,'2423102008',5,'Britania Paria Delta Siburian','tania','Tania','britania.paria@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$4tR9qa.POjVCbPjoww5ov.JYH.wI5ORgbgDFQagdNk0sxuux/fnja',NULL,'2026-06-08 01:17:29','2026-06-17 01:56:36'),(91,'2423102009',5,'Christine Nauli Febiana S','febi','Febi','christine.nauli@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$BdSo1LHoG.wz5cbz7v5F6u/sDyP8YpHPxaAF5FAY51jKTwrPpbvLS',NULL,'2026-06-08 01:17:30','2026-06-17 01:56:36'),(92,'2423102013',5,'Della Risava Silaban','risav','Risav','della.risava@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$YlLnkpkK5OkfbDy/M4OKQup4HeFN4IAJHLN.Pu9HTxUh2HZXisH4q',NULL,'2026-06-08 01:17:30','2026-06-17 01:56:36'),(93,'2423102020',5,'Eulia Radifa Meilinawati','difa','Difa','eulia.radifa@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$Bg8YFcbTHscZ.qMM2hNtM.N8jEzPodlgVbigiKPJRiHe5PR3UW1H6',NULL,'2026-06-08 01:17:31','2026-06-17 01:56:37'),(94,'2423102022',5,'Fakhri Ahmad Asyafi\'i','fri','Fri','fakhri.ahmad@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$4NDw6Dmcda635ti69WPvmOtfKm80gewpfjnvE5XmyvnJ63imKvEfO',NULL,'2026-06-08 01:17:31','2026-06-17 01:56:37'),(95,'2423102026',5,'Faris Rahmadin','fadin','Fadin','faris.rahmadin@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$DQyCi/G2WhMbGZqphogese6f7yfZGJndWm3K4mpNMPKYUxqfugALC',NULL,'2026-06-08 01:17:31','2026-06-17 01:56:38'),(96,'2423102031',5,'Hasan Almusanna Albaar','nasa','Nasa','hasan.almusanna@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$BcEXwTL40U8H14m5aUtMU.cha/NAOCtKM.wgxPE.FnEWlfrsnZqL6',NULL,'2026-06-08 01:17:32','2026-06-17 01:56:38'),(97,'2423102035',5,'Irsyad Arif Firmansyah','irsyad','Irsyad','irsyad.arif@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$jpPbOqK79FjK0v78Yaig8eEvDOVISsxf9SeAyFRLRWhZiCkt94Pk.',NULL,'2026-06-08 01:17:32','2026-06-17 01:56:39'),(98,'2423102036',5,'Jessica Avrilia Br Simatupang','jessi','Jessi','jessica.avrilia@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$kiESzMd3MCxcuiBTNMymMuW.BSMPwSdFy/bFHsplWiWDn3vR9XSgm',NULL,'2026-06-08 01:17:33','2026-06-17 01:56:39'),(99,'2423102040',5,'M. Adib Arkan','diboy','Diboy','m..adib@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$ahX7MAA2KfEEhbu9zCum0eWlYptC136ku/l92aWiGxyJDd8DrPLVW',NULL,'2026-06-08 01:17:33','2026-06-17 01:56:40'),(100,'2423102041',5,'M. Deonardo Federicko','deo','Deo','m..deonardo@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$5LxZrgPp7mIGfIAJMeBv3ubwMrMgKSv2bWV5d7.rOWgi7pOAbPUkW',NULL,'2026-06-08 01:17:34','2026-06-17 01:56:40'),(101,'2423102045',5,'Michael Ridho Waster Pakpahan','waster','Waster','michael.ridho@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$aXLGptjQnbDC5x/Mrmxp8.iygV6XcJUG5xTJB7r3O6N/IHGwCNNX.',NULL,'2026-06-08 01:17:34','2026-06-17 01:56:41'),(102,'2423102046',5,'Muhaimin Murdiyanto','imin','Imin','muhaimin.murdiyanto@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$XI3Znrma2hWYaV6ioQtqiuz26N.zUdNXYKAyk9INmCism1584jMs2',NULL,'2026-06-08 01:17:34','2026-06-17 01:56:41'),(103,'2423102053',5,'Muhammad Fernanda Irawan','feno','Feno','muhammad.fernanda@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$257h3Cs7r6HuNtquuxO8hezqpKKFL5CnR4ACFDZ.bW3VqlIQyKM/.',NULL,'2026-06-08 01:17:35','2026-06-17 01:56:41'),(104,'2423102056',5,'Muhammad Rizq Dewangga','wangga','Wangga','muhammad.rizq@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$ny6.73W1.t2RNdGpVH8B.uMHSO8LAgJG/cY4ykIOROJIOpIJnz.rK',NULL,'2026-06-08 01:17:35','2026-06-17 01:56:42'),(105,'2423102073',5,'Rivaldi Abdullah','valid','Valid','rivaldi.abdullah@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$cD3WA2xeeGqTgLaar.1FA.f3e.036UAkC5DftK.VB7zjkPsMFvUr2',NULL,'2026-06-08 01:17:36','2026-06-17 01:56:42'),(106,'2423102074',5,'Rizal Hadi Fadillah Riyadi','riyad','Riyad','rizal.hadi@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$BTw2u/kYZajTjnNaP1RS2OkuUbGDMCpwDXKacLED0wdpkj.mdElXy',NULL,'2026-06-08 01:17:36','2026-06-17 01:56:43'),(107,'2423102087',5,'Yahfi Al Farisy','alfa','Alfa','yahfi.al@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$6VqdIdx9aSf6N1aWx/OX.e.jTyd.dsdh6y0YcWPRggG5TD4vONk0C',NULL,'2026-06-08 01:17:37','2026-06-17 01:56:43'),(108,'2423102088',5,'Yanuar Ubeth Taruna Wibawa','ubeth','Ubeth','yanuar.ubeth@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$2c8uTlkB53xgCzJOe7O5L.JcbsZNVMyYGXXNCwR3SR95NZ1TQTvxu',NULL,'2026-06-08 01:17:37','2026-06-17 01:56:43'),(109,'2423102090',5,'Yusuf Fahar Prasli Irsyad','fahar','Fahar','yusuf.fahar@student.poltekssn.ac.id','taruna',NULL,'Taruna 2 RKS B',NULL,NULL,NULL,'$2y$12$HXrkdHd29voDpm/UkRSdseSqbt0qMUq2nNdAPzcz/vq9GPYY1CFmi',NULL,'2026-06-08 01:17:38','2026-06-17 01:56:44'),(115,'2524102097',6,'Abel Ihsan Renjiro','jiro','Jiro','abel.ihsan@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS A',NULL,NULL,NULL,'$2y$12$iohVdudlFUwX1xfzy8KS0.HX9FxAYjC6pxaNfpJh5SM91QiFzHHpm',NULL,NULL,'2026-06-17 03:45:42'),(116,'2524102099',6,'Alifiarka Shinta Basmalama','alifiarka','Alifiarka','alifiarka.shinta@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS A',NULL,NULL,NULL,'$2y$12$64Y3l0RfgrR6Gq.iDe/sP.oDCREEeOnAWP2lrwEs6rqn7j4JEwVuy',NULL,NULL,'2026-06-17 02:49:26'),(117,'2524102106',6,'Aurora Harnov','aurora','Aurora','aurora.harnov@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS A',NULL,NULL,NULL,'$2y$12$a/Df/6jyhFGWvGNBPGawCOzLPm.YIV/5eM2j7LolXwgel5X02jUYi',NULL,NULL,'2026-06-17 02:49:27'),(118,'2524102107',6,'Azkhia Bagir Alfarisi','azki','Azki','azkhia.bagir@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS A',NULL,NULL,NULL,'$2y$12$PHpWLW11W2u0UjOU3hbtOutCIOCAhR25bVIvvUoJd0MPvpyIfMg/q',NULL,NULL,'2026-06-17 03:46:10'),(119,'2524102112',6,'Diky Dwi Saputra Ginting','diky','Diky','diky.dwi@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS A',NULL,NULL,NULL,'$2y$12$2/GiOqunw/cb4aFyy10CWuCpEZ2Dbs3tSTVBkuvmyVYa8QhHhVXOq',NULL,NULL,'2026-06-17 02:49:28'),(120,'2504102114',6,'Farhan Fadly','farhan','Farhan','farhan.fadly@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS A',NULL,NULL,NULL,'$2y$12$rjZnhX0nqy1Hu/7XvxthP.hlZU1vUds5Csr.ZK0RIPIacXqnHIG5u',NULL,NULL,'2026-06-17 02:49:28'),(121,'2524102117',6,'Hamuda Fahri','hamud','Hamud','hamuda.fahri@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS A',NULL,NULL,NULL,'$2y$12$f3OHaTDO8rovQ/c0RzcK6.FNGPlXPTVsx/Cj060EJ7R2xPby1ztAm',NULL,NULL,'2026-06-17 03:48:52'),(122,'2524102125',6,'Muhammad Faridfayyad Danial','muhammad','Muhammad','muhammad.faridfayyad@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS A',NULL,NULL,NULL,'$2y$12$G8SgPB02lgaZGXke1q2SeeE1ConapEVSSWxgnqwBQjgOEcy4oHycG',NULL,NULL,'2026-06-17 02:49:29'),(123,'2524102126',6,'Mutiara Ayudya Yuwan','mutiara','Mutiara','mutiara.ayudya@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS A',NULL,NULL,NULL,'$2y$12$moxk1dkmQq1MQLkf9vVmF.9oPUHxyMizCh5nLss95KRUstyp9SstC',NULL,NULL,'2026-06-17 02:49:30'),(124,'2524102132',6,'Olfifaisa Mahaliya Sholeha','olfifaisa','Olfifaisa','olfifaisa.mahaliya@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS A',NULL,NULL,NULL,'$2y$12$JMnYGwpm15RyAdf1y3BrCuY6H.vobfMDKvWEHYa06WSqLy4UYkMSm',NULL,NULL,'2026-06-17 02:49:30'),(125,'2524102145',6,'Yemima Elira Puteri','yemima','Yemima','yemima.elira@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS A',NULL,NULL,NULL,'$2y$12$x0jF5fWdco6Xi8TDviWUCewMg07hRzqxyusESik4jJnd7HidyYdRK',NULL,NULL,'2026-06-17 02:49:30'),(126,'2524102096',7,'Abdul Hafizh Burmelli','abdul','Abdul','abdul.hafizh@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS B',NULL,NULL,NULL,'$2y$12$GuwHT3xlhg4GXSvRXT/UvOi34CGlgP8Bul8j4xXskuvRXCbgfcZfu',NULL,NULL,'2026-06-17 02:49:31'),(127,'2524102100',7,'Amanda Dwi Agnistyanida','amanda','Amanda','amanda.dwi@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS B',NULL,NULL,NULL,'$2y$12$xOOcYcOdF6UNfltNDsrpie0SvNXLUZEsZofOpuyqLt3RvWgBBsJuu',NULL,NULL,'2026-06-17 02:49:31'),(128,'2524102103',7,'Arya Bima Rafa Hanindityo','arya','Arya','arya.bima@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS B',NULL,NULL,NULL,'$2y$12$Zv6MamqTrt4As2i3CkYNWu13qmntX8jQlAwxjtpk/hgLeLkWhIoVO',NULL,NULL,'2026-06-17 02:49:32'),(129,'2524102111',7,'Christian Natanael Sirait','christian','Christian','christian.natanael@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS B',NULL,NULL,NULL,'$2y$12$7IcW1CBuv1NutfdBga3xBumStq.rtXzzxgFDZOq/edhLw.ckHnpx2',NULL,NULL,'2026-06-17 02:49:32'),(130,'2524102113',7,'Dimas Zaki Anwar','dimas','Dimas','dimas.zaki@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS B',NULL,NULL,NULL,'$2y$12$7C6hyHWdE/67n/UQiejLqObRFJpBFsc8dh/3BxF5auHHOXEzoPR8i',NULL,NULL,'2026-06-17 02:49:32'),(131,'2524102116',7,'Farrel Evan Lase','farrel','Farrel','farrel.evan@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS B',NULL,NULL,NULL,'$2y$12$teE7R7JRKqTQeyZ/HvkcJeMIME8Gnp8iKn.cFnnGoKp/t1hHxvaCy',NULL,NULL,'2026-06-17 02:49:33'),(132,'2524102118',7,'Hizkia Partogi Sihombing','hizkia','Hizkia','hizkia.partogi@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS B',NULL,NULL,NULL,'$2y$12$OT8JutTxwwItnYFQt.b5q.tX0FCkZWv.yU5zZeL9/OfcYE/UPBT/G',NULL,NULL,'2026-06-17 02:49:33'),(133,'2524102119',7,'Jhe Jian Karenina Sashu','jhe','Jhe','jhe.jian@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS B',NULL,NULL,NULL,'$2y$12$C9ZTjm3nZFo.lPNOAIzxgu.JNV11lSOfXtd9IsK5SAZSdLF3jNiSe',NULL,NULL,'2026-06-17 02:49:34'),(134,'2524102127',7,'Nabilah','nabilah','Nabilah','nabilah@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS B',NULL,NULL,NULL,'$2y$12$ZKrEdaD3l0JDime579kqje.DrguM/JhM/0on22swWd9YypEVj70xS',NULL,NULL,'2026-06-17 02:49:34'),(135,'2524102133',7,'Philip Simanjuntak','philip','Philip','philip.simanjuntak@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS B',NULL,NULL,NULL,'$2y$12$hylwol6bJwZ.XsxfOd7L2uYp3Ktz1VFTDZSxJB5VZnqLZyyPKVvcS',NULL,NULL,'2026-06-17 02:49:35'),(136,'2524102134',7,'Qoidatul Husna Mazidah','qoidatul','Qoidatul','qoidatul.husna@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS B',NULL,NULL,NULL,'$2y$12$fHGJ/sy9LrX8XSJSCap1A.Nb5Xm..t8YxIYYZNNivhBXcBKu861i.',NULL,NULL,'2026-06-17 02:49:35'),(137,'2524102143',7,'Tsania Naja Afifah','tsania','Tsania','tsania.naja@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RKS B',NULL,NULL,NULL,'$2y$12$fYIb393/dzafbEYr8hWetuIsnTUWyP0E3jrUIeOMwq7tAn9kmWUz6',NULL,NULL,'2026-06-17 02:49:36'),(138,'2524102104',10,'Atalla Arya Harimurti Sulistyo','atalla','Atalla','atalla.arya@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPKK',NULL,NULL,NULL,'$2y$12$tZw6UNucbXnZSg.zAQP21OyiOB/JfQS1nQD7o3r9dR/LeSIrWL8jG',NULL,NULL,'2026-06-17 02:49:36'),(139,'2524102120',10,'Keifa Dinnaya Nadya Shafwa','keifa','Keifa','keifa.dinnaya@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPKK',NULL,NULL,NULL,'$2y$12$ghMfBx/t6KohKa34lWj3J.rtON5.GUj3jn/HGBigkoFoJnGVESM1K',NULL,NULL,'2026-06-17 02:49:37'),(140,'2524102122',10,'M. Hilmi Taqiyyuddin','hilmi','Hilmi','m.hilmi@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPKK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(141,'2524102129',10,'Nasywa Larisa','nasywa','Nasywa','nasywa.larisa@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPKK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(142,'2524102146',10,'Nayla Rachmawati','nayla','Nayla','nayla.rachmawati@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPKK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(143,'2524102130',10,'Nicholas Zen','nicholas','Nicholas','nicholas.zen@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPKK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(144,'2524102139',10,'Said Irfan Halim','said','Said','said.irfan@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPKK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(145,'2524102098',8,'Al Mayra Bilahizza Yusuf','almayra','Almayra','al.mayra@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPLK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(146,'2524102101',8,'Annisa Kireida Mahtabila','annisa','Annisa','annisa.kireida@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPLK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(147,'2524102102',8,'Arga Samuel Simanjuntak','arga','Arga','arga.samuel@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPLK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(148,'2524102105',8,'Atha Syahda Alhaibah','atha','Atha','atha.syahda@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPLK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(149,'2524102109',8,'Bonar Judika Marbun','bonar','Bonar','bonar.judika@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPLK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(150,'2524102124',8,'Muhamad Haikal Masriqi','muhamad','Muhamad','muhamad.haikal@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPLK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(151,'2524102131',8,'Odette Pinandita Gunawan','odette','Odette','odette.pinandita@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPLK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(152,'2524102135',8,'Queentania Dara Chulfikar','queentania','Queentania','queentania.dara@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPLK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(153,'2524102137',8,'Rasya Naufal','rasya','Rasya','rasya.naufal@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPLK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(154,'2524102138',8,'Rizki Nanda Syahputra Pasaribu','rizki','Rizki','rizki.nanda@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RPLK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(155,'2524102108',9,'Balqis Aqilla Nur Asy-Syifa','balqis','Balqis','balqis.aqilla@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RSK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(156,'2524102110',9,'Bunga Aulia','bunga','Bunga','bunga.aulia@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RSK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(157,'2524102115',9,'Farrel Andhika Putra','farrel','Farrel','farrel.andhika@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RSK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(158,'2524102121',9,'Lasro Yogi Situmorang','lasro','Lasro','lasro.yogi@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RSK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(159,'2524102123',9,'Maretta Marid Cahyaning Cantika','maretta','Maretta','maretta.marid@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RSK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(160,'2524102128',9,'Naila Ratnafuri','naila','Naila','naila.ratnafuri@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RSK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(161,'2524102136',9,'Rajendra Edmund Daniel','rajendra','Rajendra','rajendra.edmund@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RSK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(162,'2524102141',9,'Sausan Nuha Thufailah','sausan','Sausan','sausan.nuha@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RSK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(163,'2524102142',9,'Talita Azalia Dhafa','talita','Talita','talita.azalia@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RSK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(164,'2524102144',9,'Voleta Aura','voleta','Voleta','voleta.aura@student.poltekssn.ac.id','taruna',NULL,'Taruna 1 RSK',NULL,NULL,NULL,'$2y$12$edIXeBnUKBs23sTYOn72v.W9zZ8MIB/LFwHfPwNcj9z54wNjzltb2',NULL,NULL,NULL),(167,NULL,NULL,'Pengasuh','pengasuh',NULL,'pengasuh@ppicurug.ac.id','pengasuh',NULL,'Pengasuh',NULL,NULL,NULL,'$2y$12$0fOoXlVE6q9GaVADtQHG8eHM5e7BMFDN6Ya2Bk6O.o4UBfxCECSSO',NULL,'2026-08-16 05:57:06','2026-08-27 00:34:27'),(168,NULL,NULL,'Satsuh',NULL,NULL,'satsuh@ppicurug.ac.id','taruna',NULL,NULL,NULL,NULL,NULL,'$2y$12$cvFaT062i9K9A4qSnae9ruuvEygi1EEtuPS63qm28uqBdJ1ZT.S1.',NULL,'2026-09-06 00:51:42','2026-09-06 00:51:42'),(169,NULL,NULL,'Admin','admin',NULL,'admin@poltekssn.ac.id','admin',NULL,'Admin Pengasuhan',NULL,NULL,NULL,'$2y$12$479A34GIUCDNBC.gDbgh/.TnqXQK8yeq/lTAdw6DFpAsR5UDTi1Mi',NULL,'2026-09-06 00:52:23','2026-09-06 00:52:23'),(170,NULL,NULL,'Pengasuh','pengasuh',NULL,'pengasuh@poltekssn.ac.id','pengasuh',NULL,'Pengasuh',NULL,NULL,NULL,'$2y$12$aTU/m34IzBX459jCCjXK2uQP2TOImOkpQUntPj262WFDnvzKamane',NULL,'2026-09-06 00:52:24','2026-09-06 00:52:24'),(171,NULL,NULL,'Taruna Demo','taruna',NULL,'taruna@poltekssn.ac.id','taruna',NULL,'Taruna',NULL,NULL,NULL,'$2y$12$8nculZDvK/s6P4TEsM43cesRKZL/TcxjO.b/bXgi8JlQTgt0NjFOq',NULL,'2026-09-06 00:52:24','2026-09-06 00:52:24');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'ppicurug'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-06 23:11:27
