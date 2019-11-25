-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2019 at 07:16 PM
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
-- Table structure for table `company_profile`
--

CREATE TABLE `company_profile` (
  `id` int(11) NOT NULL,
  `company_name` varchar(35) NOT NULL,
  `address` varchar(30) NOT NULL,
  `add_address` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `zip` varchar(8) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(90) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_profile`
--

INSERT INTO `company_profile` (`id`, `company_name`, `address`, `add_address`, `city`, `zip`, `phone`, `email`, `fax`, `about`) VALUES
(1, 'DEMO INVENTORY APP', '2626 MAIN DR.', 'SUITE 200', 'DETROIT', '48209', '313-203-0000', 'QUOTE@IND-INV-LLC.COM', '313-203-0001', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
