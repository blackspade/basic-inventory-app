-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2019 at 08:17 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

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
-- Table structure for table `master_inventory_advance`
--

CREATE TABLE `master_inventory_advance` (
  `id` int(11) NOT NULL,
  `item_number` int(6) NOT NULL,
  `hp` varchar(20) NOT NULL,
  `cfm` varchar(20) NOT NULL,
  `design` varchar(20) NOT NULL,
  `psi` varchar(20) NOT NULL,
  `series` varchar(30) NOT NULL,
  `cnc` varchar(20) NOT NULL,
  `long_description` varchar(1500) NOT NULL,
  `rpm` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `features` varchar(30) NOT NULL,
  `qty` int(11) NOT NULL,
  `data_stream` text NOT NULL,
  `data_json` text NOT NULL,
  `created_by` text NOT NULL,
  `last_edit_by` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_inventory_advance`
--

INSERT INTO `master_inventory_advance` (`id`, `item_number`, `hp`, `cfm`, `design`, `psi`, `series`, `cnc`, `long_description`, `rpm`, `type`, `features`, `qty`, `data_stream`, `data_json`, `created_by`, `last_edit_by`, `date_created`) VALUES
(1, 298885, '', '', '', '', '', '', '', '', '', '', 1, '', '{\"pdf\":[\"1573171387.pdf\"]}', 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-07 11:07:16'),
(2, 567663, '', '', '', '', '', '', '', '', '', '', 1, '', '', 'ADMIN|1|Bryant Ricart', '', '2019-11-07 11:07:17'),
(3, 959095, '', '', '', '', '', '', '', '', '', '', 1, '', '', 'ADMIN|1|Bryant Ricart', '', '2019-11-07 11:07:18'),
(4, 284205, '', '', '', '', '', '', '', '', '', '', 1, '', '', 'ADMIN|1|Bryant Ricart', '', '2019-11-07 11:07:19'),
(5, 283345, '', '', '', '', '', '', '', '', '', '', 1, '', '{\"pdf\":[\"1573577334.pdf\"]}', 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-12 11:21:53'),
(6, 650594, '', '', '', '', '', '', '', '', '', '', 1, '', '', 'ADMIN|1|Bryant Ricart', '', '2019-11-12 14:10:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_inventory_advance`
--
ALTER TABLE `master_inventory_advance`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_inventory_advance`
--
ALTER TABLE `master_inventory_advance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
