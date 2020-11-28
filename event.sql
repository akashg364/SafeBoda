-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2020 at 04:57 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `eventName` varchar(50) NOT NULL,
  `radius` double NOT NULL COMMENT 'in km',
  `event_lat` varchar(50) NOT NULL,
  `event_long` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `createdOn` datetime NOT NULL,
  `updatedOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `eventName`, `radius`, `event_lat`, `event_long`, `status`, `createdOn`, `updatedOn`) VALUES
(1, 'Event 1', 50, '19.076090', '72.877426', 1, '2020-11-28 17:22:37', '0000-00-00 00:00:00'),
(2, 'Event 2', 50, '', '', 1, '2020-11-28 17:22:37', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `promocode`
--

CREATE TABLE `promocode` (
  `id` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `code` varchar(25) NOT NULL,
  `amount` float NOT NULL,
  `source` varchar(50) NOT NULL,
  `destination` varchar(50) NOT NULL,
  `radius` double NOT NULL COMMENT 'in kms',
  `expiryDate` date NOT NULL,
  `status` int(11) NOT NULL COMMENT '1-active, 2-in-active',
  `createdOn` datetime NOT NULL,
  `updatedOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promocode`
--

INSERT INTO `promocode` (`id`, `eventId`, `code`, `amount`, `source`, `destination`, `radius`, `expiryDate`, `status`, `createdOn`, `updatedOn`) VALUES
(1, 1, 'HQOfnAyYl3RcexMv', 20, '0', '0', 10, '2020-11-30', 1, '2020-11-28 13:50:24', '2020-11-28 16:51:19'),
(2, 1, 'qcoeWIyMbul98vhx', 100, '0', '0', 0, '2020-12-28', 1, '2020-11-28 13:56:05', '2020-11-28 14:56:20'),
(3, 1, 'cwLF7dyYPVne0QCa', 100, '0', '0', 0, '2020-12-28', 1, '2020-11-28 13:56:07', '2020-11-28 14:56:20'),
(4, 1, 'HYRABm6JugWPC3tk', 100, '0', '0', 0, '2020-12-28', 1, '2020-11-28 13:56:08', '2020-11-28 14:56:20'),
(5, 1, '2gl34ThcOFmHewZX', 100, '0', '0', 0, '2020-12-28', 1, '2020-11-28 14:03:04', '2020-11-28 14:56:20'),
(6, 1, 'gNY92wUD', 0, '0', '0', 0, '2020-12-28', 1, '2020-11-28 14:41:04', '2020-11-28 14:56:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `promoCodeId` varchar(50) NOT NULL,
  `fullName` varchar(50) NOT NULL,
  `user_lat` varchar(50) NOT NULL,
  `user_long` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `createdOn` datetime NOT NULL,
  `updatedOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `eventId`, `promoCodeId`, `fullName`, `user_lat`, `user_long`, `status`, `createdOn`, `updatedOn`) VALUES
(1, 1, 'HQOfnAyYl3RcexMv', 'test', '18.9750', '72.8295', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promocode`
--
ALTER TABLE `promocode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promocode`
--
ALTER TABLE `promocode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
