-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 08, 2025 at 10:20 AM
-- Server version: 9.1.0
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warehouse_kdk`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `sn` varchar(255) NOT NULL,
  `status` int NOT NULL,
  `date_in` datetime NOT NULL,
  `date_out` datetime DEFAULT NULL,
  `user_in` varchar(100) NOT NULL,
  `user_out` varchar(100) DEFAULT NULL,
  `tahun` varchar(10) NOT NULL,
  `bulan` varchar(5) NOT NULL,
  `no_urut` varchar(10) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `customer` varchar(255) DEFAULT NULL,
  `cabang` int NOT NULL,
  `progress_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=159 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `sn`, `status`, `date_in`, `date_out`, `user_in`, `user_out`, `tahun`, `bulan`, `no_urut`, `kategori`, `model`, `customer`, `cabang`, `progress_id`) VALUES
(124, '23046900156', 1, '2023-09-28 15:21:55', '2023-09-28 15:22:48', 'admin', 'admin', '23', '04', '0156', 'Desk Fan', 'WA30V', 'asdf', 4, NULL),
(125, '12345678918', 1, '2023-10-06 10:33:35', NULL, 'joy', NULL, '12', '34', '8918', '56', '56', NULL, 1, NULL),
(131, '12345678903', 1, '2023-10-16 09:00:43', NULL, 'joy', NULL, '12', '34', '8903', 'Ventilating Fan', '30RQN5', NULL, 1, NULL),
(130, '12345678902', 1, '2023-10-16 09:00:35', NULL, 'joy', NULL, '12', '34', '8902', 'Ventilating Fan', '30RQN5', NULL, 1, NULL),
(129, '12345678901', 1, '2023-10-16 09:00:04', NULL, 'joy', NULL, '12', '34', '8901', 'Ventilating Fan', '30RQN5', NULL, 1, NULL),
(132, '12345678904', 1, '2023-10-16 09:00:51', NULL, 'joy', NULL, '12', '34', '8904', 'Ventilating Fan', '30RQN5', NULL, 1, NULL),
(133, '12345678905', 1, '2023-10-16 09:00:58', NULL, 'joy', NULL, '12', '34', '8905', 'Ventilating Fan', '30RQN5', NULL, 1, NULL),
(134, '88875490205', 1, '2023-10-17 15:34:11', NULL, 'joy', NULL, '88', '87', '0205', 'Ventilating Fan', '25RQN5', NULL, 1, NULL),
(135, '888754902057', 1, '2023-10-17 15:34:35', NULL, 'joy', NULL, '88', '87', '02057', 'Ventilating Fan', '25RQN5', NULL, 1, NULL),
(136, '23090200645', 1, '2023-10-17 15:35:33', NULL, 'joy', NULL, '23', '09', '0645', 'Industrial Fan', '40AAS', NULL, 1, NULL),
(137, '23090200618', 1, '2023-10-17 15:36:19', NULL, 'joy', NULL, '23', '09', '0618', 'Industrial Fan', '40AAS', NULL, 1, NULL),
(138, '23090200595', 1, '2023-10-17 15:36:23', NULL, 'joy', NULL, '23', '09', '0595', 'Industrial Fan', '40AAS', NULL, 1, NULL),
(139, '23090200654', 1, '2023-10-17 15:36:27', NULL, 'joy', NULL, '23', '09', '0654', 'Industrial Fan', '40AAS', NULL, 1, NULL),
(140, '23090200648', 1, '2023-10-17 15:36:33', NULL, 'joy', NULL, '23', '09', '0648', 'Industrial Fan', '40AAS', NULL, 1, NULL),
(141, '23090200677', 1, '2023-10-17 15:36:42', NULL, 'joy', NULL, '23', '09', '0677', 'Industrial Fan', '40AAS', NULL, 1, NULL),
(142, '88875494053', 1, '2023-10-17 15:36:57', '2023-10-17 15:43:15', 'joy', 'joy', '88', '87', '4053', 'Ventilating Fan', '25RQN5', 'CSI', 1, NULL),
(143, '21315484648', 1, '2023-10-17 15:37:15', NULL, 'joy', NULL, '21', '31', '4648', 'Ventilating Fan', '25RQN5', NULL, 1, NULL),
(144, '45451348845', 1, '2023-10-17 15:37:21', NULL, 'joy', NULL, '45', '45', '8845', 'Wall Fan', 'WN40B', NULL, 1, NULL),
(145, '64611318151', 1, '2023-10-17 15:37:24', NULL, 'joy', NULL, '64', '61', '8151', 'Wall Fan', 'WN40B', NULL, 1, NULL),
(146, '23075400697', 1, '2023-10-17 15:37:38', NULL, 'joy', NULL, '23', '07', '0697', 'Ventilating Fan', '25RQN5', NULL, 1, NULL),
(147, '21318547646', 1, '2023-10-17 15:37:59', NULL, 'joy', NULL, '21', '31', '7646', 'ceiling Fan Grey', 'WZ56P-GY', NULL, 1, NULL),
(148, '888754940539', 1, '2023-10-17 15:38:51', NULL, 'joy', NULL, '88', '87', '40539', 'Ventilating Fan', '25RQN5', NULL, 1, NULL),
(149, '88875491935', 1, '2023-10-17 15:46:32', NULL, 'joy', NULL, '88', '87', '1935', 'Ventilating Fan', '25RQN5', NULL, 1, NULL),
(150, '23090200649', 1, '2023-10-17 15:53:48', NULL, 'adhim', NULL, '23', '09', '0649', 'Industrial Fan', '40AAS', NULL, 1, NULL),
(151, '22022600083', 1, '2023-10-17 15:54:51', NULL, 'joy', NULL, '22', '02', '0083', 'Stand Fan ', 'WK40X', NULL, 1, NULL),
(152, '23065400741', 1, '2023-10-17 15:55:25', '2023-10-17 15:55:39', 'joy', 'adhim', '23', '06', '0741', 'Ventilating Fan', '25RQN5', 'test', 1, NULL),
(153, '23065400738', 1, '2023-10-17 15:55:47', '2023-10-17 15:55:50', 'joy', 'adhim', '23', '06', '0738', 'Ventilating Fan', '25RQN5', 'test', 1, NULL),
(154, '23090200643', 1, '2023-10-17 15:56:47', NULL, 'joy', NULL, '23', '09', '0643', 'Industrial Fan', '40AAS', NULL, 1, NULL),
(155, '23090200630', 1, '2023-10-17 16:02:26', NULL, 'adhim', NULL, '23', '09', '0630', 'Industrial Fan', '40AAS', NULL, 1, NULL),
(156, '123', 2, '0000-00-00 00:00:00', '2025-11-08 16:17:23', '', '1', '2025', '11', '12', 'Ventilating Fan', '30RQN5', 'CS', 1, NULL),
(157, '123', 2, '2025-11-08 16:19:59', '2025-11-08 16:19:59', 'admin', 'admin', '2025', '11', '12', 'Ventilating Fan', '30RQN5', 'CS', 1, NULL),
(158, '123', 2, '2025-11-08 17:03:56', '2025-11-08 17:03:56', 'admin', 'admin', '2025', '11', '12', 'Ventilating Fan', '30RQN5', 'CS', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_produk`
--

DROP TABLE IF EXISTS `model_produk`;
CREATE TABLE IF NOT EXISTS `model_produk` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kategori` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `status` int NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `model_produk`
--

INSERT INTO `model_produk` (`id`, `kategori`, `model`, `kode`, `status`, `created_at`) VALUES
(1, 'Industrial Fan', '40AAS', '02', 1, '2023-08-18 16:52:50'),
(2, 'Wall Fan', 'WN40B', '13', 1, '2023-08-18 16:52:50'),
(5, 'Stand Fan', 'WK40E-1', '15', 1, '2023-09-20 11:31:02'),
(6, 'Desk Fan', 'WA30V', '69', 1, '2023-09-20 15:16:48'),
(7, 'Stand Fan', 'WM40Z', '17', 1, '2023-09-20 16:06:31'),
(8, 'Stand Fan ', 'WM40X', '19', 1, '2023-09-21 10:47:21'),
(9, 'Stand Fan ', 'WK40X', '26', 1, '2023-09-21 10:49:33'),
(10, 'Auto Fan', 'WR40U', '47', 1, '2023-09-21 10:52:03'),
(11, 'Ventilating Fan', '25RQN5', '54', 1, '2023-09-21 10:52:45'),
(12, 'Ventilating Fan', '30RQN5', '56', 1, '2023-09-21 10:53:02'),
(13, 'Exhaust Fan', '20TGQ2', '60', 1, '2023-09-21 10:53:58'),
(14, 'ceiling Fan White', 'WZ56P-W', '66', 1, '2023-09-21 10:54:52'),
(16, 'Box Fan', 'WG30X', '70', 1, '2023-09-21 15:30:19'),
(17, 'Wall Fan ', 'WB40L', '72', 1, '2023-09-21 15:33:00'),
(18, 'Wall Fan ', 'WN30B', '74', 1, '2023-09-21 15:33:22'),
(19, 'Exhaust fan ', '15TGQ1', '75', 1, '2023-09-21 15:34:02'),
(20, 'Exhaust fan ', '17CDQNA', '81', 1, '2023-09-21 15:34:23'),
(21, 'ceiling Fan Grey', 'WZ56P-GY', '85', 1, '2023-09-21 15:35:20'),
(22, 'Exhaust Fan', '24CDQNA', '90', 1, '2023-09-21 15:35:59'),
(23, 'Wall Fan ', 'WQ40E', '92', 1, '2023-09-21 15:36:35');

-- --------------------------------------------------------

--
-- Table structure for table `penitipan`
--

DROP TABLE IF EXISTS `penitipan`;
CREATE TABLE IF NOT EXISTS `penitipan` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `sn` varchar(255) NOT NULL,
  `status` int NOT NULL,
  `date_in` datetime NOT NULL,
  `date_out` datetime DEFAULT NULL,
  `user_in` varchar(100) NOT NULL,
  `user_out` varchar(100) DEFAULT NULL,
  `tahun` varchar(10) NOT NULL,
  `bulan` varchar(5) NOT NULL,
  `no_urut` varchar(10) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `customer` varchar(255) DEFAULT NULL,
  `cabang` int NOT NULL,
  `cabang_move` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `penitipan`
--

INSERT INTO `penitipan` (`id`, `sn`, `status`, `date_in`, `date_out`, `user_in`, `user_out`, `tahun`, `bulan`, `no_urut`, `kategori`, `model`, `customer`, `cabang`, `cabang_move`) VALUES
(40, '23046900156', 1, '2023-09-28 15:22:48', '2023-09-28 15:23:06', 'admin', 'admin', '23', '04', '0156', 'Desk Fan', 'WA30V', 'asdf', 4, 3),
(42, '23126900880', 1, '2023-10-17 14:29:28', NULL, 'joy', NULL, '', '', '', '', '', 'test', 0, 1),
(43, '23126900880', 1, '2023-10-17 14:29:33', NULL, 'joy', NULL, '', '', '', '', '', 'test', 0, 1),
(44, '23126900888', 1, '2023-10-17 14:30:12', NULL, 'joy', NULL, '', '', '', '', '', 'test', 0, 1),
(45, '23126900888', 1, '2023-10-17 14:30:13', NULL, 'joy', NULL, '', '', '', '', '', 'test', 0, 1),
(46, '23126900888', 1, '2023-10-17 14:30:14', NULL, 'joy', NULL, '', '', '', '', '', 'test', 0, 1),
(47, '23126900888', 1, '2023-10-17 14:30:15', NULL, 'joy', NULL, '', '', '', '', '', 'test', 0, 1),
(48, '23126900888', 1, '2023-10-17 14:30:15', NULL, 'joy', NULL, '', '', '', '', '', 'test', 0, 1),
(49, '23126900888', 1, '2023-10-17 14:30:44', NULL, 'joy', NULL, '', '', '', '', '', 'test', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pindah_produk`
--

DROP TABLE IF EXISTS `pindah_produk`;
CREATE TABLE IF NOT EXISTS `pindah_produk` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `sn` varchar(100) NOT NULL,
  `date_move` datetime NOT NULL,
  `cabang_old` varchar(100) NOT NULL,
  `cabang_move` varchar(100) NOT NULL,
  `user_move` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pindah_produk`
--

INSERT INTO `pindah_produk` (`id`, `sn`, `date_move`, `cabang_old`, `cabang_move`, `user_move`) VALUES
(23, '23046900156', '2023-09-28 15:22:19', '1', '4', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `quantity_progress`
--

DROP TABLE IF EXISTS `quantity_progress`;
CREATE TABLE IF NOT EXISTS `quantity_progress` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantity` int NOT NULL,
  `progress` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `user_id` bigint NOT NULL,
  `username` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `quantity_progress`
--

INSERT INTO `quantity_progress` (`id`, `quantity`, `progress`, `warehouse_id`, `user_id`, `username`, `status`, `creation_date`) VALUES
(1, 100, 9, 1, 1, 'admin', 'Non-Active', '2025-11-08 16:52:42'),
(2, 100, 0, 1, 1, 'admin', 'Non-Active', '2025-11-08 16:47:39'),
(3, 100, 0, 1, 1, 'admin', 'Non-Active', '2025-11-08 03:52:22'),
(4, 100, 0, 1, 1, 'admin', 'Non-Active', '2025-11-08 03:53:40'),
(5, 100, 0, 1, 1, 'admin', 'Non-Active', '2025-11-08 16:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `no_pegawai` varchar(50) NOT NULL,
  `status` int NOT NULL,
  `level` int NOT NULL,
  `cabang` int NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `no_pegawai`, `status`, `level`, `cabang`, `created_at`) VALUES
(1, 'admin', '$2y$10$ZHYbCS4nRqbdq399mfDkpecS20MrQrQd4U7Me6EysWQJgBhGbUUYO', 'admin', '123', 1, 3, 1, '2023-09-27 20:39:00'),
(9, 'scan1', '$2y$10$RxneCcWX7DsJtmuMWssd9uAEZ7/CimXt0MDUaPv9zx0W6zt7GXYXy', 'Scan', '000', 1, 2, 1, '2023-09-22 09:52:00'),
(10, 'scan2', '$2y$10$Jm8UVzMx1f9SNcgpGLi1cu8rcnICx3Wmu0/JCGMAjxJ/BB1XLnfg2', 'scan2', '000', 1, 2, 1, '2023-09-22 09:52:40'),
(6, 'joy', '$2y$10$ojQAuJSZdpUI.S6U5/Yxx.Vc4ZmVfb/4CBX.DtZh7ELw.LjH/qyu.', 'joy', '002', 1, 3, 1, '2023-09-19 21:11:22'),
(7, 'adhim', '$2y$10$n8vWKjfCy8ht2lrKL25xWOb8AxNbkykW29.9sCFTbZ48bsZLLYYpS', 'adhim', '001', 1, 3, 1, '2023-09-21 11:31:24'),
(8, 'syafii', '$2y$10$lSItDEgjiOmo4dIAjXfxU.JunrdktgKfuV1cnE87W8fnsC3HA0EdO', 'syafii', '003', 1, 1, 1, '2023-09-22 09:45:10'),
(11, 'nasuha', '$2y$10$kgP.d9dY2ew6N1Ew1GRcIeXKhE070GVwrsUq.QCf7cLxPWanx4vaW', 'nasuha', '004', 1, 1, 1, '2023-09-22 09:55:21'),
(12, 'HW1', '$2y$10$T/lBOFEnRqpcmxKIr9bwLe5/Hs8RuZbsfjmKrLMUuY5JtVdWIIL5C', 'Hw1', '0005', 1, 2, 1, '2023-09-22 13:58:11');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

DROP TABLE IF EXISTS `warehouse`;
CREATE TABLE IF NOT EXISTS `warehouse` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `status` int NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`id`, `nama`, `deskripsi`, `status`, `created_at`) VALUES
(1, 'Warehouse 1', 'warehouse', 1, '2023-09-03 15:25:09'),
(3, 'Warehouse 2', 'warehouse', 1, '2023-09-03 16:24:05'),
(4, 'Go trans', 'warehouse', 1, '2023-09-19 20:57:27');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
