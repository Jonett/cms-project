-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 08.05.2020 klo 05:17
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
-- Database: `cms`
--
CREATE DATABASE IF NOT EXISTS `cms` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cms`;

-- --------------------------------------------------------

--
-- Rakenne taululle `business`
--

CREATE TABLE `business` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `adressData1` varchar(255) NOT NULL,
  `adressData2` varchar(255) NOT NULL,
  `postNumber` int(35) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vedos taulusta `business`
--

INSERT INTO `business` (`id`, `owner_id`, `status`, `name`, `adressData1`, `adressData2`, `postNumber`, `email`, `phone`) VALUES
(1, 1, 1, 'big company', 'big company road 1', 'big company town', 1, 'bigcompany@business.com', '+358 12 345 6789'),
(2, 4, 1, 'medium company', 'medium company road 1', 'medium company town', 4, 'mediumcompany@business.com', '+358 12 345 6789'),
(4, 5, 1, 'small company', 'small company road 1', 'small company town', 5, 'smallcompany@business.com', '+358 12 345 6789'),
(5, 7, 1, 'Opiferum Oy', 'Hämeentie 2', 'Hämeenlinna', 13200, 'asiakaspalvelu@opiferum.fi', '+358 10 229 1919');

-- --------------------------------------------------------

--
-- Rakenne taululle `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `oid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vedos taulusta `clients`
--

INSERT INTO `clients` (`id`, `name`, `oid`) VALUES
(1, 'Asiakas 1', 1),
(2, 'Asiakas 2', 1);

-- --------------------------------------------------------

--
-- Rakenne taululle `registerationcodes`
--

CREATE TABLE `registerationcodes` (
  `id` int(255) NOT NULL,
  `code` int(10) NOT NULL,
  `oid` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vedos taulusta `registerationcodes`
--

INSERT INTO `registerationcodes` (`id`, `code`, `oid`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Rakenne taululle `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vedos taulusta `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'SuperAdmin'),
(2, 'Admin'),
(3, 'Moderator'),
(4, 'User'),
(5, 'Visitor');

-- --------------------------------------------------------

--
-- Rakenne taululle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(18) NOT NULL,
  `password` varchar(255) NOT NULL,
  `oid` int(255) NOT NULL,
  `status` int(1) NOT NULL,
  `fresh` tinyint(1) NOT NULL DEFAULT 1,
  `role` tinyint(1) NOT NULL DEFAULT 5,
  `fullName` varchar(255) NOT NULL,
  `adressData1` varchar(255) NOT NULL,
  `adressData2` varchar(255) NOT NULL,
  `postNumber` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vedos taulusta `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `oid`, `status`, `fresh`, `role`, `fullName`, `adressData1`, `adressData2`, `postNumber`, `phone`) VALUES
(1, 'jonin@testi.fi', '$2y$10$JPSXJQopv8/Nz4fNSYDCwOwX7rrobLEGmwb6YZ6CX0KI27J.Fwvci', 1, 1, 1, 1, 'Joni Hell', 'Mustanlahdenkatu 24', 'Tampere', '33210', '+35845 78704433'),
(4, 'aa@aa.fi', '$2y$10$MpXpQjb06/QOx.nxNPNy8uvGw4muZxIDXWORVvoH0Kk3XQtBF3VFO', 1, 1, 1, 2, 'testi3', '', '', '', ''),
(5, 'aaa@aaa.fi', '$2y$10$wCm.aSWjYI6SsaP87SSNHu8YRHCz3G1/ERiILgdN.9j7rokWadZBe', 1, 1, 1, 3, 'testi4', '', '', '', ''),
(6, 'testi@testi.fi', '', 1, 1, 1, 4, 'testi5', '', '', '', ''),
(7, 'tommi@opiferum.fi', '$2y$10$EiSbgSDBJWIADRIR609ZsOP1dwnhO1dK6xE.JQVabxRYa/cJSMAL2', 5, 1, 1, 1, 'Tommi Hellgren', 'Katuosoitteeni', 'Hämeenlinna', '000000', '+358 123456789'),
(8, 'testi1@tyo.fi', '$2y$10$JPSXJQopv8/Nz4fNSYDCwOwX7rrobLEGmwb6YZ6CX0KI27J.Fwvci', 1, 1, 1, 1, 'testi1', 'Osoite 1', 'Kaupunki 1', '00001', '+35845 11111111'),
(9, 'testi2@tyo.fi', '$2y$10$JPSXJQopv8/Nz4fNSYDCwOwX7rrobLEGmwb6YZ6CX0KI27J.Fwvci', 1, 1, 1, 1, 'testi2', 'Osoite 2', 'Kaupunki 2', '00002', '+35845 22222222');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registerationcodes`
--
ALTER TABLE `registerationcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
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
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registerationcodes`
--
ALTER TABLE `registerationcodes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
