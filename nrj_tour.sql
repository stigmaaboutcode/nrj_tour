-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2023 at 06:57 AM
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
(1, 'BSI', 'PT. Nur Rahma Aljami', '7142475531'),
(2, 'BRI', 'PT. Nur Rahma Aljami', '064601000688303');

-- --------------------------------------------------------

--
-- Table structure for table `data_bank_user`
--

CREATE TABLE `data_bank_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `code_referral` varchar(7) NOT NULL,
  `nama_bank` varchar(150) NOT NULL,
  `atas_nama` varchar(250) NOT NULL,
  `no_rek` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `data_kelengkapan_jamaah`
--

CREATE TABLE `data_kelengkapan_jamaah` (
  `id` int(11) UNSIGNED NOT NULL,
  `code_order` varchar(20) NOT NULL,
  `no_passport` varchar(59) NOT NULL,
  `tgl_terbit` date NOT NULL,
  `tgl_berlaku` date NOT NULL,
  `alamat_terbit` text NOT NULL,
  `is_vaksi` enum('YA','TIDAK') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `paket_pelunasan` enum('REGULER','EKSEKUTIF','RAMADHAN','SYAWAL','GRATIS') DEFAULT NULL,
  `uang_pelunasan` double DEFAULT 0,
  `bukti_tf_pelunasan` text DEFAULT NULL,
  `status` enum('PENDING','DITOLAK','MENUNGGU PELUNASAN','MENUNGGU KONFIRMASI PELUNASAN','PELUNASAN DITOLAK','LUNAS') NOT NULL DEFAULT 'PENDING',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 3500000, 75000000);

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
(1, 33450000, 36000000, 41500000, 35000000);

-- --------------------------------------------------------

--
-- Table structure for table `history_bonus_penjualan`
--

CREATE TABLE `history_bonus_penjualan` (
  `id` int(11) UNSIGNED NOT NULL,
  `code_order` varchar(20) NOT NULL,
  `code_referral` varchar(7) NOT NULL,
  `category` enum('UMROH','HAJI') NOT NULL,
  `nominal` double NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_bonus_upline`
--

CREATE TABLE `history_bonus_upline` (
  `id` int(11) UNSIGNED NOT NULL,
  `code_order` varchar(20) NOT NULL,
  `code_referral` varchar(7) NOT NULL,
  `code_referral_downline` varchar(7) NOT NULL,
  `category` enum('UMROH','HAJI') NOT NULL,
  `nominal` double NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pin_user`
--

CREATE TABLE `pin_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `code_referral` varchar(7) NOT NULL,
  `pin` varchar(10) NOT NULL,
  `category` enum('PIN FREE','PIN BERBAYAR','PIN PELUNASAN') NOT NULL,
  `status` enum('BELUM DIGUNAKAN','SUDAH DIGUNAKAN') NOT NULL DEFAULT 'BELUM DIGUNAKAN',
  `date_create` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'ADMIN', 'admin@nrjtour.com', 'admin', '87756789012', '$2y$10$t2I6GcF47eB2kDQqFzaSXud5TE2HJjN4wYMMDq8wwL5jJ5mwqwy.e', 'ADMIN', 'ADMIN', 'AKTIF', '2023-06-15 06:51:06'),
(2, 'NRJGHTH', 'asbudi@gmail.com', 'asbudiap', '87760452233', '$2y$10$6a3ZEikRjqpjtm2m0Yq/huK51ujfOiI9GCX45dKLfTJnboYmipDuC', 'KONSULTAN', 'ADMIN', 'AKTIF', '2023-06-15 06:51:06');

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

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `id` int(11) UNSIGNED NOT NULL,
  `code_referral` varchar(7) NOT NULL,
  `nominal` double NOT NULL,
  `status` enum('PENDING','DITOLAK','SUCCESS') NOT NULL DEFAULT 'PENDING',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_bank_admin`
--
ALTER TABLE `data_bank_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_bank_user`
--
ALTER TABLE `data_bank_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_referral` (`code_referral`);

--
-- Indexes for table `data_jamaah`
--
ALTER TABLE `data_jamaah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_order` (`code_order`);

--
-- Indexes for table `data_kelengkapan_jamaah`
--
ALTER TABLE `data_kelengkapan_jamaah`
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
-- Indexes for table `history_bonus_penjualan`
--
ALTER TABLE `history_bonus_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_order` (`code_order`);

--
-- Indexes for table `history_bonus_upline`
--
ALTER TABLE `history_bonus_upline`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_order` (`code_order`);

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
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_bank_admin`
--
ALTER TABLE `data_bank_admin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_bank_user`
--
ALTER TABLE `data_bank_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_jamaah`
--
ALTER TABLE `data_jamaah`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_kelengkapan_jamaah`
--
ALTER TABLE `data_kelengkapan_jamaah`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_penjualan`
--
ALTER TABLE `data_penjualan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `history_bonus_penjualan`
--
ALTER TABLE `history_bonus_penjualan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_bonus_upline`
--
ALTER TABLE `history_bonus_upline`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pin_user`
--
ALTER TABLE `pin_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wallet_user`
--
ALTER TABLE `wallet_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
