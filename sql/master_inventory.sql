-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2019 at 12:00 AM
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
-- Table structure for table `master_inventory`
--

CREATE TABLE `master_inventory` (
  `id` int(11) NOT NULL,
  `item_number` int(6) NOT NULL,
  `item_name` varchar(90) NOT NULL,
  `item_clicks` int(11) NOT NULL,
  `item_status` varchar(15) NOT NULL,
  `item_image_dir` text NOT NULL,
  `item_video_link` text NOT NULL,
  `item_category` varchar(35) NOT NULL,
  `item_price` varchar(15) NOT NULL,
  `manufacturer` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `year` varchar(10) NOT NULL,
  `description` varchar(250) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `last_edit_by` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_inventory`
--

INSERT INTO `master_inventory` (`id`, `item_number`, `item_name`, `item_clicks`, `item_status`, `item_image_dir`, `item_video_link`, `item_category`, `item_price`, `manufacturer`, `model`, `year`, `description`, `created_by`, `last_edit_by`, `date_created`) VALUES
(1, 284205, 'ROTARY LIFT', 0, 'NEW', '{\"images\":[\"1572380223.JPG\"]}', '', 'HEAVY EQUIPMENT', '$4300', 'ROTARY', '9000', '2005', '9000 LBS TWO POST CAR LIFT', 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-10-29 16:17:02'),
(2, 959095, 'AUTEL MAXIDAS DS808', 0, 'NEW', '{\"images\":[\"1572451163.JPG\"]}', '', 'SMALL TOOLS', '$779', 'AUTEL', 'DS808', '2001', 'AUTOMOTIVE DIAGNOSTIC TOOL OBD2 SCANNER KEY BI-DIRECTIONAL CONTROL INJECTOR CODING (SAME FUNCTION AS MS906 AND MP808)', 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-10-30 11:59:22'),
(3, 567663, ' WIRE FEED WELDER', 0, 'NEW', '{\"images\":[\"1572475270.JPG\"]}', '', 'WELDING', '$227.18', 'CENTURY', 'LINCOLN ELECTRIC', '2008', '70 AMP 80GL WIRE FEED FLUX CORE WELDER AND GUN WITH FLUX-CORED WIRE SPOOL, 115V', 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-10-30 18:41:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_inventory`
--
ALTER TABLE `master_inventory`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_inventory`
--
ALTER TABLE `master_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
