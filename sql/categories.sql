-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2020 at 06:21 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `application`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(35) NOT NULL,
  `status` varchar(15) NOT NULL,
  `category_clicks` int(11) NOT NULL,
  `created_by` text NOT NULL,
  `last_edit_by` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `status`, `category_clicks`, `created_by`, `last_edit_by`, `date_created`) VALUES
(1, 'HEAVY EQUIPMENT', 'ACTIVE', 17, 'ADMIN|1|Bryant Ricart', '', '2019-11-01 13:54:38'),
(2, 'CHEMICAL', 'DISABLED', 0, 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-01 13:54:43'),
(3, 'SMALL TOOLS', 'ACTIVE', 9, 'ADMIN|1|Bryant Ricart', '', '2019-11-01 13:54:49'),
(4, 'OFFICE SUPPLIES', 'DISABLED', 0, 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-01 13:54:57'),
(5, 'ROBOTS', 'DISABLED', 0, 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-01 13:55:03'),
(6, 'SLOTTERS', 'DISABLED', 0, 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-01 13:55:08'),
(7, 'MISCELLANEOUS', 'ACTIVE', 7, 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-01 13:55:13'),
(8, 'ELECTRONICS', 'ACTIVE', 7, 'ADMIN|1|Bryant Ricart', '', '2019-11-01 13:55:18'),
(9, 'WELDING', 'ACTIVE', 6, 'ADMIN|1|Bryant Ricart', '', '2019-11-01 13:55:22'),
(10, ' AIR COMPRESSORS ', 'ACTIVE', 7, 'ADMIN|1|Bryant Ricart', '', '2019-11-12 14:04:08'),
(11, 'SHOP CRANE', 'ACTIVE', 9, 'ADMIN|1|Bryant Ricart', '', '2019-11-18 10:44:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
