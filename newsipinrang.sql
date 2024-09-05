-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 27, 2024 at 04:21 PM
-- Server version: 10.6.18-MariaDB
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newsipinrang`
--

-- --------------------------------------------------------

--
-- Table structure for table `daftar_sesi_peminjaman`
--

CREATE TABLE `daftar_sesi_peminjaman` (
  `id` int(11) NOT NULL,
  `kodeSesi` int(11) NOT NULL,
  `namaSesi` varchar(25) NOT NULL,
  `waktuSesi` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daftar_sesi_peminjaman`
--

INSERT INTO `daftar_sesi_peminjaman` (`id`, `kodeSesi`, `namaSesi`, `waktuSesi`) VALUES
(1, 1, 'Sesi 1 (08.00 - 10.00)', '08.00 - 10.00'),
(2, 2, 'Sesi 2 (10.00 - 12.00)', '10.00 - 12.00'),
(3, 3, 'Sesi 3 (12.00 - 14.00)', '12.00 - 14.00'),
(4, 4, 'Sesi 4 (14.00 - 16.00)', '14.00 - 16.00'),
(5, 5, 'Sesi 5 (16.00 - 18.00)', '16.00 - 18.00');

-- --------------------------------------------------------

--
-- Table structure for table `daftar_status_peminjaman`
--

CREATE TABLE `daftar_status_peminjaman` (
  `id` int(11) NOT NULL,
  `kode` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daftar_status_peminjaman`
--

INSERT INTO `daftar_status_peminjaman` (`id`, `kode`, `status`) VALUES
(1, 1, 'Proses Persetujuan BAU'),
(2, 2, 'Disetujui'),
(3, 3, 'Ditolak');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `id_pinjam` varchar(255) NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `dresscode` varchar(100) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `dibuat_tanggal` date NOT NULL,
  `diperlukan_tanggal` date NOT NULL,
  `ruang` varchar(50) NOT NULL,
  `sesi` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `last_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_pinjam`, `kegiatan`, `dresscode`, `unit`, `dibuat_tanggal`, `diperlukan_tanggal`, `ruang`, `sesi`, `status`, `keterangan`, `last_update`) VALUES
(1, 'rzIoa', 'Seminar 1', 'PDA', 'BAU', '2024-06-11', '2024-06-11', 'Auditorium', 4, 2, '', '2024-06-11 00:50:31'),
(2, 'mttBO', 'Seminar 2', 'PDO', 'BAU', '2024-06-11', '2024-06-14', 'Auditorium', 1, 2, '', '2024-06-11 00:50:53'),
(3, '01YoY', 'Seminar 3', 'Batik', 'BAU', '2024-06-11', '2024-06-17', 'Auditorium', 5, 3, '', '2024-06-11 00:51:16'),
(4, 'Ys4kz', 'Rapat Besar 1', 'Hitam', 'BEM', '2024-06-11', '2024-06-13', 'Auditorium', 5, 3, '', '2024-06-13 05:23:15'),
(5, 'x6xEz', 'Rapat Besar 2', 'PDO', 'BEM', '2024-06-11', '2024-06-14', 'Auditorium', 5, 3, '', '2024-06-13 05:28:33'),
(6, 'orjvH', 'Gathering 1', 'PDO', 'UKM KOMNET', '2024-06-14', '2024-06-15', '321', 5, 2, '', '2024-06-14 20:56:42'),
(7, 'yFTlk', 'Seminar 4', 'Batik', 'BAU', '2024-06-14', '2024-06-20', 'Auditorium', 3, 2, '', '2024-06-14 21:29:45'),
(8, '8mdJu', 'Test 1 User', 'PDO', 'USER', '2024-06-14', '2024-06-16', '321', 1, 3, '', '2024-06-14 21:30:09'),
(9, 'a4OQZ', 'Gathering BEM', 'Batik', 'BEM', '2024-06-16', '2024-06-16', '331', 5, 1, '', '2024-06-16 13:47:22'),
(10, 'z4A4X', 'Test 2 User', 'PDA/PDO', 'USER', '2024-06-16', '2024-06-17', '321', 5, 1, '', '2024-06-16 13:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `ruang`
--

CREATE TABLE `ruang` (
  `id` int(11) NOT NULL,
  `gedung` varchar(50) NOT NULL,
  `ruang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ruang`
--

INSERT INTO `ruang` (`id`, `gedung`, `ruang`) VALUES
(1, 'Gedung 2', '241'),
(2, 'Gedung 2', '242'),
(3, 'Gedung 2', '251'),
(4, 'Gedung 2', '252'),
(5, 'Gedung 2', '253'),
(6, 'Gedung 2', '254'),
(7, 'Gedung 2', '256'),
(8, 'Gedung 2', '257'),
(9, 'Gedung 2', '261'),
(10, 'Gedung 2', '262'),
(11, 'Gedung 2', '263'),
(12, 'Gedung 2', '264'),
(13, 'Gedung 2', '266'),
(14, 'Gedung 2', '267'),
(15, 'Gedung 3', '321'),
(16, 'Gedung 3', '322'),
(17, 'Gedung 3', '323'),
(18, 'Gedung 3', '324'),
(19, 'Gedung 3', '325'),
(20, 'Gedung 3', '326'),
(21, 'Gedung 3', '327'),
(22, 'Gedung 3', '328'),
(23, 'Gedung 3', '331'),
(24, 'Gedung 3', '332'),
(25, 'Gedung 3', '333'),
(26, 'Gedung 3', '334'),
(27, 'Gedung 3', '335'),
(28, 'Gedung 3', '336'),
(29, 'Gedung 3', '337'),
(30, 'Gedung 3', '338'),
(31, 'Gedung 3', '341'),
(32, 'Gedung 3', '342'),
(33, 'Gedung 3', '343'),
(34, 'Gedung 3', '344'),
(35, 'Gedung 3', '345'),
(36, 'Gedung 3', '346'),
(37, 'Gedung 3', '347'),
(38, 'Gedung 3', '348'),
(39, 'Auditorium', 'Auditorium');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_img_path` varchar(255) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `no_wa` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `unit`, `password`, `profile_img_path`, `level`, `no_wa`) VALUES
(1, 'bau', 'BAU', '$2y$10$scX/2YwfIy876HIARybAsejs0A66b6FsLsW/xr3rGaKGkXOfXTO7O', NULL, 1, NULL),
(2, 'bem', 'BEM', '$2y$10$q4oIAyBWtRh4m2wf.3BcI.2JaHFE9WSuCeCIRl3fnhwa8clVw9qsa', NULL, 2, NULL),
(3, 'user', 'USER', '$2y$10$XE0dtljah/cVvB3FQCsYiO2du6ChzyEE/PtLZvJIo8ZfuglMOp1X6', NULL, 3, NULL),
(4, 'guest', 'GUEST', '$2y$10$14NrcWek.oPoEElCDemjB.F0xabK42LcFSjxlWROM3UiMgtiUmN6.', NULL, 4, NULL),
(5, 'komnet', 'UKM KOMNET', '$2y$10$D7ZLZtd8Ihq.dMw.liqTDucFXH77XPBBfKRrwMq6WzoYUtZZxhBJm', NULL, 3, NULL),
(6, 'nihongobu', 'UKM NIHONGOBU', '$2y$10$rlQVBm7tC5FpoEB6TT4LpOgz5nvHCSj8ybvlMeP9sT.nZyH5t9UR2', NULL, 3, NULL),
(7, 'forkas', 'UKM FORKAS', '$2y$10$o7fKVdb17HeCS/mksjG1reZteIoJAij297V7UKgIvHyhouxqMvv5i', NULL, 3, NULL),
(8, 'ukmses', 'UKM SES', '$2y$10$H62wpDWIJfh3bMGz1E8RQ.meyYuU5GNxrP836IKitxbV10j3OM8xu', NULL, 3, NULL),
(9, 'bimbel', 'UKM BIMBEL', '$2y$10$yabqc.W5Hm.l7pmXH.9MWuI59Lrp8LfDJ21ry1fx4Kge8tDC0fP6y', NULL, 3, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_sesi_peminjaman`
--
ALTER TABLE `daftar_sesi_peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kodeSesi` (`kodeSesi`);

--
-- Indexes for table `daftar_status_peminjaman`
--
ALTER TABLE `daftar_status_peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_pinjam` (`id_pinjam`),
  ADD KEY `unit` (`unit`),
  ADD KEY `ruang` (`ruang`),
  ADD KEY `peminjaman_ibfk_3` (`sesi`),
  ADD KEY `peminjaman_ibfk_4` (`status`);

--
-- Indexes for table `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ruang` (`ruang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `unit` (`unit`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_sesi_peminjaman`
--
ALTER TABLE `daftar_sesi_peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `daftar_status_peminjaman`
--
ALTER TABLE `daftar_status_peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ruang`
--
ALTER TABLE `ruang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`unit`) REFERENCES `user` (`unit`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`ruang`) REFERENCES `ruang` (`ruang`),
  ADD CONSTRAINT `peminjaman_ibfk_3` FOREIGN KEY (`sesi`) REFERENCES `daftar_sesi_peminjaman` (`kodeSesi`),
  ADD CONSTRAINT `peminjaman_ibfk_4` FOREIGN KEY (`status`) REFERENCES `daftar_status_peminjaman` (`kode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
