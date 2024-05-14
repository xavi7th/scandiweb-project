-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2023 at 11:18 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scandiweb-junior-developer-test`
--

-- --------------------------------------------------------

--
-- Table structure for table `sample_products`
--

CREATE TABLE `sample_products` (
  `id` int(11) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `type` varchar(50) NOT NULL,
  `PHPSESSID` varchar(200) DEFAULT NULL,
  `extra` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sample_products`
--

INSERT INTO `sample_products` (`id`, `sku`, `name`, `price`, `type`, `PHPSESSID`, `extra`) VALUES
(114, 'aaaad', 'Okpakaw 22', 200, 'dvd', NULL, '{\"measurement\":{\"size\":\"10 MB\"}}'),
(115, 'aaa11', 'Okpakaw 22', 200, 'book', NULL, '{\"measurement\":{\"weight\":\"700 KG\"}}'),
(116, 'aaa2', 'Okpakaw 22', 123, 'furniture', NULL, '{\"measurement\":{\"dimension\":\"10x20x30\"}}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sample_products`
--
ALTER TABLE `sample_products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sample_products`
--
ALTER TABLE `sample_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
