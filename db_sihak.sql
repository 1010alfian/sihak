-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2022 at 09:15 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sihak`
--

-- --------------------------------------------------------

--
-- Table structure for table `bukti_bayar`
--

CREATE TABLE `bukti_bayar` (
  `id_bukti` int(11) NOT NULL,
  `no_berkas` int(11) NOT NULL,
  `nama_bank` varchar(255) NOT NULL,
  `nama_pemilik_tabungan` varchar(255) NOT NULL,
  `nominal` int(11) NOT NULL,
  `bukti_bayar` varchar(500) NOT NULL,
  `id_pemohon` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bukti_bayar`
--

INSERT INTO `bukti_bayar` (`id_bukti`, `no_berkas`, `nama_bank`, `nama_pemilik_tabungan`, `nominal`, `bukti_bayar`, `id_pemohon`, `status`) VALUES
(6, 1, 'BCA', 'Jaja', 1000000, 'mceclip0.png', 44, 2),
(7, 2, 'Mandiri', 'Jaja', 1000000, 'mceclip01.png', 45, 2);

-- --------------------------------------------------------

--
-- Table structure for table `janji_temu`
--

CREATE TABLE `janji_temu` (
  `id_janji` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `janji_temu`
--

INSERT INTO `janji_temu` (`id_janji`, `id_user`, `nama`, `tgl`, `status`, `created_at`) VALUES
(18, 12, 'Jaja Miharja', '2022-08-13 18:14:53', 3, '2022-08-13 17:23:12');

-- --------------------------------------------------------

--
-- Table structure for table `no_hak`
--

CREATE TABLE `no_hak` (
  `id_hak` int(11) NOT NULL,
  `id_pemohon` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `no_hak` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dilakukan_oleh_id` int(11) NOT NULL,
  `dilakukan_oleh_nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `no_hak`
--

INSERT INTO `no_hak` (`id_hak`, `id_pemohon`, `id_user`, `no_hak`, `created_at`, `dilakukan_oleh_id`, `dilakukan_oleh_nama`) VALUES
(7, 44, 12, 1, '2022-08-13 17:06:05', 13, 'Kasubsi'),
(8, 45, 12, 2, '2022-08-13 18:10:28', 13, 'Kasubsi');

-- --------------------------------------------------------

--
-- Table structure for table `pemohon`
--

CREATE TABLE `pemohon` (
  `id_pemohon` int(11) NOT NULL,
  `pengajuan` varchar(500) NOT NULL,
  `nama_pemohon` varchar(256) NOT NULL,
  `nik` int(11) NOT NULL,
  `ktp` varchar(255) NOT NULL,
  `no_imb` int(11) NOT NULL,
  `dok_imb` varchar(255) NOT NULL,
  `no_sppt` int(11) NOT NULL,
  `dok_sppt` varchar(255) NOT NULL,
  `no_berkas` varchar(256) NOT NULL,
  `luas_tanah` int(11) NOT NULL,
  `alamat_tanah` varchar(500) NOT NULL,
  `no_sertifikat` int(11) NOT NULL,
  `dok_sertifikat` varchar(500) NOT NULL,
  `status` int(1) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pemohon`
--

INSERT INTO `pemohon` (`id_pemohon`, `pengajuan`, `nama_pemohon`, `nik`, `ktp`, `no_imb`, `dok_imb`, `no_sppt`, `dok_sppt`, `no_berkas`, `luas_tanah`, `alamat_tanah`, `no_sertifikat`, `dok_sertifikat`, `status`, `id_user`, `created_at`) VALUES
(44, 'Pengajuan 1', 'Jaja Miharja', 12345, 'KTP.png', 12345, 'IMB.docx', 12345, 'SPPT.docx', '1', 2, 'Subang', 12345, 'Sertifikat.docx', 1, 12, '2022-08-13 06:27:39'),
(45, 'Pengajuan 2', 'Jaja Miharja', 6789, 'KTP1.png', 6789, 'IMB1.docx', 6789, 'SPPT1.docx', '2', 1, 'Bandung', 6789, 'Sertifikat1.docx', 1, 12, '2022-08-13 18:02:53');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `role`) VALUES
(1, 'admin'),
(2, 'member'),
(3, 'Kasubsi');

-- --------------------------------------------------------

--
-- Table structure for table `tolak`
--

CREATE TABLE `tolak` (
  `id_tolak` int(11) NOT NULL,
  `id_pemohon` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `tolak_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tolak_janji_temu`
--

CREATE TABLE `tolak_janji_temu` (
  `id_tolak_janji` int(11) NOT NULL,
  `id_janji` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `tolak_janji_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tolak_janji_temu`
--

INSERT INTO `tolak_janji_temu` (`id_tolak_janji`, `id_janji`, `id_user`, `keterangan`, `tolak_janji_at`) VALUES
(2, 18, 12, 'Ada janji lain.', '2022-08-13 18:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `created_at` varchar(128) NOT NULL,
  `last_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `created_at`, `last_login`) VALUES
(11, 'admin', 'admin@gmail.com', 'default.jpg', '$2y$10$giOI6emP4AfGB8kveZ6Kc.oQ7/p4N/yk/8Qi3muGvE38rIXt/hXta', 1, 1, '02/07/2022 18:09:21', 0),
(12, 'Jaja Miharja', 'member1@gmail.com', 'default.jpg', '$2y$10$ULMjKzi5/3cNPsEPubk.3.JNcL9rNSJhQvH.zikvpAd9l50sg/Gfm', 2, 1, '02/07/2022 18:09:36', 0),
(13, 'Kasubsi', 'kasubsi@gmail.com', 'default.jpg', '$2y$10$uupQcryNJgTTp7QZrjnfoe7r4oPc.Ue1adCFqjqub8EWLNGNXg4gG', 3, 1, '31/07/2022 10:21:50', 0),
(14, 'Prawowo', 'member2@gmail.com', 'default.jpg', '$2y$10$hfHa/4Tbtil4FJfLi8dU9uXftpbm2PV87kB7HSM6Br8cFurKXK7wq', 2, 1, '31/07/2022 13:20:37', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bukti_bayar`
--
ALTER TABLE `bukti_bayar`
  ADD PRIMARY KEY (`id_bukti`);

--
-- Indexes for table `janji_temu`
--
ALTER TABLE `janji_temu`
  ADD PRIMARY KEY (`id_janji`);

--
-- Indexes for table `no_hak`
--
ALTER TABLE `no_hak`
  ADD PRIMARY KEY (`id_hak`);

--
-- Indexes for table `pemohon`
--
ALTER TABLE `pemohon`
  ADD PRIMARY KEY (`id_pemohon`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `tolak`
--
ALTER TABLE `tolak`
  ADD PRIMARY KEY (`id_tolak`);

--
-- Indexes for table `tolak_janji_temu`
--
ALTER TABLE `tolak_janji_temu`
  ADD PRIMARY KEY (`id_tolak_janji`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bukti_bayar`
--
ALTER TABLE `bukti_bayar`
  MODIFY `id_bukti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `janji_temu`
--
ALTER TABLE `janji_temu`
  MODIFY `id_janji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `no_hak`
--
ALTER TABLE `no_hak`
  MODIFY `id_hak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pemohon`
--
ALTER TABLE `pemohon`
  MODIFY `id_pemohon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tolak`
--
ALTER TABLE `tolak`
  MODIFY `id_tolak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tolak_janji_temu`
--
ALTER TABLE `tolak_janji_temu`
  MODIFY `id_tolak_janji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
