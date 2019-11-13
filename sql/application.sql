-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 13, 2019 at 12:12 AM
-- Server version: 5.6.37
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(35) NOT NULL,
  `status` varchar(15) NOT NULL,
  `category_clicks` int(11) NOT NULL,
  `created_by` text NOT NULL,
  `last_edit_by` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `status`, `category_clicks`, `created_by`, `last_edit_by`, `date_created`) VALUES
(1, 'HEAVY EQUIPMENT', 'ACTIVE', 12, 'ADMIN|1|Bryant Ricart', '', '2019-11-01 13:54:38'),
(2, 'CHEMICAL', 'DISABLED', 0, 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-01 13:54:43'),
(3, 'SMALL TOOLS', 'ACTIVE', 7, 'ADMIN|1|Bryant Ricart', '', '2019-11-01 13:54:49'),
(4, 'OFFICE SUPPLIES', 'DISABLED', 0, 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-01 13:54:57'),
(5, 'ROBOTS', 'DISABLED', 0, 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-01 13:55:03'),
(6, 'SLOTTERS', 'DISABLED', 0, 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-01 13:55:08'),
(7, 'MISCELLANEOUS', 'DISABLED', 0, 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-01 13:55:13'),
(8, 'ELECTRONICS', 'ACTIVE', 6, 'ADMIN|1|Bryant Ricart', '', '2019-11-01 13:55:18'),
(9, 'WELDING', 'ACTIVE', 4, 'ADMIN|1|Bryant Ricart', '', '2019-11-01 13:55:22'),
(10, ' AIR COMPRESSORS ', 'ACTIVE', 5, 'ADMIN|1|Bryant Ricart', '', '2019-11-12 14:04:08');

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

CREATE TABLE IF NOT EXISTS `company_profile` (
  `id` int(11) NOT NULL,
  `company_name` varchar(35) NOT NULL,
  `address` varchar(30) NOT NULL,
  `add_address` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `zip` varchar(8) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(90) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `settings` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_profile`
--

INSERT INTO `company_profile` (`id`, `company_name`, `address`, `add_address`, `city`, `zip`, `phone`, `email`, `fax`, `settings`) VALUES
(1, 'INDUSTRIAL INVENTORY LLC.', '2626 MAIN DR.', 'SUITE 200', 'DETROIT', '48209', '313-203-0000', 'QUOTE@IND-INV-LLC.COM', '313-203-0001', '');

-- --------------------------------------------------------

--
-- Table structure for table `company_settings`
--

CREATE TABLE IF NOT EXISTS `company_settings` (
  `id` int(11) NOT NULL,
  `support_email` varchar(90) NOT NULL,
  `home_page_count` int(11) NOT NULL,
  `catalog_page_count` int(11) NOT NULL,
  `results_per_page` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_settings`
--

INSERT INTO `company_settings` (`id`, `support_email`, `home_page_count`, `catalog_page_count`, `results_per_page`, `date_created`) VALUES
(1, 'support@craigsportal.com', 0, 0, 10, '2019-10-01 03:13:12');

-- --------------------------------------------------------

--
-- Table structure for table `homepage_featured`
--

CREATE TABLE IF NOT EXISTS `homepage_featured` (
  `id` int(11) NOT NULL,
  `item_one` int(11) NOT NULL,
  `item_two` int(11) NOT NULL,
  `item_three` int(11) NOT NULL,
  `data_json` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_inventory`
--

CREATE TABLE IF NOT EXISTS `master_inventory` (
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
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_inventory`
--

INSERT INTO `master_inventory` (`id`, `item_number`, `item_name`, `item_clicks`, `item_status`, `item_image_dir`, `item_video_link`, `item_category`, `item_price`, `manufacturer`, `model`, `year`, `description`, `created_by`, `last_edit_by`, `date_created`) VALUES
(1, 284205, 'ROTARY LIFT', 2, 'ACTIVE', '{"images":["1572380223.JPG"]}', '', 'HEAVY EQUIPMENT', '$4300.00', 'ROTARY', '9000', '2005', '9000 LBS TWO POST CAR LIFT', 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-10-29 16:17:02'),
(2, 959095, 'AUTEL MAXIDAS DS808', 0, 'ACTIVE', '{"images":["1572451163.JPG"]}', '', 'SMALL TOOLS', '$779.99', 'AUTEL', 'DS808', '2001', 'AUTOMOTIVE DIAGNOSTIC TOOL OBD2 SCANNER KEY BI-DIRECTIONAL CONTROL INJECTOR CODING (SAME FUNCTION AS MS906 AND MP808)', 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-10-30 11:59:22'),
(3, 567663, ' WIRE FEED WELDER', 0, 'ACTIVE', '{"images":["1572475270.JPG"]}', '', 'WELDING', '$227.18', 'CENTURY', 'LINCOLN ELECTRIC', '2008', '70 AMP 80GL WIRE FEED FLUX CORE WELDER AND GUN WITH FLUX-CORED WIRE SPOOL, 115V', 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-10-30 18:41:09'),
(4, 298885, 'WIN TV PCI CAPTURE CARD', 1, 'ACTIVE', '{"images":["1572629888.JPG"]}', '', 'ELECTRONICS', '$69.99', 'HAPPAUGE', 'NTSC/NTSC-J 26552', '2005', 'COMPOSITE VIDEO CAPTURE, CABLE TV AND FM RADIO INPUT ', 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-01 13:38:07'),
(5, 283345, 'FOUR POST LIFT', 3, 'ACTIVE', '{"images":["1573575697.JPG"]}', '', 'HEAVY EQUIPMENT', '$10,380', 'ROTARY', 'SM14', '', 'CAPACITY: 14,000 LBS. CARS. SUVS. TRUCKS. VANS. THEY CAN ALL DRIVE RIGHT ONTO THE SM14 AND BE IN THE AIR IN NO TIME. THE GOLD STANDARD OF FOUR POST LIFTS, THE SM14 IS ENGINEERED WITH SINGLE-PIECE, NON-WELDED RUNWAYS TO PROVIDE MAXIMUM LONG-LASTING ST', 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-12 11:21:37'),
(6, 650594, 'STATIONARY ELECTRIC AIR COMPRESSOR', 4, 'ACTIVE', '{"images":["1573585405.JPG"]}', '', ' AIR COMPRESSORS', '$499.99', 'HUSKY', 'C602H', '', 'HUSKY 60 GAL. SINGLE STAGE STATIONARY ELECTRIC AIR COMPRESSOR FEATURES A CAST IRON, OIL LUBRICATED PUMP. 155 PSI MAX PRESSURE ALLOWS THE USER OPTIMUM TOOL PERFORMANCE.', 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-12 14:03:24');

-- --------------------------------------------------------

--
-- Table structure for table `master_inventory_advance`
--

CREATE TABLE IF NOT EXISTS `master_inventory_advance` (
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
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_inventory_advance`
--

INSERT INTO `master_inventory_advance` (`id`, `item_number`, `hp`, `cfm`, `design`, `psi`, `series`, `cnc`, `long_description`, `rpm`, `type`, `features`, `qty`, `data_stream`, `data_json`, `created_by`, `last_edit_by`, `date_created`) VALUES
(1, 298885, '', '', '', '', '', '', '', '', '', '', 1, '', '{"pdf":["1573171387.pdf"]}', 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-07 11:07:16'),
(2, 567663, '', '', '', '', '', '', '', '', '', '', 1, '', '', 'ADMIN|1|Bryant Ricart', '', '2019-11-07 11:07:17'),
(3, 959095, '', '', '', '', '', '', '', '', '', '', 1, '', '', 'ADMIN|1|Bryant Ricart', '', '2019-11-07 11:07:18'),
(4, 284205, '', '', '', '', '', '', '', '', '', '', 1, '', '', 'ADMIN|1|Bryant Ricart', '', '2019-11-07 11:07:19'),
(5, 283345, '', '', '', '', '', '', '', '', '', '', 1, '', '{"pdf":["1573577334.pdf"]}', 'ADMIN|1|Bryant Ricart', 'ADMIN|1|Bryant Ricart', '2019-11-12 11:21:53'),
(6, 650594, '', '', '', '', '', '', '', '', '', '', 1, '', '', 'ADMIN|1|Bryant Ricart', '', '2019-11-12 14:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL,
  `full_name` varchar(30) NOT NULL,
  `user_type` varchar(30) NOT NULL,
  `account_status` varchar(15) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(60) NOT NULL,
  `ip` text NOT NULL,
  `last_updated` datetime NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `full_name`, `user_type`, `account_status`, `email`, `password`, `ip`, `last_updated`, `date_created`) VALUES
(1, 'Bryant Ricart', 'ADMIN', 'ACTIVE', 'admin@inventory.com', '$2y$12$vy4bot1MFnTiqW8ETG8cFuYFmrD9mWFyl/Mj4L3GxiC9TruNO7ffS', '::1', '0000-00-00 00:00:00', '2019-10-16 22:04:58'),
(2, 'Joe Davis', 'STANDARD', 'DISABLED', 'joe.davis@best.com', '$2y$12$66KHPkqmOtXOMU8Nsohyj.Ott5PYCgetMxBXm2.Z.L.s/nb7JyKVK', '::1', '0000-00-00 00:00:00', '2019-10-16 22:07:28'),
(3, 'Jack Parker', 'STANDARD', 'PENDING', 'jackp@best.com', '$2y$12$oKQ5AcIN6rXAmZ8Mk4pRo.ieDUNkaStO/AKjJOKzvM1yRI.o8lbd2', '::1', '0000-00-00 00:00:00', '2019-10-17 12:25:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_settings`
--
ALTER TABLE `company_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homepage_featured`
--
ALTER TABLE `homepage_featured`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_inventory`
--
ALTER TABLE `master_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_inventory_advance`
--
ALTER TABLE `master_inventory_advance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `company_settings`
--
ALTER TABLE `company_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `homepage_featured`
--
ALTER TABLE `homepage_featured`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `master_inventory`
--
ALTER TABLE `master_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `master_inventory_advance`
--
ALTER TABLE `master_inventory_advance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
