-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2019 at 08:05 PM
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
  `hp` varchar(20) NOT NULL,
  `cfm` varchar(20) NOT NULL,
  `design` varchar(20) NOT NULL,
  `psi` varchar(20) NOT NULL,
  `series` varchar(30) NOT NULL,
  `cnc` varchar(20) NOT NULL,
  `long_description` varchar(1500) NOT NULL,
  `rpm` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `attachment` text NOT NULL,
  `features` varchar(30) NOT NULL,
  `qty` int(11) NOT NULL,
  `data_one` text NOT NULL,
  `data_two` text NOT NULL,
  `data_three` text NOT NULL,
  `created_by` text NOT NULL,
  `last_edit_by` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
