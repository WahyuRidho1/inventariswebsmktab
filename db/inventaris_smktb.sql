-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2024 at 09:17 AM
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
-- Database: `inventaris_smktb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(2, 'admin', '$2y$10$I/f.ILQC14eoVHCEh1/pg.zZIzKrdr5Gq3/kAHLlH/Bf2o6dg4eg6');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jumlah` int(255) NOT NULL,
  `sumber_id` int(11) DEFAULT NULL,
  `kode_id` int(11) NOT NULL,
  `lokasi_id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `jumlah`, `sumber_id`, `kode_id`, `lokasi_id`, `tanggal`) VALUES
(8, 'Laptop ASUS X454YA RAM 4 GB HDD 500GB', 1, 1, 2, 1, '2024-05-30'),
(9, 'Printer EPSON L5290', 4, 2, 4, 6, '2024-05-30'),
(10, 'Meja Guru IKEA MICKE Meja, putih, 105x50 cm', 10, 2, 3, 7, '2020-06-04'),
(11, 'Kursi Kantor Zyo Jakob Office Chair 64 x 62 x 115 cm Hitam', 10, 2, 2, 7, '2020-06-04');

-- --------------------------------------------------------

--
-- Table structure for table `kode_barang`
--

CREATE TABLE `kode_barang` (
  `id` int(11) NOT NULL,
  `kode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kode_barang`
--

INSERT INTO `kode_barang` (`id`, `kode`) VALUES
(2, '12.14.15.1.1'),
(3, '12.24.13.08'),
(4, '12.44.15.01'),
(5, '11.14.16.05');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id` int(11) NOT NULL,
  `nama_lokasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id`, `nama_lokasi`) VALUES
(1, 'Laboratorium Komputer'),
(2, 'Bengkel Tata Busana'),
(3, 'Bengkel TBSM'),
(4, 'Bengkel TKRO'),
(6, 'Tata Usaha'),
(7, 'Ruang Guru'),
(8, 'Ruang Kepala Sekolah'),
(9, 'Ruang UKS');

-- --------------------------------------------------------

--
-- Table structure for table `sumber`
--

CREATE TABLE `sumber` (
  `id` int(11) NOT NULL,
  `nama_sumber` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sumber`
--

INSERT INTO `sumber` (`id`, `nama_sumber`) VALUES
(1, 'BOSDA'),
(2, 'BOS'),
(4, 'SEKOLAH'),
(5, 'ALOHA'),
(12, 'P3D (Bantuan)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sumber_id` (`sumber_id`),
  ADD KEY `fk_barang_kode` (`kode_id`),
  ADD KEY `fk_barang_lokasi` (`lokasi_id`);

--
-- Indexes for table `kode_barang`
--
ALTER TABLE `kode_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sumber`
--
ALTER TABLE `sumber`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kode_barang`
--
ALTER TABLE `kode_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sumber`
--
ALTER TABLE `sumber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`sumber_id`) REFERENCES `sumber` (`id`),
  ADD CONSTRAINT `fk_barang_kode` FOREIGN KEY (`kode_id`) REFERENCES `kode_barang` (`id`),
  ADD CONSTRAINT `fk_barang_lokasi` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
