-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 03, 2018 at 07:44 PM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Taxi_Service`
--

-- --------------------------------------------------------

--
-- Table structure for table `cabs`
--

CREATE TABLE `cabs` (
  `id` int(11) NOT NULL,
  `cab_number` varchar(10) NOT NULL,
  `cab_make` varchar(100) NOT NULL,
  `cab_model` varchar(100) NOT NULL,
  `cab_staring_longitude_position` float NOT NULL,
  `cab_starting_latitude_position` float NOT NULL,
  `available` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cabs`
--

INSERT INTO `cabs` (`id`, `cab_number`, `cab_make`, `cab_model`, `cab_staring_longitude_position`, `cab_starting_latitude_position`, `available`) VALUES
(1, 'DEL0555', 'Maruti', 'Alto', 10.5, 44, 1),
(2, 'DEL0111', 'Maruti', 'Swift', 5.25, 22.3, 1),
(3, 'KA1111', 'Hyundai', 'i10', -4, -10.5, 1),
(4, 'KA0767', 'Hyundai', 'Santro Xing', -5.4, 10.25, 1),
(5, 'KA1123', 'Honda', 'City', 5, 5, 1),
(6, 'KA0743', 'Maruti', 'Zen', 10, 15, 1),
(7, 'BR0553', 'Maruti', 'Esteem', 38, 4.5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cab_running_status`
--

CREATE TABLE `cab_running_status` (
  `id` int(11) NOT NULL,
  `cab_number` varchar(10) NOT NULL,
  `cabColor` varchar(10) NOT NULL,
  `user_mobile_num` varchar(10) NOT NULL,
  `customer_pickup_longitude_postion` float DEFAULT NULL,
  `customer_pickup_latitude_position` float DEFAULT NULL,
  `customer_drop_longitude_postion` float DEFAULT NULL,
  `customer_drop_latitude_position` float DEFAULT NULL,
  `pickup_time` datetime DEFAULT NULL,
  `drop_time` datetime DEFAULT NULL,
  `total_distance` float DEFAULT NULL,
  `total_fare` int(11) DEFAULT NULL,
  `available` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) DEFAULT NULL,
  `mobile_num` varchar(10) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cabs`
--
ALTER TABLE `cabs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cab_running_status`
--
ALTER TABLE `cab_running_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`mobile_num`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cabs`
--
ALTER TABLE `cabs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `cab_running_status`
--
ALTER TABLE `cab_running_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
