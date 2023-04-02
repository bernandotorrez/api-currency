-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 02, 2023 at 03:29 PM
-- Server version: 10.5.13-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u422669398_currency`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_count_call_api`
--

CREATE TABLE `tbl_count_call_api` (
  `id` int(11) NOT NULL,
  `id_curr` int(11) NOT NULL,
  `ip_address` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_count_call_api`
--

INSERT INTO `tbl_count_call_api` (`id`, `id_curr`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 2, '203.128.84.18', '2023-02-17 08:15:21', '2023-02-17 08:15:21'),
(2, 20, '203.128.84.18', '2023-02-17 08:16:16', '2023-02-17 08:16:16'),
(3, 3, '203.128.84.18', '2023-02-17 08:16:58', '2023-02-17 08:16:58'),
(4, 16, '139.255.251.34', '2023-02-17 08:20:20', '2023-02-17 08:20:20'),
(5, 2, '139.255.251.34', '2023-02-17 08:20:23', '2023-02-17 08:20:23'),
(6, 4, '139.255.251.34', '2023-02-17 08:21:15', '2023-02-17 08:21:15'),
(7, 4, '125.165.70.171', '2023-02-17 23:14:12', '2023-02-17 23:14:12'),
(8, 4, '125.165.70.171', '2023-02-17 23:14:19', '2023-02-17 23:14:19'),
(9, 0, '125.165.70.171', '2023-02-20 03:35:39', '2023-02-20 03:35:39'),
(10, 0, '125.165.70.171', '2023-02-20 03:35:56', '2023-02-20 03:35:56'),
(11, 0, '125.165.70.171', '2023-02-20 03:36:15', '2023-02-20 03:36:15'),
(12, 0, '125.165.70.171', '2023-02-20 03:36:18', '2023-02-20 03:36:18'),
(13, 0, '125.165.70.171', '2023-02-20 03:36:20', '2023-02-20 03:36:20'),
(14, 0, '125.165.70.171', '2023-02-20 03:38:00', '2023-02-20 03:38:00'),
(15, 0, '125.165.70.171', '2023-02-20 03:38:02', '2023-02-20 03:38:02'),
(16, 0, '125.165.70.171', '2023-02-20 03:38:15', '2023-02-20 03:38:15'),
(17, 0, '125.165.70.171', '2023-02-20 03:40:11', '2023-02-20 03:40:11'),
(18, 0, '125.165.70.171', '2023-02-20 03:40:29', '2023-02-20 03:40:29'),
(19, 0, '125.165.70.171', '2023-02-20 03:41:57', '2023-02-20 03:41:57'),
(20, 0, '125.165.70.171', '2023-02-20 03:42:07', '2023-02-20 03:42:07'),
(21, 0, '125.165.70.171', '2023-02-20 03:42:08', '2023-02-20 03:42:08'),
(22, 0, '125.165.70.171', '2023-02-20 03:42:09', '2023-02-20 03:42:09'),
(23, 0, '125.165.70.171', '2023-02-20 03:42:19', '2023-02-20 03:42:19'),
(24, 0, '125.165.70.171', '2023-02-20 03:42:23', '2023-02-20 03:42:23'),
(25, 0, '125.165.70.171', '2023-02-20 03:42:38', '2023-02-20 03:42:38'),
(26, 0, '125.165.70.171', '2023-02-20 03:44:01', '2023-02-20 03:44:01'),
(27, 0, '125.165.70.171', '2023-02-20 03:44:14', '2023-02-20 03:44:14'),
(28, 0, '125.165.70.171', '2023-02-20 03:44:24', '2023-02-20 03:44:24'),
(29, 0, '125.165.70.171', '2023-02-20 03:44:31', '2023-02-20 03:44:31'),
(30, 0, '125.165.70.171', '2023-02-20 03:44:44', '2023-02-20 03:44:44'),
(31, 0, '125.165.70.171', '2023-02-20 03:45:03', '2023-02-20 03:45:03'),
(32, 0, '125.165.70.171', '2023-02-20 03:45:04', '2023-02-20 03:45:04'),
(33, 0, '125.165.70.171', '2023-02-20 03:45:05', '2023-02-20 03:45:05'),
(34, 0, '125.165.70.171', '2023-02-20 08:36:29', '2023-02-20 08:36:29'),
(35, 0, '110.137.194.106', '2023-02-21 02:34:47', '2023-02-21 02:34:47'),
(36, 0, '110.137.194.106', '2023-02-21 02:35:22', '2023-02-21 02:35:22'),
(37, 0, '110.137.194.106', '2023-02-21 02:36:32', '2023-02-21 02:36:32'),
(38, 0, '110.137.194.106', '2023-02-21 02:36:41', '2023-02-21 02:36:41'),
(39, 0, '110.137.194.106', '2023-02-21 04:50:05', '2023-02-21 04:50:05'),
(40, 0, '110.138.40.165', '2023-03-04 03:08:51', '2023-03-04 03:08:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_curr`
--

CREATE TABLE `tbl_curr` (
  `id_curr` int(3) NOT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_create` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `mention` varchar(50) DEFAULT NULL,
  `temp_conversi` double(25,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_curr`
--

INSERT INTO `tbl_curr` (`id_curr`, `currency`, `status`, `date_create`, `date_update`, `remarks`, `mention`, `temp_conversi`) VALUES
(1, 'IDR', 1, '2019-10-31 09:06:29', NULL, NULL, 'Rupiah', NULL),
(2, 'USD', 1, '2019-10-31 09:06:29', NULL, NULL, 'Dollar', NULL),
(3, 'SGD', 1, '2019-10-31 09:06:29', NULL, NULL, 'Dollar SG', NULL),
(4, 'EUR', 1, '2019-10-31 09:06:29', NULL, NULL, 'Euro', NULL),
(5, 'DEM', 1, '2019-10-31 09:06:29', NULL, NULL, 'Deutsche Mark', NULL),
(6, 'ITL', 1, '2019-10-31 09:06:29', NULL, NULL, 'Lira', NULL),
(7, 'RM', 0, '2019-10-31 09:06:29', '2020-10-27 17:34:48', 'Action : Delete | User Created : id -> 901 , username -> bernand , nama -> bernand', 'Ringgit', NULL),
(8, 'THB', 1, '2019-10-31 09:06:29', NULL, NULL, 'Baht', NULL),
(9, 'TWD', 1, '2019-10-31 09:06:29', NULL, NULL, 'New Taiwan Dollar', NULL),
(10, 'AED', 1, '2019-10-31 09:06:29', NULL, NULL, 'Dirham', NULL),
(11, 'AUD', 1, '2019-10-31 09:06:29', NULL, NULL, 'Australian Dollar', NULL),
(12, 'NT', 1, '2019-10-31 09:06:29', NULL, NULL, 'New Taiwan Dollar', NULL),
(13, 'RMB ', 0, '2019-10-31 09:06:29', '2020-10-27 17:34:37', 'Action : Delete | User Created : id -> 901 , username -> bernand , nama -> bernand', 'Yuan', NULL),
(14, 'HKD', 1, '2019-10-31 09:06:29', NULL, NULL, 'Hongkong Dollar', NULL),
(15, 'MYR ', 1, '2019-10-31 09:06:29', NULL, NULL, 'Ringgit', NULL),
(16, 'GBP ', 1, '2019-10-31 09:06:29', NULL, NULL, 'Pound Sterling', NULL),
(18, 'KRW', 1, '2019-10-31 09:06:29', NULL, NULL, 'Won', NULL),
(19, 'CAD', 1, '2019-10-31 09:06:29', NULL, NULL, 'Canadian Dollar', NULL),
(20, 'JPY', 1, '2019-10-31 09:06:29', NULL, NULL, 'Yen', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_count_call_api`
--
ALTER TABLE `tbl_count_call_api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_curr`
--
ALTER TABLE `tbl_curr`
  ADD PRIMARY KEY (`id_curr`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_count_call_api`
--
ALTER TABLE `tbl_count_call_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_curr`
--
ALTER TABLE `tbl_curr`
  MODIFY `id_curr` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
