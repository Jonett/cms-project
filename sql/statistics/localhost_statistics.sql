-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 08.05.2020 klo 05:18
-- Palvelimen versio: 10.4.11-MariaDB
-- PHP Version: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `statistics`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `onlinecount`
--

CREATE TABLE `onlinecount` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `count` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vedos taulusta `onlinecount`
--

INSERT INTO `onlinecount` (`id`, `timestamp`, `count`, `uid`) VALUES
(1, '2020-05-06 03:00:00', 0, 1),
(2, '2020-05-06 03:00:00', 1, 1),
(3, '2020-05-06 03:05:02', 0, 1),
(4, '2020-05-06 03:00:00', 1, 1),
(5, '2020-05-06 06:05:28', 0, 1),
(6, '2020-05-06 06:00:00', 1, 1),
(7, '2020-05-06 06:05:37', 0, 1),
(8, '2020-05-06 06:00:00', 1, 1),
(9, '2020-05-06 06:05:08', 0, 1),
(10, '2020-05-06 06:00:00', 1, 1),
(11, '2020-05-06 06:05:32', 0, 1),
(12, '2020-05-06 06:00:00', 1, 1),
(13, '2020-05-06 06:05:48', 0, 1),
(14, '2020-05-06 06:00:00', 1, 1),
(15, '2020-05-06 08:05:32', 0, 1),
(16, '2020-05-06 09:00:00', 1, 1),
(17, '2020-05-06 09:05:07', 0, 1),
(18, '2020-05-06 09:00:00', 1, 7),
(19, '2020-05-06 09:05:02', 0, 7),
(20, '2020-05-06 09:00:00', 1, 7),
(21, '2020-05-06 09:05:27', 0, 7),
(22, '2020-05-06 09:00:00', 1, 7),
(23, '2020-05-06 09:05:08', 0, 7),
(24, '2020-05-06 09:00:00', 1, 7),
(25, '2020-05-06 09:00:00', 2, 1),
(26, '2020-05-06 09:05:43', 1, 1),
(27, '2020-05-06 09:00:00', 2, 1),
(28, '2020-05-06 10:05:33', 1, 1),
(29, '2020-05-06 10:00:00', 2, 1),
(30, '2020-05-08 01:00:00', 3, 1);

-- --------------------------------------------------------

--
-- Rakenne taululle `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `action` varchar(255) NOT NULL,
  `changes` text NOT NULL,
  `aid` int(11) NOT NULL COMMENT 'actionId',
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `onlinecount`
--
ALTER TABLE `onlinecount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `onlinecount`
--
ALTER TABLE `onlinecount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
