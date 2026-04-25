-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2026 at 06:01 AM
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
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `asset_number` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `staff_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_images`
--
-- Error reading structure for table ict_careline.asset_images: #1932 - Table &#039;ict_careline.asset_images&#039; doesn&#039;t exist in engine
-- Error reading data for table ict_careline.asset_images: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `ict_careline`.`asset_images`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `department_inventory`
--

CREATE TABLE `department_inventory` (
  `id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
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

INSERT INTO `department_inventory` (`id`, `department_name`, `pc_count`, `printer_count`, `monitor_count`, `wifi_count`, `laptop_count`, `updated_at`) VALUES
(1, 'Unit Teknologi Maklumat', 9, 6, 7, 11, 7, '2026-04-24 12:43:59');

-- --------------------------------------------------------

--
-- Table structure for table `kewpa9_images`
--

CREATE TABLE `kewpa9_images` (
  `id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kewpa9_reports`
--

CREATE TABLE `kewpa9_reports` (
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
  `admin_tarikh` date DEFAULT NULL,
  `keputusan` enum('Pending','Diluluskan','Tidak Diluluskan') DEFAULT 'Pending',
  `keputusan_nama` varchar(255) DEFAULT NULL,
  `keputusan_jawatan` varchar(255) DEFAULT NULL,
  `keputusan_tarikh` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `staff_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kewpa9_reports`
--

INSERT INTO `kewpa9_reports` (`id`, `user_id`, `jenis_aset`, `nombor_siri`, `pengguna_terakhir`, `tarikh_kerosakan`, `perihal_kerosakan`, `nama_pelapor`, `jawatan_pelapor`, `location`, `status`, `kos_penyelenggaraan_dahulu`, `anggaran_kos`, `syor_ulasan`, `admin_name_jawatan`, `admin_tarikh`, `keputusan`, `keputusan_nama`, `keputusan_jawatan`, `keputusan_tarikh`, `created_at`, `staff_verified`) VALUES
(1, 3, 'acer', '0000', 'qila', '2026-04-20', 'lag', 'Nurul Aqilah Khairuni', 'intern', '', 'Rejected', 0.00, 0.00, 'okay', 'qila', '2026-04-21', 'Tidak Diluluskan', 'qila', 'qila', '2026-04-22', '2026-04-20 06:34:27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff_assets`
--

CREATE TABLE `staff_assets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `no_siri_pendaftaran` varchar(100) NOT NULL,
  `nama_pegawai` varchar(255) NOT NULL,
  `jawatan` varchar(255) NOT NULL,
  `jabatan_unit` varchar(255) NOT NULL,
  `maklumat_ict` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usage_type` varchar(50) DEFAULT 'Staff Use'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `office` varchar(20) NOT NULL,
  `department` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Staff','Admin','Super Admin') DEFAULT 'Staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `staff_id`, `phone`, `office`, `department`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin Nurul Aqilah Khairuni', '50130', '-', '-', 'Unit Teknologi Maklumat', 'rkz16102003', 'Super Admin', '2026-04-14 02:06:45', '2026-04-14 06:52:11'),
(3, 'Nurul Aqilah Khairuni', '50000', '0103701610', '-', 'Unit Teknologi Maklumat', '$2y$10$E7YI2Uj/.G4g.4QNsel7X.5akU0KWyz4LLwpJkd8JaVeKAEhhwXu2', 'Staff', '2026-04-14 07:41:01', '2026-04-15 07:59:22'),
(8, 'Nurul Aqilah Khairuni', '51000', '-', '-', 'teknologi maklumat', '$2y$10$ItYWLnf2MrUEWe8z7KjUKOHMxVHnc3tTzSaH/P1HUP7hay8J8vX1S', 'Admin', '2026-04-23 03:55:54', '2026-04-23 03:55:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asset_number` (`asset_number`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `department_inventory`
--
ALTER TABLE `department_inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department_name` (`department_name`);

--
-- Indexes for table `kewpa9_images`
--
ALTER TABLE `kewpa9_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_id` (`report_id`);

--
-- Indexes for table `kewpa9_reports`
--
ALTER TABLE `kewpa9_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `staff_assets`
--
ALTER TABLE `staff_assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department_inventory`
--
ALTER TABLE `department_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kewpa9_images`
--
ALTER TABLE `kewpa9_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kewpa9_reports`
--
ALTER TABLE `kewpa9_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_assets`
--
ALTER TABLE `staff_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `users` (`staff_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `kewpa9_images`
--
ALTER TABLE `kewpa9_images`
  ADD CONSTRAINT `kewpa9_images_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `kewpa9_reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kewpa9_reports`
--
ALTER TABLE `kewpa9_reports`
  ADD CONSTRAINT `kewpa9_reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff_assets`
--
ALTER TABLE `staff_assets`
  ADD CONSTRAINT `staff_assets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
