-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2023 at 12:21 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nrj_tour`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_bank_admin`
--

CREATE TABLE `data_bank_admin` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_bank` varchar(150) NOT NULL,
  `atas_nama` varchar(250) NOT NULL,
  `no_rek` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_bank_admin`
--

INSERT INTO `data_bank_admin` (`id`, `nama_bank`, `atas_nama`, `no_rek`) VALUES
(1, 'BSI', 'Andi Jafar', '778655671');

-- --------------------------------------------------------

--
-- Table structure for table `data_jamaah`
--

CREATE TABLE `data_jamaah` (
  `id` int(11) UNSIGNED NOT NULL,
  `code_order` varchar(20) NOT NULL,
  `foto_ktp` text NOT NULL,
  `nik` text NOT NULL,
  `nama` varchar(150) NOT NULL,
  `tempat_lahir` varchar(150) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `detail_alamat` text NOT NULL,
  `prov` text NOT NULL,
  `id_prov` int(11) NOT NULL,
  `kab_kota` text NOT NULL,
  `id_kab_kota` int(11) NOT NULL,
  `kec` text NOT NULL,
  `id_kec` int(11) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `status_perkawinan` enum('Belum Kawin','Sudah Kawin','Cerai Hidup','Cerai Mati') NOT NULL,
  `tgl_berangkat` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_jamaah`
--

INSERT INTO `data_jamaah` (`id`, `code_order`, `foto_ktp`, `nik`, `nama`, `tempat_lahir`, `tgl_lahir`, `detail_alamat`, `prov`, `id_prov`, `kab_kota`, `id_kab_kota`, `kec`, `id_kec`, `jk`, `status_perkawinan`, `tgl_berangkat`) VALUES
(1, 'NRJGHTH-310523001', 'assets/images/foto_ktp_jamaah/6476e5315b71c.png', '7371021303980001', 'Dody Setiawan', 'Ujung Padang', '1998-03-13', 'Jl. cendrawasih lr.4', 'Sulawesi Selatan', 28, 'Makassar', 254, 'Mamajang', 3590, 'Laki-laki', 'Belum Kawin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data_penjualan`
--

CREATE TABLE `data_penjualan` (
  `id` int(11) UNSIGNED NOT NULL,
  `code_order` varchar(20) NOT NULL,
  `perekrut` varchar(7) NOT NULL,
  `direkrut` varchar(7) NOT NULL,
  `category` enum('UMROH','HAJI') NOT NULL,
  `is_diskon` enum('GRATIS DP & PELUNASAN','GRATIS DP','TIDAK ADA') NOT NULL,
  `uang_muka` double NOT NULL,
  `bukti_tf_uang_muka` text NOT NULL,
  `paket_pelunasan` enum('REGULER','EKSEKUTIF','RAMADHAN','SYAWAL') DEFAULT NULL,
  `uang_pelunasan` double DEFAULT 0,
  `bukti_tf_pelunasan` text DEFAULT NULL,
  `status` enum('PENDING','DITOLAK','MENUNGGU PELUNASAN','MENUNGGU KONFIRMASI PELUNASAN','PELUNASAN DITOLAK','LUNAS') NOT NULL DEFAULT 'PENDING',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_penjualan`
--

INSERT INTO `data_penjualan` (`id`, `code_order`, `perekrut`, `direkrut`, `category`, `is_diskon`, `uang_muka`, `bukti_tf_uang_muka`, `paket_pelunasan`, `uang_pelunasan`, `bukti_tf_pelunasan`, `status`, `date`) VALUES
(1, 'NRJGHTH-310523001', 'NRJGHTH', 'NRJEUEN', 'UMROH', 'TIDAK ADA', 3500000, 'assets/images/bukti_tf_umroh/6476e53153b6c.png', NULL, 0, NULL, 'PENDING', '2023-05-31 14:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `harga_bonus`
--

CREATE TABLE `harga_bonus` (
  `id` int(11) UNSIGNED NOT NULL,
  `category` enum('PENJUALAN','UPLINE') NOT NULL,
  `umroh` double NOT NULL DEFAULT 0,
  `haji` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `harga_bonus`
--

INSERT INTO `harga_bonus` (`id`, `category`, `umroh`, `haji`) VALUES
(1, 'PENJUALAN', 2000000, 3000000),
(2, 'UPLINE', 250000, 500000);

-- --------------------------------------------------------

--
-- Table structure for table `harga_dp`
--

CREATE TABLE `harga_dp` (
  `id` int(11) UNSIGNED NOT NULL,
  `umroh` double NOT NULL DEFAULT 0,
  `haji` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `harga_dp`
--

INSERT INTO `harga_dp` (`id`, `umroh`, `haji`) VALUES
(1, 3500000, 5000000);

-- --------------------------------------------------------

--
-- Table structure for table `harga_pelunasan`
--

CREATE TABLE `harga_pelunasan` (
  `id` int(11) UNSIGNED NOT NULL,
  `reguler` double NOT NULL DEFAULT 0,
  `eksekutif` double NOT NULL DEFAULT 0,
  `ramadhan` double NOT NULL DEFAULT 0,
  `syawal` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `harga_pelunasan`
--

INSERT INTO `harga_pelunasan` (`id`, `reguler`, `eksekutif`, `ramadhan`, `syawal`) VALUES
(1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pin_user`
--

CREATE TABLE `pin_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `code_referral` varchar(12) NOT NULL,
  `pin_free` varchar(12) NOT NULL,
  `pin_uang_muka` varchar(12) NOT NULL,
  `pin_pelunasan` varchar(12) NOT NULL,
  `date_create` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pin_user`
--

INSERT INTO `pin_user` (`id`, `code_referral`, `pin_free`, `pin_uang_muka`, `pin_pelunasan`, `date_create`) VALUES
(1, 'NRJGHTH', 'GMPM9P5C5581', 'FSLWFZ0134M7', '96WAD2A67H0Y', '2023-05-31');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `code_referral` varchar(7) NOT NULL,
  `email` varchar(250) NOT NULL,
  `name` varchar(25) NOT NULL,
  `no_telpn` varchar(25) NOT NULL,
  `password` text NOT NULL,
  `role_user` enum('ADMIN','OWNER','KONSULTAN') NOT NULL DEFAULT 'KONSULTAN',
  `upline` varchar(7) NOT NULL DEFAULT 'ADMIN',
  `status` enum('AKTIF','TIDAK AKTIF') NOT NULL DEFAULT 'TIDAK AKTIF',
  `join_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `code_referral`, `email`, `name`, `no_telpn`, `password`, `role_user`, `upline`, `status`, `join_date`) VALUES
(1, 'ADMIN', 'admin@nrjtour.com', 'Admin', '87756789012', '$2y$10$t2I6GcF47eB2kDQqFzaSXud5TE2HJjN4wYMMDq8wwL5jJ5mwqwy.e', 'ADMIN', 'ADMIN', 'AKTIF', '2023-05-30 02:29:06'),
(2, 'NRJGHTH', 'asbudi@gmail.com', 'Asbudi Anugrah', '897644556090', '$2y$10$t2I6GcF47eB2kDQqFzaSXud5TE2HJjN4wYMMDq8wwL5jJ5mwqwy.e', 'KONSULTAN', 'ADMIN', 'AKTIF', '2023-05-30 02:29:06'),
(5, 'NRJEUEN', 'setaiwan@gmailc.o', 'Dody Setiawan', '87769952345', '$2y$10$if.8PM4HcW3UEBdcDUJBl.jv0DFw8g0cDKAKRnb4w.Ey1mbOG0DZ6', 'KONSULTAN', 'NRJGHTH', 'TIDAK AKTIF', '2023-05-31 14:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_user`
--

CREATE TABLE `wallet_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `code_referral` varchar(7) NOT NULL,
  `bonus_balance` double DEFAULT 0,
  `poin_balance` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallet_user`
--

INSERT INTO `wallet_user` (`id`, `code_referral`, `bonus_balance`, `poin_balance`) VALUES
(1, 'NRJGHTH', 0, -10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_bank_admin`
--
ALTER TABLE `data_bank_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_jamaah`
--
ALTER TABLE `data_jamaah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_order` (`code_order`);

--
-- Indexes for table `data_penjualan`
--
ALTER TABLE `data_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_order` (`code_order`);

--
-- Indexes for table `harga_bonus`
--
ALTER TABLE `harga_bonus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `harga_dp`
--
ALTER TABLE `harga_dp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `harga_pelunasan`
--
ALTER TABLE `harga_pelunasan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pin_user`
--
ALTER TABLE `pin_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_referral` (`code_referral`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `no_telpn` (`no_telpn`);

--
-- Indexes for table `wallet_user`
--
ALTER TABLE `wallet_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_referral` (`code_referral`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_bank_admin`
--
ALTER TABLE `data_bank_admin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_jamaah`
--
ALTER TABLE `data_jamaah`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_penjualan`
--
ALTER TABLE `data_penjualan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `harga_bonus`
--
ALTER TABLE `harga_bonus`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `harga_dp`
--
ALTER TABLE `harga_dp`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `harga_pelunasan`
--
ALTER TABLE `harga_pelunasan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pin_user`
--
ALTER TABLE `pin_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wallet_user`
--
ALTER TABLE `wallet_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
