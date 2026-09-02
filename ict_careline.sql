-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2026 at 08:58 AM
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
(4, 3, 'Report Submitted', 'Submitted KEW.PA-9 for Desktop PC (0000)', '2026-07-01 02:25:45');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `details`, `created_at`) VALUES
(1, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-09 04:41:37'),
(2, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', '2026-07-09 04:41:46'),
(3, 1, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) berjaya log masuk sebagai Super Admin.', '2026-07-09 04:41:50'),
(4, 1, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) berjaya log masuk sebagai Super Admin.', '2026-07-09 07:53:54'),
(5, 1, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) telah log keluar.', '2026-07-09 07:54:13'),
(6, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-09 07:54:35'),
(7, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-10 07:19:57'),
(8, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', '2026-07-10 07:27:46'),
(9, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-10 07:27:58'),
(10, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', '2026-07-10 07:29:45'),
(11, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-10 07:29:53'),
(12, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-07-10 07:48:31'),
(13, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-10 07:48:35'),
(14, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', '2026-07-10 07:53:21'),
(15, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-10 07:53:31'),
(16, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-07-10 07:56:15'),
(17, 1, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) berjaya log masuk sebagai Super Admin.', '2026-07-10 07:56:28'),
(18, 1, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) telah log keluar.', '2026-07-10 08:23:13'),
(19, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-10 08:23:31'),
(20, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-07-10 08:24:04'),
(21, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-10 08:24:13'),
(22, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', '2026-07-10 08:57:02'),
(23, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-10 08:57:09'),
(24, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-14 00:52:35'),
(25, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-07-14 01:22:30'),
(26, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-14 03:21:39'),
(27, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-17 01:36:40'),
(28, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-20 01:03:08'),
(29, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', '2026-07-20 01:11:52'),
(30, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-20 01:11:58'),
(31, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', '2026-07-20 01:27:14'),
(32, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-20 01:31:39'),
(33, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-20 02:37:29'),
(34, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', '2026-07-20 02:37:38'),
(35, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-20 02:37:42'),
(36, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-07-20 02:38:48'),
(37, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-20 02:38:53'),
(38, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-20 02:40:45'),
(39, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', '2026-07-20 03:03:09'),
(40, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-20 03:03:12'),
(41, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-07-20 03:35:41'),
(42, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-20 03:35:44'),
(43, 3, 'Hantar Laporan', 'Laporan KEW.PA-9 baru dihantar untuk aset \'Desktop PC\' (S/N: 00000). ID Laporan: 6.', '2026-07-20 03:37:23'),
(44, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', '2026-07-20 03:43:29'),
(45, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-20 03:43:33'),
(46, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-26 23:59:00'),
(47, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-07-27 00:04:39'),
(48, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-27 00:04:45'),
(49, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-07-27 01:08:55'),
(50, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-27 01:36:07'),
(51, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-07-27 03:12:08'),
(52, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-27 03:12:11'),
(53, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-07-27 03:14:31'),
(54, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-27 03:14:36'),
(55, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-07-27 03:42:13'),
(56, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-27 03:42:43'),
(57, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-07-27 06:14:46'),
(58, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-27 06:37:55'),
(59, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-27 08:00:42'),
(60, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-27 08:01:33'),
(61, 8, 'Kemaskini Proses', 'Admin \'Nurul Aqilah Khairuni\' kemaskini proses laporan ID 6 kepada: \'Diterima\'.', '2026-07-27 08:04:50'),
(62, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-07-27 08:04:58'),
(63, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-07-27 08:05:02'),
(64, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', '2026-07-27 08:07:07'),
(65, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-07-27 08:07:13'),
(66, 8, 'Proses Laporan', 'Admin \'Nurul Aqilah Khairuni\' telah memproses Laporan ID 6. Keputusan: \'Tidak Diluluskan\' (Rejected).', '2026-07-27 08:08:39'),
(67, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-08-03 00:49:53'),
(68, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', '2026-08-03 00:55:02'),
(69, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-08-03 00:55:09'),
(70, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-08-03 01:00:06'),
(71, 1, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) berjaya log masuk sebagai Super Admin.', '2026-08-03 01:00:12'),
(72, 1, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) berjaya log masuk sebagai Super Admin.', '2026-08-03 01:19:26'),
(73, 1, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) telah log keluar.', '2026-08-03 01:19:45'),
(74, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-08-03 01:19:53'),
(75, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-08-03 02:04:05'),
(76, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-08-03 02:04:10'),
(77, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-08-03 02:04:19'),
(78, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-08-03 02:04:25'),
(79, 3, 'Kemaskini Aset', 'Aset dikemaskini: Desktop PC (S/N: 0000). ID Aset: 1.', '2026-08-03 02:04:35'),
(80, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', '2026-08-03 02:04:38'),
(81, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-08-03 02:04:42'),
(82, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-08-03 02:09:28'),
(83, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-08-03 02:09:32'),
(84, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-08-03 02:52:50'),
(85, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-08-03 03:06:35'),
(86, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-08-03 03:06:39'),
(87, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-08-03 03:41:40'),
(88, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-09-01 03:53:56'),
(89, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-09-01 03:57:04'),
(90, 8, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) berjaya log masuk sebagai Admin.', '2026-09-01 03:57:20'),
(91, 8, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (51000) telah log keluar.', '2026-09-01 03:57:24'),
(92, 3, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) berjaya log masuk sebagai Staff.', '2026-09-01 03:57:27'),
(93, 3, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50000) telah log keluar.', '2026-09-01 03:57:32'),
(94, 1, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) berjaya log masuk sebagai Super Admin.', '2026-09-01 03:57:38'),
(95, 1, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) berjaya log masuk sebagai Super Admin.', '2026-09-01 03:57:42'),
(96, 1, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) berjaya log masuk sebagai Super Admin.', '2026-09-01 04:02:30'),
(97, 1, 'Log Masuk', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) berjaya log masuk sebagai Super Admin.', '2026-09-01 04:04:50'),
(98, 1, 'Log Keluar', 'Pengguna \'Nurul Aqilah Khairuni\' (50130) telah log keluar.', '2026-09-01 04:09:33');

-- --------------------------------------------------------

--
-- Table structure for table `department_inventory`
--

CREATE TABLE `department_inventory` (
  `id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `assets_data` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_inventory`
--

INSERT INTO `department_inventory` (`id`, `department_name`, `assets_data`, `updated_at`) VALUES
(3, 'Jabatan Kejuruteraan', '{\"PC\":5}', '2026-07-06 00:57:52'),
(5, 'Jabatan Kesihatan dan Pelesenan', '{\"Software\":1}', '2026-07-08 03:42:06');

-- --------------------------------------------------------

--
-- Table structure for table `print_templates`
--

CREATE TABLE `print_templates` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `template_html` longtext DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `print_templates`
--

INSERT INTO `print_templates` (`id`, `name`, `template_html`, `updated_at`) VALUES
(1, 'kewpa9', '<div style=\"font-family: \'Times New Roman\', Times, serif; color: #000; background: #fff; padding: 10px;\">\r\n<div style=\"text-align: right; font-size: 11pt; font-style: italic; margin-bottom: 8px;\">KEW.PA-9</div>\r\n<div style=\"text-align: center; font-weight: bold; text-decoration: underline; font-size: 13pt; margin-bottom: 20px;\">BORANG ADUAN KEROSAKAN ASET ALIH</div>\r\n<div style=\"font-weight: bold; font-size: 10pt; margin-bottom: 8px;\">Bahagian I (Untuk diisi oleh Pengadu)</div>\r\n<div style=\"display: flex; gap: 15px; margin-bottom: 20px;\">\r\n<div style=\"flex: 1;\">\r\n<div style=\"display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"min-width: 160px; flex-shrink: 0;\">1. Jenis Aset</div>\r\n<div style=\"width: 10px; text-align: center; flex-shrink: 0;\">:</div>\r\n<div style=\"flex: 1; border-bottom: 1px solid #000; padding-left: 4px;\">{{jenis_aset}}</div>\r\n</div>\r\n<div style=\"display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"min-width: 160px; flex-shrink: 0;\">2. No. Siri Pendaftaran</div>\r\n<div style=\"width: 10px; text-align: center; flex-shrink: 0;\">:</div>\r\n<div style=\"flex: 1; border-bottom: 1px solid #000; padding-left: 4px;\">{{no_siri}}</div>\r\n</div>\r\n<div style=\"display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"min-width: 160px; flex-shrink: 0;\">3. Pengguna Terakhir</div>\r\n<div style=\"width: 10px; text-align: center; flex-shrink: 0;\">:</div>\r\n<div style=\"flex: 1; border-bottom: 1px solid #000; padding-left: 4px;\">{{pengguna_terakhir}}</div>\r\n</div>\r\n<div style=\"display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"min-width: 160px; flex-shrink: 0;\">4. Tarikh Kerosakan</div>\r\n<div style=\"width: 10px; text-align: center; flex-shrink: 0;\">:</div>\r\n<div style=\"flex: 1; border-bottom: 1px solid #000; padding-left: 4px;\">{{tarikh_kerosakan}}</div>\r\n</div>\r\n<div style=\"display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"min-width: 160px; flex-shrink: 0;\">5. Perihal Kerosakan</div>\r\n<div style=\"width: 10px; text-align: center; flex-shrink: 0;\">:</div>\r\n<div style=\"flex: 1; border-bottom: 1px solid #000; padding-left: 4px;\">{{perihal_kerosakan}}</div>\r\n</div>\r\n<div style=\"display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"min-width: 160px; flex-shrink: 0;\">6. Nama Dan Jawatan</div>\r\n<div style=\"width: 10px; text-align: center; flex-shrink: 0;\">:</div>\r\n<div style=\"flex: 1; display: flex; flex-direction: column;\">\r\n<div style=\"border-bottom: 1px solid #000; padding-left: 4px; min-height: 1.8em;\">{{pengadu_nama}}</div>\r\n<div style=\"border-bottom: 1px solid #000; padding-left: 4px; min-height: 1.8em;\">{{pengadu_jawatan}}</div>\r\n</div>\r\n</div>\r\n<div style=\"display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"min-width: 160px; flex-shrink: 0;\">7. Tarikh</div>\r\n<div style=\"width: 10px; text-align: center; flex-shrink: 0;\">:</div>\r\n<div style=\"flex: 1; border-bottom: 1px solid #000; padding-left: 4px;\">{{tarikh_aduan}}</div>\r\n</div>\r\n</div>\r\n<div style=\"border: 1px solid #000; padding: 12px; width: 240px; font-size: 9pt; display: flex; flex-direction: column; min-height: 160px;\">\r\n<div style=\"font-weight: bold; text-align: center; margin-bottom: 5px;\">PENGESAHAN PENGADU</div>\r\n<div style=\"font-size: 8pt; text-align: center; margin-bottom: auto;\">Adalah disahkan kerosakan aset di atas telah selesai dibaiki / diselenggara.</div>\r\n<div style=\"margin-top: auto; text-align: center;\">\r\n<div style=\"border-bottom: 1px solid #000; height: 25px; margin-bottom: 2px;\">&nbsp;</div>\r\n<div style=\"font-size: 8pt;\">(Tandatangan &amp; Cop)</div>\r\n<div style=\"font-size: 8pt; margin-top: 5px; text-align: left;\">Tarikh:</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div style=\"font-weight: bold; font-size: 10pt; margin-bottom: 8px;\">Bahagian II (Untuk diisi oleh Pegawai Aset / Pegawai Teknikal)</div>\r\n<div style=\"margin-bottom: 8px;\">\r\n<div style=\"display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8; align-items: flex-start;\">\r\n<div style=\"min-width: 240px; flex-shrink: 0;\">1. Jumlah Kos Penyelenggaraan<br>&nbsp;&nbsp;&nbsp;Terdahulu</div>\r\n<div style=\"width: 10px; text-align: center; flex-shrink: 0;\">:</div>\r\n<div style=\"flex: 1; border-bottom: 1px solid #000; padding-left: 4px;\">{{kos_dahulu}}</div>\r\n</div>\r\n<div style=\"display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"min-width: 240px; flex-shrink: 0;\">2. Anggaran Kos Penyelenggaraan</div>\r\n<div style=\"width: 10px; text-align: center; flex-shrink: 0;\">:</div>\r\n<div style=\"flex: 1; border-bottom: 1px solid #000; padding-left: 4px;\">{{anggaran_kos}}</div>\r\n</div>\r\n<div style=\"display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"min-width: 240px; flex-shrink: 0;\">3. Syor Dan Ulasan</div>\r\n<div style=\"width: 10px; text-align: center; flex-shrink: 0;\">:</div>\r\n<div style=\"flex: 1; border-bottom: 1px solid #000; padding-left: 4px;\">{{syor_ulasan}}</div>\r\n</div>\r\n<div style=\"display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"min-width: 240px; flex-shrink: 0;\">&nbsp;</div>\r\n<div style=\"width: 10px; flex-shrink: 0;\">&nbsp;</div>\r\n<div style=\"flex: 1; border-bottom: 1px solid #000; padding-left: 4px;\">&nbsp;</div>\r\n</div>\r\n</div>\r\n<div style=\"margin-bottom: 20px;\">\r\n<div style=\"display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"min-width: 240px; flex-shrink: 0;\">4. Nama Dan Jawatan</div>\r\n<div style=\"width: 10px; text-align: center; flex-shrink: 0;\">:</div>\r\n<div style=\"flex: 1; border-bottom: 1px solid #000; padding-left: 4px;\">{{admin_nama}}</div>\r\n</div>\r\n<div style=\"display: flex; margin-bottom: 4px; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"min-width: 240px; flex-shrink: 0;\">5. Tarikh</div>\r\n<div style=\"width: 10px; text-align: center; flex-shrink: 0;\">:</div>\r\n<div style=\"flex: 1; border-bottom: 1px solid #000; padding-left: 4px;\">{{admin_tarikh}}</div>\r\n</div>\r\n</div>\r\n<div style=\"font-weight: bold; font-size: 10pt; margin-bottom: 8px;\">Bahagian III (Keputusan Ketua Jabatan / Bahagian / Seksyen / Unit)</div>\r\n<div style=\"font-size: 10pt; margin-bottom: 25px; font-weight: bold;\">{{keputusan_line}}</div>\r\n<div style=\"margin-top: 15px;\">\r\n<div style=\"text-align: center; width: 250px; display: inline-block;\">\r\n<div style=\"border-bottom: 1px solid #000; height: 120px; margin-bottom: 3px;\">&nbsp;</div>\r\n<div style=\"font-size: 10pt; margin-bottom: 12px;\">Tandatangan</div>\r\n</div>\r\n<div style=\"display: flex; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"width: 70px; flex-shrink: 0;\">Nama:</div>\r\n<div style=\"width: 350px; border-bottom: 1px solid #000; padding-left: 4px;\">{{kep_nama}}</div>\r\n</div>\r\n<div style=\"display: flex; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"width: 70px; flex-shrink: 0;\">Jawatan:</div>\r\n<div style=\"width: 350px; border-bottom: 1px solid #000; padding-left: 4px;\">{{kep_jawatan}}</div>\r\n</div>\r\n<div style=\"display: flex; font-size: 10pt; line-height: 1.8;\">\r\n<div style=\"width: 70px; flex-shrink: 0;\">Tarikh:</div>\r\n<div style=\"width: 350px; border-bottom: 1px solid #000; padding-left: 4px;\">{{kep_tarikh}}</div>\r\n</div>\r\n</div>\r\n<div style=\"font-size: 9pt; margin-top: 30px; font-style: italic;\">Nota: * Potong mana yang berkenaan</div>\r\n</div>', '2026-07-10 07:56:07');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jenis_aset` varchar(255) NOT NULL,
  `nombor_siri` varchar(100) NOT NULL,
  `pengguna_terakhir` varchar(255) NOT NULL,
  `tarikh_kerosakan` date DEFAULT NULL,
  `perihal_kerosakan` text NOT NULL,
  `nama_pelapor` varchar(255) NOT NULL,
  `jawatan_pelapor` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('Pending','In Progress','Resolved','Rejected') DEFAULT 'Pending',
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
  `staff_verified` tinyint(1) DEFAULT 0,
  `proses_semasa` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `jenis_aset`, `nombor_siri`, `pengguna_terakhir`, `tarikh_kerosakan`, `perihal_kerosakan`, `nama_pelapor`, `jawatan_pelapor`, `location`, `status`, `kos_penyelenggaraan_dahulu`, `anggaran_kos`, `syor_ulasan`, `admin_name_jawatan`, `admin_jawatan`, `admin_tarikh`, `keputusan`, `keputusan_nama`, `keputusan_jawatan`, `keputusan_tarikh`, `created_at`, `staff_verified`, `proses_semasa`) VALUES
(3, 3, 'Laptop', '0000', 'Nurul Aqilah Khairuni', '2026-04-25', 'lag', 'Nurul Aqilah Khairuni', 'Staff', '', 'Rejected', 0.00, 0.00, '', '', '', '2026-04-27', 'Tidak Diluluskan', '', NULL, '0000-00-00', '2026-04-25 07:32:38', 0, NULL),
(4, 3, 'Printer', '0001', 'Nurul Aqilah Khairuni', '2026-06-22', 'rosak', 'Nurul Aqilah Khairuni', '', '', 'Resolved', 0.00, 0.00, '', '', '', '2026-07-01', 'Diluluskan', '', NULL, '2026-06-23', '2026-06-22 07:51:49', 0, NULL),
(5, 3, 'Desktop PC', '0000', 'Nurul Aqilah Khairuni', '2026-07-01', 'rosak', 'Nurul Aqilah Khairuni', '', '', 'Resolved', 0.00, 0.00, '', '', '', '2026-07-01', 'Syor Dilupuskan', '', NULL, '0000-00-00', '2026-07-01 02:25:45', 0, NULL),
(6, 3, 'Desktop PC', '00000', 'Nurul Aqilah Khairuni', '2026-07-20', 'x hidup', 'Nurul Aqilah Khairuni', '', '', 'Rejected', 0.00, 0.00, '', '', '', '2026-07-27', 'Tidak Diluluskan', '', NULL, '0000-00-00', '2026-07-20 03:37:23', 0, 'Diterima');

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
  `usage_type` varchar(50) DEFAULT 'Staff Use'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_assets`
--

INSERT INTO `staff_assets` (`id`, `user_id`, `asset_type`, `model_komputer`, `serial_number`, `model_monitor`, `serial_monitor`, `os`, `processor`, `ram`, `hard_disk`, `mouse`, `keyboard`, `ms_office`, `antivirus`, `ip_address`, `printer`, `perisian_lain`, `no_siri_pendaftaran`, `nama_pegawai`, `jawatan`, `jabatan_unit`, `maklumat_ict`, `created_at`, `updated_at`, `usage_type`) VALUES
(1, 3, 'Desktop PC', 'acer', '0000', 'acer', '0000', 'window 11', '', '8gb', '512gb', 'wireless', 'wireless', '2021', 'tiada', '0000', 'tiada', 'tiada', '', '', '', '', NULL, '2026-06-10 08:03:15', '2026-06-10 08:03:15', 'Staff Use');

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

INSERT INTO `users` (`id`, `name`, `jawatan`, `staff_id`, `phone`, `office`, `department`, `password`, `role`, `profile_picture`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nurul Aqilah Khairuni', NULL, '50130', '-', '-', 'Unit Teknologi Maklumat', '$2y$10$Q3dgrsi0q3mTq1gVLw7yzuuCqh9JADW12sJ0Ktpr8e8Vh2IJpf8Je', 'Super Admin', NULL, 'active', '2026-04-14 02:06:45', '2026-05-18 01:05:04'),
(3, 'Nurul Aqilah Khairuni', NULL, '50000', '0103701610', '-', 'Unit Teknologi Maklumat', '$2y$10$E7YI2Uj/.G4g.4QNsel7X.5akU0KWyz4LLwpJkd8JaVeKAEhhwXu2', 'Staff', NULL, 'active', '2026-04-14 07:41:01', '2026-04-15 07:59:22'),
(8, 'Nurul Aqilah Khairuni', '-', '51000', '-', '-', 'teknologi maklumat', '$2y$10$ItYWLnf2MrUEWe8z7KjUKOHMxVHnc3tTzSaH/P1HUP7hay8J8vX1S', 'Admin', NULL, 'active', '2026-04-23 03:55:54', '2026-06-29 02:33:05');

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
-- Indexes for table `print_templates`
--
ALTER TABLE `print_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `asset_images`
--
ALTER TABLE `asset_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `department_inventory`
--
ALTER TABLE `department_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `print_templates`
--
ALTER TABLE `print_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `report_images`
--
ALTER TABLE `report_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_assets`
--
ALTER TABLE `staff_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
