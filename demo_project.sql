-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2023 at 12:03 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `router_details`
--

CREATE TABLE `router_details` (
  `id` int(11) NOT NULL,
  `sapid` varchar(18) DEFAULT NULL,
  `hostname` varchar(14) DEFAULT NULL,
  `loopback` varchar(16) DEFAULT NULL,
  `macaddress` varchar(17) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `router_details`
--

INSERT INTO `router_details` (`id`, `sapid`, `hostname`, `loopback`, `macaddress`, `created_at`) VALUES
(1, 'sumit new', 'aaaaaa.com', '127.0.0.1', '0123.4567.89AB', '0000-00-00 00:00:00'),
(2, 'gaurang', 'amc.com', '1.3.2.6', '01-23-45-67-89-AB', '0000-00-00 00:00:00'),
(3, 'rakesh', 'bbbb.in', '132.56.40.32', '01:23:45:67:89:AB', '0000-00-00 00:00:00'),
(4, 'sumit', 'prescoipd.com', '176.199.142.136', '01-23-45-67-89-AC', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `router_details`
--
ALTER TABLE `router_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `router_details`
--
ALTER TABLE `router_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
