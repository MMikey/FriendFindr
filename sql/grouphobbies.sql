-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2021 at 08:33 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `friendfindr`
--

-- --------------------------------------------------------

--
-- Table structure for table `grouphobbies`
--

CREATE TABLE `grouphobbies` (
  `groupid` int(11) NOT NULL,
  `hobbyid` int(11) NOT NULL,
  `grouphobbies_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grouphobbies`
--

INSERT INTO `grouphobbies` (`groupid`, `hobbyid`, `grouphobbies_id`) VALUES
(1, 1, 1),
(2, 5, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grouphobbies`
--
ALTER TABLE `grouphobbies`
  ADD PRIMARY KEY (`grouphobbies_id`),
  ADD KEY `hobbyid_grouphobbies` (`hobbyid`),
  ADD KEY `groupid_grouphobbies` (`groupid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grouphobbies`
--
ALTER TABLE `grouphobbies`
  MODIFY `grouphobbies_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grouphobbies`
--
ALTER TABLE `grouphobbies`
  ADD CONSTRAINT `groupid_grouphobbies` FOREIGN KEY (`groupid`) REFERENCES `groups` (`groupid`),
  ADD CONSTRAINT `hobbyid_grouphobbies` FOREIGN KEY (`hobbyid`) REFERENCES `hobbies` (`hobbyid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
