-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 06:48 PM
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
-- Database: `db_kursus_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `bab`
--

CREATE TABLE `bab` (
  `id_bab` int(11) NOT NULL,
  `id_kursus` int(11) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `urutan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kursus`
--

CREATE TABLE `kursus` (
  `id_kursus` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `waktu_dibuat` timestamp NOT NULL DEFAULT current_timestamp(),
  `thumbnail` varchar(255) DEFAULT NULL,
  `isi_kursus` varchar(255) DEFAULT NULL,
  `course_file` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kursus`
--

INSERT INTO `kursus` (`id_kursus`, `id_kategori`, `judul`, `deskripsi`, `waktu_dibuat`, `thumbnail`, `isi_kursus`, `course_file`) VALUES
(6, NULL, 'adadaadad', 'fafafaf', '2024-11-25 08:08:11', '../assets/thumbnails/6744306bb0059_14 Fakta Tentang Kucing yang Unik dan Menarik copy.jpg', 'assets/courses/6744306bb1a2d_TUGAS 1 Desain and Analisis Algoritma_Safin Nur Imantoro_1065_IF23A.pdf', '');

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL,
  `id_bab` int(11) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `tipe_konten` enum('video','dokumen','kuis') NOT NULL,
  `url_konten` varchar(255) DEFAULT NULL,
  `teks_konten` text DEFAULT NULL,
  `durasi` int(11) DEFAULT NULL,
  `urutan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran_kursus`
--

CREATE TABLE `pendaftaran_kursus` (
  `id_pendaftaran` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `id_kursus` int(11) DEFAULT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp(),
  `persentase_progres` decimal(5,2) DEFAULT 0.00,
  `status` enum('aktif','selesai') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `nomor_telepon` varchar(15) DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `peran` enum('siswa','admin') NOT NULL,
  `aktif` tinyint(1) DEFAULT 1,
  `token_reset_password` varchar(100) DEFAULT NULL,
  `waktu_dibuat` timestamp NOT NULL DEFAULT current_timestamp(),
  `terakhir_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `email`, `password`, `nama_lengkap`, `nomor_telepon`, `foto_profil`, `peran`, `aktif`, `token_reset_password`, `waktu_dibuat`, `terakhir_login`) VALUES
(1, 'admin@admin.com', '$2y$10$uSz0k9RQ/MbkNzUp1okMPOle8v8O3Ggy5AxdYOFu.qQxrs7uUMD5e', 'Administrator', NULL, NULL, 'admin', 1, NULL, '2024-11-25 06:22:40', NULL),
(2, 'fauzyasn@gmail.com', '$2y$10$2BqxcrwISZmx6zxGD1uLpOdFJs/TcWYZudl0cy2TJRxnaje8BYxOa', 'Marsha', NULL, NULL, 'admin', 1, NULL, '2024-11-25 06:52:51', NULL),
(3, 'safinnurimantoro66@gmail.com', '$2y$10$2lXUI1dtxNLUnLmHzfqxMem8VI8biyFYL5n3LdTnwMt9saZ8N4Mmq', 'Deltaa', NULL, NULL, 'admin', 1, NULL, '2024-11-25 06:53:33', NULL),
(4, 'if23.safinimantoro@mhs.ubpkarawang.ac.id', '$2y$10$34kUIzP1UcJUYNYoENbXJelm3kNkcXHGGoMCh4l6jui9mA9WD1VSS', 'hakal', NULL, NULL, 'siswa', 1, NULL, '2024-11-25 06:56:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `progres`
--

CREATE TABLE `progres` (
  `id_progres` int(11) NOT NULL,
  `id_pendaftaran` int(11) DEFAULT NULL,
  `id_materi` int(11) DEFAULT NULL,
  `status` enum('belum_mulai','selesai') DEFAULT 'belum_mulai',
  `waktu_selesai` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bab`
--
ALTER TABLE `bab`
  ADD PRIMARY KEY (`id_bab`),
  ADD KEY `id_kursus` (`id_kursus`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kursus`
--
ALTER TABLE `kursus`
  ADD PRIMARY KEY (`id_kursus`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`),
  ADD KEY `id_bab` (`id_bab`);

--
-- Indexes for table `pendaftaran_kursus`
--
ALTER TABLE `pendaftaran_kursus`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_kursus` (`id_kursus`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `progres`
--
ALTER TABLE `progres`
  ADD PRIMARY KEY (`id_progres`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`),
  ADD KEY `id_materi` (`id_materi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bab`
--
ALTER TABLE `bab`
  MODIFY `id_bab` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kursus`
--
ALTER TABLE `kursus`
  MODIFY `id_kursus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendaftaran_kursus`
--
ALTER TABLE `pendaftaran_kursus`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `progres`
--
ALTER TABLE `progres`
  MODIFY `id_progres` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bab`
--
ALTER TABLE `bab`
  ADD CONSTRAINT `bab_ibfk_1` FOREIGN KEY (`id_kursus`) REFERENCES `kursus` (`id_kursus`) ON DELETE CASCADE;

--
-- Constraints for table `kursus`
--
ALTER TABLE `kursus`
  ADD CONSTRAINT `kursus_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`id_bab`) REFERENCES `bab` (`id_bab`) ON DELETE CASCADE;

--
-- Constraints for table `pendaftaran_kursus`
--
ALTER TABLE `pendaftaran_kursus`
  ADD CONSTRAINT `pendaftaran_kursus_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  ADD CONSTRAINT `pendaftaran_kursus_ibfk_2` FOREIGN KEY (`id_kursus`) REFERENCES `kursus` (`id_kursus`);

--
-- Constraints for table `progres`
--
ALTER TABLE `progres`
  ADD CONSTRAINT `progres_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran_kursus` (`id_pendaftaran`),
  ADD CONSTRAINT `progres_ibfk_2` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
