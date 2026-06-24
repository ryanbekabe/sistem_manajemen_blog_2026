-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 24, 2026 at 12:23 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int NOT NULL,
  `id_penulis` int NOT NULL,
  `id_kategori` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hari_tanggal` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `id_penulis`, `id_kategori`, `judul`, `isi`, `gambar`, `hari_tanggal`) VALUES
(1, 1, 1, 'Mengenal AI Generatif', 'Artikel pembuka tentang AI generatif dan penerapannya.', 'default.png', 'Selasa, 24 Juni 2026 | 18:55'),
(3, 4, 2, 'Judul artikel', 'Tes isi artikel.', '9c0285b6465cf3f2589b1f0a73e13bca.png', 'Rabu, 24 Juni 2026 | 19:18');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_artikel`
--

CREATE TABLE `kategori_artikel` (
  `id` int NOT NULL,
  `nama_kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_artikel`
--

INSERT INTO `kategori_artikel` (`id`, `nama_kategori`, `keterangan`) VALUES
(1, 'Teknologi', 'Artikel seputar teknologi dan gadget'),
(2, 'Kesehatan', 'Update keterangan'),
(3, 'Olahraga', 'Berita olahraga');

-- --------------------------------------------------------

--
-- Table structure for table `penulis`
--

CREATE TABLE `penulis` (
  `id` int NOT NULL,
  `nama_depan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_belakang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penulis`
--

INSERT INTO `penulis` (`id`, `nama_depan`, `nama_belakang`, `user_name`, `password`, `foto`) VALUES
(1, 'Andi', 'Wijaya', 'andiw', '$2y$10$OZF5iHnHZZWYTXmv23sUhedoz2/DgcmKi5DnELYmctuy/NM7iVD8K', 'default.png'),
(3, 'Budi', 'Santoso', 'budis', '$2y$10$j0ZEL8K232H.G.NRp7N66.NllQtwZ5vCRz6nFJcvH42XhY/A37Dwe', 'default.png'),
(4, 'Ahmad', 'Fauzi', 'ahmad_f', '$2y$10$j0KS8nNoBx7YTtb37fY78unPC7o1SFVbbuk2N8g5.Ynoc5EgL6NbC', 'f59cd65b11343f74baa6e7d1f169c644.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_artikel_penulis` (`id_penulis`),
  ADD KEY `fk_artikel_kategori` (`id_kategori`);

--
-- Indexes for table `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_nama_kategori` (`nama_kategori`);

--
-- Indexes for table `penulis`
--
ALTER TABLE `penulis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penulis`
--
ALTER TABLE `penulis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `fk_artikel_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_artikel` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_artikel_penulis` FOREIGN KEY (`id_penulis`) REFERENCES `penulis` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
