-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 13, 2019 at 12:13 AM
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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
