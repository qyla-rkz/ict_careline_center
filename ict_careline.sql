-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2026 at 09:17 AM
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
-- Database: `ict_careline`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_type` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `activity_type`, `description`, `created_at`) VALUES
(1, 3, 'Report Submitted', 'Submitted KEW.PA-9 for Laptop (0000)', '2026-04-25 07:32:38'),
(2, 3, 'Report Submitted', 'Submitted KEW.PA-9 for Printer (0001)', '2026-06-22 07:51:49'),
(3, 8, 'Profile Updated', 'Admin changed profile information', '2026-06-29 02:05:37'),
(4, 3, 'Report Submitted', 'Submitted KEW.PA-9 for Desktop PC (0000)', '2026-07-01 02:25:45'),
(5, 8, 'Profile Updated', 'Admin changed profile information', '2026-09-21 02:29:07');

-- --------------------------------------------------------

--
-- Table structure for table `asset_images`
--

CREATE TABLE `asset_images` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `details`, `ip_address`, `created_at`) VALUES
(1, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-09-14 01:39:24'),
(2, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', NULL, '2026-09-14 01:39:27'),
(3, 1, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) berjaya log masuk sebagai Super Admin.', NULL, '2026-09-14 01:50:50'),
(4, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-09-15 00:16:53'),
(5, 3, 'Kemaskini Aset', 'Aset dikemaskini: Desktop PC (S/N: 0000). ID Aset: 1.', NULL, '2026-09-15 00:50:25'),
(6, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-09-15 01:25:34'),
(7, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-09-15 01:25:45'),
(8, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', NULL, '2026-09-15 02:01:47'),
(9, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-09-21 01:01:14'),
(10, 3, 'Hantar Laporan', 'Laporan KEW.PA-9 baru dihantar untuk aset \'\' (S/N: ). ID Laporan: 6.', NULL, '2026-09-21 01:11:40'),
(11, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-09-21 01:31:54'),
(12, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-09-21 01:38:45'),
(13, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-09-21 01:44:57'),
(14, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-09-21 01:46:57'),
(15, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', NULL, '2026-09-21 02:11:15'),
(16, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-09-21 02:11:22'),
(17, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-09-21 02:13:17'),
(18, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', NULL, '2026-09-21 02:29:29'),
(19, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-09-21 02:29:39'),
(20, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-09-21 02:30:05'),
(21, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-09-21 02:30:14'),
(22, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', NULL, '2026-09-21 02:47:56'),
(23, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-09-21 02:48:04'),
(24, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', NULL, '2026-09-21 02:48:30'),
(25, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-09-21 02:48:40'),
(26, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-09-21 04:03:05'),
(27, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-09-21 04:03:53'),
(28, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-09-21 04:04:05'),
(29, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', NULL, '2026-09-21 04:12:59'),
(30, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-09-21 04:13:08'),
(31, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-09-21 04:25:55'),
(32, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-09-23 00:03:08'),
(33, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-09-23 00:27:07'),
(34, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-09-23 00:27:15'),
(35, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-09-25 08:16:15'),
(36, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-09-25 08:24:44'),
(37, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-09-25 08:26:47'),
(38, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-10-14 00:25:38'),
(39, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-10-14 00:43:32'),
(40, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-10-15 03:51:42'),
(41, 3, 'Hantar Laporan', 'Laporan KEW.PA-9 baru dihantar untuk aset \'Laptop/NoteBook\' (S/N: OOOOO). ID Laporan: 7.', NULL, '2026-10-15 03:53:36'),
(42, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-10-15 03:53:50'),
(43, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-10-15 03:53:56'),
(44, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-10-15 03:54:16'),
(45, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-10-15 03:54:22'),
(46, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', NULL, '2026-10-15 03:54:53'),
(47, 1, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) berjaya log masuk sebagai Super Admin.', NULL, '2026-10-15 03:58:12'),
(48, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-10-21 02:32:59'),
(49, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', NULL, '2026-10-21 02:33:41'),
(50, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-10-21 02:33:49'),
(51, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-10-21 03:45:39'),
(52, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-10-21 03:45:47'),
(53, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', NULL, '2026-10-21 03:45:52'),
(54, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-10-21 03:45:59'),
(55, 3, 'Hantar Laporan', 'Laporan KEW.PA-9 baru dihantar untuk aset \'Desktop PC\' (S/N: 0000). ID Laporan: 8.', NULL, '2026-10-21 03:47:04'),
(56, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-10-21 03:47:27'),
(57, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-10-21 03:47:34'),
(58, 8, 'Tambah Aset (Admin)', 'Admin \'Nurul Aqilah Khairuni\' tambah aset baharu ID 2 (Nurul Aqilah Khairuni, S/N: 000).', NULL, '2026-10-21 04:14:52'),
(59, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', NULL, '2026-10-21 04:20:13'),
(60, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-10-21 04:20:26'),
(61, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-10-21 04:31:31'),
(62, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-10-21 04:31:40'),
(63, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-10-21 06:34:26'),
(64, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-10-21 06:42:10'),
(65, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-10-21 06:42:15'),
(66, 8, 'Kemaskini Aset (Admin)', 'Admin \'Nurul Aqilah Khairuni\' kemaskini aset ID 2 (Nurul Aqilah Khairuni, S/N: 000).', NULL, '2026-10-21 06:42:46'),
(67, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', NULL, '2026-10-21 06:42:55'),
(68, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-10-21 06:43:01'),
(69, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-10-21 06:43:25'),
(70, 8, 'Kemaskini Aset (Admin)', 'Admin \'Nurul Aqilah Khairuni\' kemaskini aset ID 2 (Nurul Aqilah Khairuni, S/N: 000).', NULL, '2026-10-21 06:43:46'),
(71, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', NULL, '2026-10-21 06:44:01'),
(72, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-10-21 06:44:06'),
(73, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-10-21 06:49:48'),
(74, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-10-21 06:49:55'),
(75, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', NULL, '2026-10-21 07:07:51'),
(76, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-10-21 07:07:57'),
(77, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-10-21 08:32:52'),
(78, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', NULL, '2026-10-21 08:33:06'),
(79, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', NULL, '2026-10-21 08:37:04'),
(80, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-10-21 08:37:11'),
(81, 8, 'Padam Aset (Admin)', 'Admin \'Nurul Aqilah Khairuni\' memadam rekod aset ID: 2.', NULL, '2026-10-21 08:55:18'),
(82, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', NULL, '2026-10-22 06:44:46');

-- --------------------------------------------------------

--
-- Table structure for table `department_inventory`
--

CREATE TABLE `department_inventory` (
  `id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `assets_data` longtext DEFAULT NULL,
  `pc_count` int(11) DEFAULT 0,
  `printer_count` int(11) DEFAULT 0,
  `monitor_count` int(11) DEFAULT 0,
  `wifi_count` int(11) DEFAULT 0,
  `laptop_count` int(11) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_inventory`
--

INSERT INTO `department_inventory` (`id`, `department_name`, `assets_data`, `pc_count`, `printer_count`, `monitor_count`, `wifi_count`, `laptop_count`, `updated_at`) VALUES
(1, 'Unit Teknologi Maklumat', '{\"Desktop PC\":12,\"Printer\":6,\"Monitor\":7,\"Laptop\":7}', 12, 6, 7, 11, 7, '2026-06-23 02:09:10');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `lampiran_spec` longtext DEFAULT NULL,
  `jenis_aset` varchar(255) NOT NULL,
  `nombor_siri` varchar(100) NOT NULL,
  `pengguna_terakhir` varchar(255) NOT NULL,
  `tarikh_kerosakan` date DEFAULT NULL,
  `perihal_kerosakan` text NOT NULL,
  `nama_pelapor` varchar(255) NOT NULL,
  `jawatan_pelapor` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('Pending','In Progress','Resolved','Rejected') DEFAULT 'Pending',
  `proses_semasa` varchar(100) DEFAULT NULL,
  `kos_penyelenggaraan_dahulu` decimal(10,2) DEFAULT 0.00,
  `anggaran_kos` decimal(10,2) DEFAULT 0.00,
  `syor_ulasan` text DEFAULT NULL,
  `admin_name_jawatan` varchar(255) DEFAULT NULL,
  `admin_jawatan` varchar(255) DEFAULT NULL,
  `admin_tarikh` date DEFAULT NULL,
  `keputusan` enum('Pending','Diluluskan','Tidak Diluluskan','Syor Dilupuskan') DEFAULT 'Pending',
  `keputusan_nama` varchar(255) DEFAULT NULL,
  `keputusan_jawatan` varchar(255) DEFAULT NULL,
  `keputusan_tarikh` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `staff_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `asset_id`, `lampiran_spec`, `jenis_aset`, `nombor_siri`, `pengguna_terakhir`, `tarikh_kerosakan`, `perihal_kerosakan`, `nama_pelapor`, `jawatan_pelapor`, `location`, `status`, `proses_semasa`, `kos_penyelenggaraan_dahulu`, `anggaran_kos`, `syor_ulasan`, `admin_name_jawatan`, `admin_jawatan`, `admin_tarikh`, `keputusan`, `keputusan_nama`, `keputusan_jawatan`, `keputusan_tarikh`, `created_at`, `staff_verified`) VALUES
(3, 3, NULL, NULL, 'Laptop', '0000', 'Nurul Aqilah Khairuni', '2026-04-25', 'lag', 'Nurul Aqilah Khairuni', 'Staff', '', 'Rejected', NULL, 0.00, 0.00, '', '', '', '2026-04-27', 'Tidak Diluluskan', '', NULL, '2026-04-27', '2026-04-25 07:32:38', 0),
(4, 3, NULL, NULL, 'Printer', '0001', 'Nurul Aqilah Khairuni', '2026-06-22', 'rosak', 'Nurul Aqilah Khairuni', '', '', 'Resolved', NULL, 0.00, 0.00, '', '', '', '2026-07-01', 'Diluluskan', '', NULL, '2026-06-23', '2026-06-22 07:51:49', 0),
(5, 3, NULL, NULL, 'Desktop PC', '0000', 'Nurul Aqilah Khairuni', '2026-07-01', 'rosak', 'Nurul Aqilah Khairuni', '', '', 'Resolved', NULL, 0.00, 0.00, '', '', '', '2026-07-01', 'Syor Dilupuskan', '', NULL, '2026-07-01', '2026-07-01 02:25:45', 0),
(6, 3, NULL, NULL, '', '', 'Nurul Aqilah Khairuni', '2026-09-21', '', 'Nurul Aqilah Khairuni', '', '', 'Pending', NULL, 0.00, 0.00, NULL, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, '2026-09-21 01:11:40', 0),
(7, 3, NULL, NULL, 'Laptop/NoteBook', 'OOOOO', 'OOOOO', '2026-10-15', 'OOOO', 'Nurul Aqilah Khairuni', '', '', 'Pending', NULL, 0.00, 0.00, NULL, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, '2026-10-15 03:53:36', 0),
(8, 3, NULL, NULL, 'Desktop PC', '0000', 'Nurul Aqilah Khairuni', '2026-10-21', 'oooo', 'Nurul Aqilah Khairuni', '', '', 'Pending', NULL, 0.00, 0.00, NULL, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, '2026-10-21 03:47:04', 0),
(9, 3, 1, '{\"asset_id\":1,\"asset_type\":\"Desktop PC\",\"model_komputer\":\"acer\",\"no_siri_pendaftaran\":\"0000\",\"serial_number\":\"0000\",\"model_monitor\":\"acer\",\"serial_monitor\":\"0000\",\"os\":\"window 11\",\"processor\":\"\",\"ram\":\"8gb\",\"hard_disk\":\"512gb\",\"ip_address\":\"0000\",\"printer\":\"tiada\",\"mouse\":\"wireless\",\"keyboard\":\"wireless\",\"ms_office\":\"2021\",\"antivirus\":\"tiada\",\"perisian_lain\":\"tiada\",\"maklumat_ict\":\"\",\"nama_pegawai\":\"Nurul Aqilah Khairuni\",\"jawatan\":\"\",\"jabatan_unit\":\"Unit Teknologi Maklumat\",\"tarikh_lampiran\":\"2026-10-23T01:10:55.000Z\"}', 'Desktop PC', '0000', 'Nurul Aqilah Khairuni', '2026-10-23', 'rosak skrin / perkakasan', 'Nurul Aqilah Khairuni', 'Staff', 'Unit Teknologi Maklumat', 'Pending', NULL, 0.00, 0.00, NULL, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, '2026-10-23 01:10:55', 0),
(10, 3, 1, '{\"asset_id\":1,\"asset_type\":\"Desktop PC\",\"model_komputer\":\"acer\",\"no_siri_pendaftaran\":\"0000\",\"serial_number\":\"0000\",\"model_monitor\":\"acer\",\"serial_monitor\":\"0000\",\"os\":\"window 11\",\"processor\":\"\",\"ram\":\"8gb\",\"hard_disk\":\"512gb\",\"ip_address\":\"0000\",\"printer\":\"tiada\",\"mouse\":\"wireless\",\"keyboard\":\"wireless\",\"ms_office\":\"2021\",\"antivirus\":\"tiada\",\"perisian_lain\":\"tiada\",\"maklumat_ict\":\"\",\"nama_pegawai\":\"Nurul Aqilah Khairuni\",\"jawatan\":\"\",\"jabatan_unit\":\"Unit Teknologi Maklumat\",\"tarikh_lampiran\":\"2026-10-23T01:14:28.000Z\"}', 'Desktop PC', '0000', 'Nurul Aqilah Khairuni', '2026-10-23', 'rosak tidak boleh buka', 'Nurul Aqilah Khairuni', 'Staff', 'Unit Teknologi Maklumat', 'Pending', NULL, 0.00, 0.00, NULL, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, '2026-10-23 01:14:28', 0),
(11, 3, 1, '{\"asset_id\":1,\"asset_type\":\"Desktop PC\",\"model_komputer\":\"acer\",\"no_siri_pendaftaran\":\"0000\",\"serial_number\":\"0000\",\"model_monitor\":\"acer\",\"serial_monitor\":\"0000\",\"os\":\"window 11\",\"processor\":\"\",\"ram\":\"8gb\",\"hard_disk\":\"512gb\",\"ip_address\":\"0000\",\"printer\":\"tiada\",\"mouse\":\"wireless\",\"keyboard\":\"wireless\",\"ms_office\":\"2021\",\"antivirus\":\"tiada\",\"perisian_lain\":\"tiada\",\"maklumat_ict\":\"\",\"nama_pegawai\":\"Nurul Aqilah Khairuni\",\"jawatan\":\"\",\"jabatan_unit\":\"Unit Teknologi Maklumat\",\"tarikh_lampiran\":\"2026-10-23T01:18:20.000Z\"}', 'Desktop PC', '0000', 'Nurul Aqilah Khairuni', '2026-10-23', 'rosak bahagian CPU', 'Nurul Aqilah Khairuni', 'Staff', 'Unit Teknologi Maklumat', 'Pending', NULL, 0.00, 0.00, NULL, NULL, NULL, NULL, 'Pending', NULL, NULL, NULL, '2026-10-23 01:18:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `report_images`
--

CREATE TABLE `report_images` (
  `id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_assets`
--

CREATE TABLE `staff_assets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `asset_type` varchar(100) DEFAULT NULL,
  `model_komputer` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `model_monitor` varchar(255) DEFAULT NULL,
  `serial_monitor` varchar(255) DEFAULT NULL,
  `os` varchar(100) DEFAULT NULL,
  `processor` varchar(255) DEFAULT NULL,
  `ram` varchar(100) DEFAULT NULL,
  `hard_disk` varchar(100) DEFAULT NULL,
  `mouse` varchar(100) DEFAULT NULL,
  `keyboard` varchar(100) DEFAULT NULL,
  `ms_office` varchar(100) DEFAULT NULL,
  `antivirus` varchar(100) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `printer` varchar(100) DEFAULT NULL,
  `perisian_lain` text DEFAULT NULL,
  `no_siri_pendaftaran` varchar(100) NOT NULL,
  `nama_pegawai` varchar(255) NOT NULL,
  `jawatan` varchar(255) NOT NULL,
  `jabatan_unit` varchar(255) NOT NULL,
  `maklumat_ict` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usage_type` varchar(50) DEFAULT 'Staff Use',
  `status` varchar(50) NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disposed_assets`
--

CREATE TABLE `disposed_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) DEFAULT NULL,
  `report_id` int(11) DEFAULT NULL,
  `no_siri_pendaftaran` varchar(100) DEFAULT NULL,
  `serial_number` varchar(255) NOT NULL,
  `asset_type` varchar(100) NOT NULL DEFAULT 'Desktop PC',
  `model_komputer` varchar(255) NOT NULL,
  `nama_pegawai` varchar(255) DEFAULT NULL,
  `jawatan` varchar(255) DEFAULT NULL,
  `jabatan_unit` varchar(255) DEFAULT NULL,
  `tarikh_perolehan` date DEFAULT NULL,
  `harga_perolehan_asal` decimal(10,2) DEFAULT 0.00,
  `tarikh_lupus` date NOT NULL,
  `kaedah_pelupusan` varchar(100) NOT NULL,
  `sebab_lupus` text NOT NULL,
  `no_rujukan_kelulusan` varchar(100) DEFAULT NULL,
  `pegawai_pelulus` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('Syor Dilupuskan','Diluluskan Pelupusan','Selesai Dilupuskan') DEFAULT 'Selesai Dilupuskan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `asset_id` (`asset_id`),
  KEY `report_id` (`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disposed_assets`
--

INSERT INTO `disposed_assets` (`id`, `asset_id`, `report_id`, `no_siri_pendaftaran`, `serial_number`, `asset_type`, `model_komputer`, `nama_pegawai`, `jawatan`, `jabatan_unit`, `tarikh_perolehan`, `harga_perolehan_asal`, `tarikh_lupus`, `kaedah_pelupusan`, `sebab_lupus`, `no_rujukan_kelulusan`, `pegawai_pelulus`, `catatan`, `status`, `created_at`) VALUES
(1, 1, 5, '0000', '0000', 'Desktop PC', 'acer', 'Nurul Aqilah Khairuni', 'Staff', 'Unit Teknologi Maklumat', '2026-01-01', 3200.00, '2026-07-01', 'E-Waste / Buangan Terjadual', 'Aduan KEW.PA-9: rosak', 'KEW.PA-9 #05', 'Super Admin', 'Tiada catatan', 'Selesai Dilupuskan', '2026-07-01 02:25:45');

--
-- Dumping data for table `staff_assets`
--

INSERT INTO `staff_assets` (`id`, `user_id`, `asset_type`, `model_komputer`, `serial_number`, `model_monitor`, `serial_monitor`, `os`, `processor`, `ram`, `hard_disk`, `mouse`, `keyboard`, `ms_office`, `antivirus`, `ip_address`, `printer`, `perisian_lain`, `no_siri_pendaftaran`, `nama_pegawai`, `jawatan`, `jabatan_unit`, `maklumat_ict`, `created_at`, `updated_at`, `usage_type`) VALUES
(1, 3, 'Desktop PC', 'acer', '0000', 'acer', '0000', 'window 11', '', '8gb', '512gb', 'wireless', 'wireless', '2021', 'tiada', '0000', 'tiada', 'tiada', '0000', 'Nurul Aqilah Khairuni', '', 'Unit Teknologi Maklumat', NULL, '2026-06-10 08:03:15', '2026-09-15 00:50:25', 'Staff Use');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`setting_key`, `setting_value`, `updated_at`) VALUES
('maintenance_mode', '0', '2026-05-18 01:33:06'),
('smtp_host', 'smtp.gmail.com', '2026-05-18 01:33:06'),
('smtp_password', '', '2026-05-18 01:33:06'),
('smtp_port', '587', '2026-05-18 01:33:06'),
('smtp_username', '', '2026-05-18 01:33:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `jawatan` varchar(255) DEFAULT NULL,
  `staff_id` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `office` varchar(20) NOT NULL,
  `department` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Staff','Admin','Super Admin') DEFAULT 'Staff',
  `profile_picture` varchar(255) DEFAULT NULL,
  `status` enum('active','suspended') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `jawatan`, `staff_id`, `phone`, `office`, `department`, `password`, `role`, `profile_picture`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nurul Aqilah Khairuni', 'superadmin@mpm.gov.my', NULL, '50130', '-', '-', 'Unit Teknologi Maklumat', '$2y$10$Q3dgrsi0q3mTq1gVLw7yzuuCqh9JADW12sJ0Ktpr8e8Vh2IJpf8Je', 'Super Admin', NULL, 'active', '2026-04-14 02:06:45', '2026-05-18 01:05:04'),
(3, 'Nurul Aqilah Khairuni', 'aqilahkz2003@gmail.com', NULL, '50000', '0103701610', '-', 'Unit Teknologi Maklumat', '$2y$10$E7YI2Uj/.G4g.4QNsel7X.5akU0KWyz4LLwpJkd8JaVeKAEhhwXu2', 'Staff', NULL, 'active', '2026-04-14 07:41:01', '2026-04-15 07:59:22'),
(8, 'Nurul Aqilah Khairuni', 'admin@mpm.gov.my', '-', '51000', '-', '-', 'Unit Teknologi Maklumat', '$2y$10$ItYWLnf2MrUEWe8z7KjUKOHMxVHnc3tTzSaH/P1HUP7hay8J8vX1S', 'Admin', NULL, 'active', '2026-04-23 03:55:54', '2026-09-21 02:29:07');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `asset_images`
--
ALTER TABLE `asset_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `department_inventory`
--
ALTER TABLE `department_inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department_name` (`department_name`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `report_images`
--
ALTER TABLE `report_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_id` (`report_id`);

--
-- Indexes for table `staff_assets`
--
ALTER TABLE `staff_assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_id` (`staff_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `asset_images`
--
ALTER TABLE `asset_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `department_inventory`
--
ALTER TABLE `department_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `disposed_assets`
--
ALTER TABLE `disposed_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `report_images`
--
ALTER TABLE `report_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_assets`
--
ALTER TABLE `staff_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `asset_images`
--
ALTER TABLE `asset_images`
  ADD CONSTRAINT `asset_images_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `staff_assets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_images`
--
ALTER TABLE `report_images`
  ADD CONSTRAINT `report_images_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff_assets`
--
ALTER TABLE `staff_assets`
  ADD CONSTRAINT `staff_assets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Structure for view `assets`
--
CREATE OR REPLACE VIEW `assets` AS SELECT * FROM `staff_assets`;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
