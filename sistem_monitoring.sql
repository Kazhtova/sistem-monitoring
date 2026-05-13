-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 13, 2026 at 01:30 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_monitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `komputer`
--

CREATE TABLE `komputer` (
  `id_komputer` bigint UNSIGNED NOT NULL,
  `nama_komputer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_laboratorium` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `komputer`
--

INSERT INTO `komputer` (`id_komputer`, `nama_komputer`, `id_laboratorium`, `created_at`, `updated_at`) VALUES
(1, 'Komputer 11', 3, '2026-05-07 01:48:58', '2026-05-07 01:48:58'),
(2, 'Komputer 7', 3, '2026-05-07 01:48:58', '2026-05-07 01:48:58'),
(3, 'Komputer 5', 3, '2026-05-07 01:48:58', '2026-05-07 01:48:58'),
(4, 'Komputer 10', 3, '2026-05-07 01:48:58', '2026-05-07 01:48:58'),
(5, 'Komputer 3', 3, '2026-05-07 01:48:58', '2026-05-07 01:48:58'),
(6, 'Komputer 8', 3, '2026-05-07 01:48:58', '2026-05-07 01:48:58'),
(7, 'Komputer 1', 3, '2026-05-07 01:48:58', '2026-05-07 01:48:58'),
(8, 'Komputer 2', 3, '2026-05-07 01:48:58', '2026-05-07 01:48:58'),
(9, 'Komputer 6', 3, '2026-05-07 01:48:58', '2026-05-07 01:48:58'),
(10, 'Komputer 4', 3, '2026-05-07 01:48:58', '2026-05-07 01:48:58'),
(11, 'Komputer 9', 3, '2026-05-07 01:48:58', '2026-05-07 01:48:58'),
(12, 'Komputer 17', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(13, 'Komputer 10', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(14, 'Komputer 13', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(15, 'Komputer 6', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(16, 'Komputer 4', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(17, 'Komputer 12', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(18, 'Komputer 20', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(19, 'Komputer 18', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(20, 'Komputer 15', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(21, 'Komputer 11', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(22, 'Komputer 2', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(23, 'Komputer 1', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(24, 'Komputer 7', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(25, 'Komputer 5', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(26, 'Komputer 8', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(27, 'Komputer 9', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(28, 'Komputer 3', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(29, 'Komputer 16', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(30, 'Komputer 19', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(31, 'Komputer 14', 2, '2026-05-07 01:53:03', '2026-05-07 01:53:03'),
(32, 'Komputer 5', 1, '2026-05-07 01:54:12', '2026-05-07 01:54:12'),
(33, 'Komputer 2', 1, '2026-05-07 01:54:12', '2026-05-07 01:54:12'),
(34, 'Komputer 1', 1, '2026-05-07 01:54:12', '2026-05-07 01:54:12'),
(35, 'Komputer 6', 1, '2026-05-07 01:54:12', '2026-05-07 01:54:12'),
(36, 'Komputer 3', 1, '2026-05-07 01:54:12', '2026-05-07 01:54:12'),
(37, 'Komputer 7', 1, '2026-05-07 01:54:12', '2026-05-07 01:54:12'),
(38, 'Komputer 8', 1, '2026-05-07 01:54:12', '2026-05-07 01:54:12'),
(39, 'Komputer 4', 1, '2026-05-07 01:54:12', '2026-05-07 01:54:12');

-- --------------------------------------------------------

--
-- Table structure for table `laboratorium`
--

CREATE TABLE `laboratorium` (
  `id_laboratorium` bigint UNSIGNED NOT NULL,
  `nama_lab` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_komputer` int NOT NULL,
  `id_teknisi` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laboratorium`
--

INSERT INTO `laboratorium` (`id_laboratorium`, `nama_lab`, `jumlah_komputer`, `id_teknisi`, `created_at`, `updated_at`) VALUES
(1, 'Lab 3', 8, 4, '2026-05-07 00:31:19', '2026-05-07 00:31:19'),
(2, 'Lab 1', 20, 5, '2026-05-07 00:31:19', '2026-05-07 00:31:19'),
(3, 'Lab 2', 11, 6, '2026-05-07 00:31:19', '2026-05-07 00:31:19');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` bigint UNSIGNED NOT NULL,
  `nrp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_mahasiswa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nrp`, `nama_mahasiswa`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, '1560000356', 'Bryon Schoen', '2026-05-05 19:40:16', '2026-05-05 19:40:16', 'rNGTriIj9jzZEB163udOYnt3c4hzMBVTGVz0Hqp4OhTMCH3PBkLUjiWRzP5w'),
(2, '516801209', 'Prof. Abe Kiehn', '2026-05-05 19:40:16', '2026-05-05 19:40:16', NULL),
(3, '295681170', 'Mrs. Stacey Olson', '2026-05-05 19:40:16', '2026-05-05 19:40:16', 'CeQoW0FzaJD2AU9rhs4N3Ktb2QGQiOaLOW58KDrHi8GsjbUpow5UR3KzJO1Y'),
(4, '355430584', 'Dr. Charity Kovacek', '2026-05-05 19:40:16', '2026-05-05 19:40:16', 'lIOHYJfWcLydwBByNj4iOPO9IqSpEhGXkNLzNvZIUw8cVMkyKDPynh6dpnOB'),
(5, '332779611', 'Catharine Torp', '2026-05-05 19:40:16', '2026-05-05 19:40:16', NULL),
(6, '1573671002', 'Lura Leuschke', '2026-05-05 19:40:16', '2026-05-05 19:40:16', NULL),
(7, '299978823', 'Edyth Walter', '2026-05-05 19:40:16', '2026-05-05 19:40:16', NULL),
(8, '1866832483', 'Maximillian Cummings', '2026-05-05 19:40:16', '2026-05-05 19:40:16', NULL),
(9, '805454062', 'Gerda Lehner', '2026-05-05 19:40:16', '2026-05-05 19:40:16', NULL),
(10, '876613965', 'Dr. Freeda Hill', '2026-05-05 19:40:16', '2026-05-05 19:40:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_05_033659_create_teknisi_table', 1),
(5, '2026_05_05_033708_create_mahasiswa_table', 1),
(6, '2026_05_05_033735_create_laboratorium_table', 1),
(7, '2026_05_05_033744_create_komputer_table', 1),
(8, '2026_05_05_033755_create_request_table', 1),
(9, '2026_05_05_035727_create_permission_tables', 2),
(10, '2026_05_06_085711_add_remember_token_to_mahasiswa_table', 3),
(11, '2026_05_07_023503_add_nama_kolom_to_laboratorium_table', 4),
(12, '2026_05_07_024032_add_nama_kolom_to_laboratorium_table', 4),
(13, '2026_05_08_023612_remove_enum_from_laboratorium_table', 5),
(14, '2026_05_08_023723_add_status_from_laboratorium_table', 6),
(15, '2026_05_08_024236_remove_enum_again_from_laboratorium_table', 7),
(16, '2026_05_08_025113_add_dosen_from_laboratorium_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id_request` bigint UNSIGNED NOT NULL,
  `software` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` bigint NOT NULL,
  `tanggal_mulai` datetime NOT NULL,
  `perkiraan_selesai` datetime NOT NULL,
  `dosen_ta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_bukti` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','setuju','tolak','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_teknisi` bigint UNSIGNED NOT NULL,
  `id_mahasiswa` bigint UNSIGNED NOT NULL,
  `id_komputer` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id_request`, `software`, `no_hp`, `tanggal_mulai`, `perkiraan_selesai`, `dosen_ta`, `foto_bukti`, `status`, `catatan`, `id_teknisi`, `id_mahasiswa`, `id_komputer`, `created_at`, `updated_at`) VALUES
(1, 'Excell, Vs Code', 812345678, '2026-05-08 15:16:00', '2026-05-22 15:16:00', 'Pak Adit', 'uploads/1778228217_Kashka 15.png', 'pending', 'Jangan Dihapus', 4, 1, 1, '2026-05-08 01:16:58', '2026-05-11 23:37:04'),
(2, 'Excell, Vs Code, Word', 8123456, '2026-05-09 17:49:00', '2026-05-12 17:49:00', 'Pak Adi', 'uploads/1778323787_DIDI (1) (1).png', 'pending', 'Jangan Dihapus Yah', 4, 1, 1, '2026-05-09 03:49:48', '2026-05-12 08:54:35'),
(3, 'VS CODE, LARAGON', 81234567, '2026-05-10 18:12:00', '2026-05-14 18:12:00', 'Pak Fidan', 'uploads/1778411588_Screenshot (1179).png', 'pending', 'Ini Sangat Darurat', 4, 4, 1, '2026-05-10 04:13:10', '2026-05-13 01:27:37'),
(7, 'Adobe Ilustrator, Corel DRAW', 81231318273, '2026-05-10 00:50:00', '2026-05-27 15:54:00', 'Pak Nizar', 'uploads/1778467774_Screenshot (1200).png', 'pending', 'Gambar Logo Smeketen', 4, 1, 1, '2026-05-10 19:49:34', '2026-05-13 01:08:15'),
(9, 'Jupiter, MitLab', 876564534231, '2026-05-12 15:20:00', '2026-05-27 19:22:00', 'Bu Zaima', 'uploads/1778574017_Screenshot (1205).png', 'pending', 'Berhasil Kirim', 4, 3, 1, '2026-05-12 08:20:18', '2026-05-13 01:27:42'),
(12, 'sdfsdf', 9897079, '2026-05-12 15:37:00', '2026-05-15 15:37:00', 'sddsf', 'uploads/1778575094_Screenshot (1191).png', 'pending', 'erretert', 4, 3, 1, '2026-05-12 08:38:14', '2026-05-13 01:07:59'),
(13, 'alkjdakjdlasd', 24234234, '2026-05-12 15:41:00', '2026-05-22 15:41:00', 'kajsd', 'uploads/1778575311_Screenshot (1183).png', 'pending', 'werwerwer', 4, 3, 1, '2026-05-12 08:41:51', '2026-05-13 01:08:07');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('GUY3XYx9vMH6wab2CB62aMyHitJLISIuHB22Bh0G', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiajZHeWhRek5iZ0xEbDNNTlNyeVNFTzVBMVZpRllIdktBaEhsUERPYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hY2NlcHQtbGlzdD9zZWFyY2g9JnNvcnQ9b2xkZXN0IjtzOjU6InJvdXRlIjtzOjE2OiJkYXNoYm9hcmQuYWNjZXB0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778634274),
('kKf3YjLpUnkVouBaB7r9cOg8pZydmccDNTasXFOQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSE1Bb0VGWVp6dFdEVGp5ZlZwY0t2ZTdGSmRjV282Y2pRVnFyRlF4TCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbi1tYWhhc2lzd2EiO3M6NToicm91dGUiO3M6MTU6ImxvZ2luLm1haGFzaXN3YSI7fX0=', 1778635771),
('p161BvZ3jddzWpcEO2mPdpMajvmlZgFD3zEfZ9AG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia251TUN3M2EyU1dkWlZKN0tyMFRUMDZub1dPSUYzVUZjTzRiNTdtYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXF1ZXN0LWxpc3QiO3M6NToicm91dGUiO3M6MTc6ImRhc2hib2FyZC5yZXF1ZXN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778634275);

-- --------------------------------------------------------

--
-- Table structure for table `teknisi`
--

CREATE TABLE `teknisi` (
  `id_teknisi` bigint UNSIGNED NOT NULL,
  `nama_teknisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teknisi`
--

INSERT INTO `teknisi` (`id_teknisi`, `nama_teknisi`, `created_at`, `updated_at`) VALUES
(1, 'Oscar Lueilwitz', '2026-05-04 23:52:17', '2026-05-04 23:52:17'),
(2, 'Chester Olson V', '2026-05-04 23:52:17', '2026-05-04 23:52:17'),
(3, 'Roslyn Murphy', '2026-05-04 23:52:17', '2026-05-04 23:52:17'),
(4, 'Dr. Gilda Senger', '2026-05-07 00:31:19', '2026-05-07 00:31:19'),
(5, 'Gail Roberts I', '2026-05-07 00:31:19', '2026-05-07 00:31:19'),
(6, 'Gideon Veum', '2026-05-07 00:31:19', '2026-05-07 00:31:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komputer`
--
ALTER TABLE `komputer`
  ADD PRIMARY KEY (`id_komputer`),
  ADD KEY `komputer_id_laboratorium_foreign` (`id_laboratorium`);

--
-- Indexes for table `laboratorium`
--
ALTER TABLE `laboratorium`
  ADD PRIMARY KEY (`id_laboratorium`),
  ADD KEY `laboratorium_id_teknisi_foreign` (`id_teknisi`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `mahasiswa_nrp_unique` (`nrp`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `request_id_mahasiswa_foreign` (`id_mahasiswa`),
  ADD KEY `request_id_komputer_foreign` (`id_komputer`),
  ADD KEY `request_id_teknisi_foreign` (`id_teknisi`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `teknisi`
--
ALTER TABLE `teknisi`
  ADD PRIMARY KEY (`id_teknisi`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `komputer`
--
ALTER TABLE `komputer`
  MODIFY `id_komputer` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `laboratorium`
--
ALTER TABLE `laboratorium`
  MODIFY `id_laboratorium` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id_request` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teknisi`
--
ALTER TABLE `teknisi`
  MODIFY `id_teknisi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komputer`
--
ALTER TABLE `komputer`
  ADD CONSTRAINT `komputer_id_laboratorium_foreign` FOREIGN KEY (`id_laboratorium`) REFERENCES `laboratorium` (`id_laboratorium`) ON DELETE CASCADE;

--
-- Constraints for table `laboratorium`
--
ALTER TABLE `laboratorium`
  ADD CONSTRAINT `laboratorium_id_teknisi_foreign` FOREIGN KEY (`id_teknisi`) REFERENCES `teknisi` (`id_teknisi`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_id_komputer_foreign` FOREIGN KEY (`id_komputer`) REFERENCES `komputer` (`id_komputer`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_id_mahasiswa_foreign` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_id_teknisi_foreign` FOREIGN KEY (`id_teknisi`) REFERENCES `teknisi` (`id_teknisi`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
