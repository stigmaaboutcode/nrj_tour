-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2023 at 09:44 AM
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
-- Table structure for table `data_bank_user`
--

CREATE TABLE `data_bank_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `code_referral` varchar(7) NOT NULL,
  `nama_bank` varchar(150) NOT NULL,
  `atas_nama` varchar(250) NOT NULL,
  `no_rek` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_bank_user`
--

INSERT INTO `data_bank_user` (`id`, `code_referral`, `nama_bank`, `atas_nama`, `no_rek`) VALUES
(2, 'NRJGHTH', 'BCA', 'Asbudi Anugrah Patimasang', '7766855996');

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
(1, 'NRJGHTH-310523001', 'assets/images/foto_ktp_jamaah/6476e5315b71c.png', '7371021303980001', 'Dody Setiawan', 'Ujung Padang', '1998-03-13', 'Jl. cendrawasih lr.4', 'Sulawesi Selatan', 28, 'Makassar', 254, 'Mamajang', 3590, 'Laki-laki', 'Belum Kawin', '2023-06-29'),
(2, 'NRJGHTH-010623001', 'assets/images/foto_ktp_jamaah/6477fe5b9615b.jpg', '737101030419990001', 'Ramdan Salim H', 'Makassar', '1999-04-03', 'jl cendrawasih lr 4 no 16', 'Sulawesi Selatan', 28, 'Makassar', 254, 'Mamajang', 3590, 'Laki-laki', 'Belum Kawin', '2023-06-24'),
(5, 'NRJGHTH-050623001', 'assets/images/foto_ktp_jamaah/647d4b22f21b5.JPG', '7371021303980003', 'Asbudi Anugrah', 'Jakarta', '1998-03-13', 'jl cendrawasih', 'Sulawesi Selatan', 28, 'Makassar', 254, 'Mamajang', 3590, 'Laki-laki', 'Belum Kawin', '2023-07-20'),
(6, 'NRJQNXU-060623001', 'assets/images/foto_ktp_jamaah/647ed1bb94e89.jpg', '7371020404980001', 'Ali Amrann', 'Jakarta', '1989-09-14', 'tes', 'Kalimantan Utara', 16, 'Malinau', 257, 'Kayan Selatan', 3642, 'Laki-laki', 'Belum Kawin', '2023-07-09');

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

--
-- Dumping data for table `data_kelengkapan_jamaah`
--

INSERT INTO `data_kelengkapan_jamaah` (`id`, `code_order`, `no_passport`, `tgl_terbit`, `tgl_berlaku`, `alamat_terbit`, `is_vaksi`) VALUES
(3, 'NRJGHTH-310523001', 'A234567', '2023-07-27', '2023-06-30', 'MAKASSAR', 'YA'),
(4, 'NRJGHTH-010623001', 'Q212341', '2023-06-09', '2023-06-12', 'MAKASSAR', 'YA'),
(5, 'NRJGHTH-050623001', 'QW22113', '2023-06-01', '2023-06-30', 'MAKASSAR', 'TIDAK'),
(6, 'NRJQNXU-060623001', 'AQ1232', '2023-04-04', '2026-06-10', 'MAKASSAR', 'TIDAK');

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

--
-- Dumping data for table `data_penjualan`
--

INSERT INTO `data_penjualan` (`id`, `code_order`, `perekrut`, `direkrut`, `category`, `is_diskon`, `uang_muka`, `bukti_tf_uang_muka`, `paket_pelunasan`, `uang_pelunasan`, `bukti_tf_pelunasan`, `status`, `date`) VALUES
(1, 'NRJGHTH-310523001', 'NRJGHTH', 'NRJEUEN', 'UMROH', 'TIDAK ADA', 3500000, 'assets/images/bukti_tf_umroh/6476e53153b6c.png', 'RAMADHAN', 50000000, 'assets/images/bukti_tf_umroh/647ea49641b9c.jpg', 'LUNAS', '2023-05-31 14:12:01'),
(2, 'NRJGHTH-010623001', 'NRJGHTH', 'NRJQNXU', 'UMROH', 'GRATIS DP', 0, 'GRATIS', 'SYAWAL', 32000000, 'assets/images/bukti_tf_umroh/647e7fd349c4b.jpg', 'LUNAS', '2023-06-01 10:11:39'),
(5, 'NRJGHTH-050623001', 'NRJGHTH', 'NRJGHTH', 'UMROH', 'GRATIS DP & PELUNASAN', 0, 'GRATIS', 'GRATIS', 0, 'GRATIS', 'MENUNGGU KONFIRMASI PELUNASAN', '2023-06-05 10:40:34'),
(6, 'NRJQNXU-060623001', 'NRJQNXU', 'NRJVDSK', 'UMROH', 'TIDAK ADA', 3500000, 'assets/images/bukti_tf_umroh/647ed1bb94047.jpg', 'EKSEKUTIF', 45000000, 'assets/images/bukti_tf_umroh/647ed23ecc8af.jpg', 'LUNAS', '2023-06-06 14:27:07');

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
(1, 33000000, 45000000, 50000000, 32000000);

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

--
-- Dumping data for table `history_bonus_penjualan`
--

INSERT INTO `history_bonus_penjualan` (`id`, `code_order`, `code_referral`, `category`, `nominal`, `date`) VALUES
(1, 'NRJGHTH-310523001', 'NRJGHTH', 'UMROH', 2000000, '2023-06-01 12:46:39'),
(2, 'NRJQNXU-060623001', 'NRJQNXU', 'UMROH', 2000000, '2023-06-06 14:27:35');

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

--
-- Dumping data for table `history_bonus_upline`
--

INSERT INTO `history_bonus_upline` (`id`, `code_order`, `code_referral`, `code_referral_downline`, `category`, `nominal`, `date`) VALUES
(1, 'NRJQNXU-060623001', 'NRJGHTH', 'NRJQNXU', 'UMROH', 250000, '2023-06-06 14:08:16');

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
(1, 'NRJGHTH', 'GMPM9P5C5581', 'FSLWFZ0134M7', '96WAD2A67H0Y', '2023-05-31'),
(2, 'NRJGHTH', 'EM1EAQEEN0RQ', 'O3XNQIJ3SQOI', 'VBYHOA52XG5V', '2023-06-01'),
(3, 'NRJGHTH', '47T9LULXWP67', 'VZUWO3CBJ4VE', '2X2QQ3YGFLKG', '2023-06-05'),
(4, 'NRJQNXU', 'TYZ895N2JAI9', 'IZPMN81AIYDG', 'QWDHRB8N1L13', '2023-06-05'),
(5, 'NRJEUEN', '4KR2LI1HEO4O', 'B5PHSTBVGY7L', 'DHEUX3OKETUX', '2023-06-05'),
(6, 'NRJGHTH', '4L2ROK3TVXFN', 'OKYMUX9477F3', 'MV1XGM158EN7', '2023-06-06'),
(7, 'NRJQNXU', 'P97H0JNO70AD', '0ZH1OZL8LB76', 'II86HYEDW5T4', '2023-06-06'),
(8, 'NRJEUEN', '4FBJD7M7M01H', 'JYWFN4AH5M24', 'OHUUKBPJNVPZ', '2023-06-06'),
(9, 'NRJVDSK', 'P3Y8P5QMVKLW', 'RVRW6T0ENQFX', '6O1VXUJMBXX5', '2023-06-07'),
(10, 'NRJGHTH', '6UHD602RWFPZ', '6AMHKYT29AKX', 'UWQFDK53ZIYW', '2023-06-07'),
(11, 'NRJQNXU', 'SL0TKI7MUD6U', 'F5YZOBED2WZW', 'X9RJLQ31ACSV', '2023-06-07'),
(12, 'NRJEUEN', 'G0MP92Q7I92Y', 'LLCIVOVYYLKB', 'A2IOJU2PZ3DG', '2023-06-07');

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
(5, 'NRJEUEN', 'setaiwan@gmailc.o', 'Dody Setiawan', '87769952345', '$2y$10$if.8PM4HcW3UEBdcDUJBl.jv0DFw8g0cDKAKRnb4w.Ey1mbOG0DZ6', 'KONSULTAN', 'NRJGHTH', 'AKTIF', '2023-05-31 14:12:01'),
(6, 'NRJQNXU', 'salimram@gmail.com', 'Ramdan Salim', '87756401234', '$2y$10$/ufx1I/2pdKhGGpIbbJVHOCG7yH4w7lSooegLZDBVfY6m7uHgfH8y', 'KONSULTAN', 'NRJGHTH', 'AKTIF', '2023-06-01 10:11:39'),
(7, 'NRJGHTH', 'asbudi@gmail.com', 'Asbudi Anugrah P', '87760452233', '$2y$10$6a3ZEikRjqpjtm2m0Yq/huK51ujfOiI9GCX45dKLfTJnboYmipDuC', 'KONSULTAN', 'ADMIN', 'AKTIF', '2023-06-03 04:17:49'),
(8, 'NRJVDSK', 'amrann@gmail.com', 'Ali Amran Saja', '87756401233', '$2y$10$wZxwFDH0ZBXupldu8HXE/.5IX16leoqHaCwV1RGe..8R7ukKC7GTC', 'KONSULTAN', 'NRJQNXU', 'AKTIF', '2023-06-06 14:27:07');

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
(1, 'NRJGHTH', 1500000, 0),
(2, 'NRJQNXU', 2000000, 0);

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
-- Dumping data for table `withdraw`
--

INSERT INTO `withdraw` (`id`, `code_referral`, `nominal`, `status`, `date`) VALUES
(1, 'NRJGHTH', 1000000, 'DITOLAK', '2023-06-03 12:07:17'),
(2, 'NRJGHTH', 500000, 'SUCCESS', '2023-06-03 13:38:50');

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_bank_user`
--
ALTER TABLE `data_bank_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_jamaah`
--
ALTER TABLE `data_jamaah`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `data_kelengkapan_jamaah`
--
ALTER TABLE `data_kelengkapan_jamaah`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `data_penjualan`
--
ALTER TABLE `data_penjualan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `history_bonus_upline`
--
ALTER TABLE `history_bonus_upline`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pin_user`
--
ALTER TABLE `pin_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wallet_user`
--
ALTER TABLE `wallet_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
