-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2020 at 06:22 AM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `full_name` varchar(30) NOT NULL,
  `user_type` varchar(30) NOT NULL,
  `account_status` varchar(15) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(60) NOT NULL,
  `ip` text NOT NULL,
  `last_updated` datetime NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `full_name`, `user_type`, `account_status`, `email`, `password`, `ip`, `last_updated`, `date_created`) VALUES
(1, 'Bryant Ricart', 'ADMIN', 'ACTIVE', 'admin@inventory.com', '$2y$12$Jtf45GWp2O.4WnkWmMUGU.yDW8.ajTiJRjvP56mQy3ID3v.3a.g.u', '::1', '0000-00-00 00:00:00', '2019-10-16 22:04:58'),
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
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
