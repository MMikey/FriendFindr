-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2021 at 05:49 PM
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
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `eventid` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `location` varchar(45) NOT NULL,
  `finish_time` datetime NOT NULL,
  `start_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(2, 5, 2),
(3, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `groupid` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`groupid`, `name`, `description`) VALUES
(1, 'Rockers', 'Fellow rock fan unite! This is a space for everyone to discuss anything rock related. Join the group and chat below!'),
(2, 'Football Fanatics', 'Footballer Fans! Get together with other soccer stans and chat about the latest footy news and goings on'),
(3, 'Hiphopheads', 'HipHopHeads everywhere. Discuss the latest albums, artists and everything in between. Meet your tribe!');

-- --------------------------------------------------------

--
-- Table structure for table `hobbies`
--

CREATE TABLE `hobbies` (
  `hobbyid` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hobbies`
--

INSERT INTO `hobbies` (`hobbyid`, `name`, `description`) VALUES
(1, 'Rock', 'Music: Fans of the rock genre who want to connect with other rockers!'),
(2, 'Pop', 'Music: Fans of pop who want to connect with other poppers!'),
(3, 'HipHop', 'Music: Fans of hip hop who want to connect with other HipHopHeads!'),
(4, 'Electronic Music', 'Music: Fans of electronic music who want to connect with other electronic aficionados! '),
(5, 'Football', 'Sport: Fans of football who want to connect with other football fanatics!'),
(6, 'Rugby', 'Sport: Fans of rugby who want to connect with other rugby rebels!'),
(7, 'Mountaineering', 'Sport: Fans of mountaineering who want to connect with other outdoor adventureres!!'),
(8, 'Tennis', 'Sport: Fans of tennis who want to connect with other racketeers!!'),
(9, 'Film', 'Movies: Fans of cinema who want to connect with other movies buffs!'),
(10, 'Programmers', 'Science: Fans of programmers who want to connect with other techy types!'),
(11, 'Art', 'Art: Fans of the arts who want to connect with other art aficionados!'),
(12, 'Computing', 'aa');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `posted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postid`, `userid`, `groupid`, `posted_at`, `content`) VALUES
(26, 23, 1, '2021-04-16 11:53:30', 'hi everyone i am mikey'),
(27, 28, 1, '2021-04-16 12:26:09', 'Hi mikey i am billy bob'),
(28, 28, 1, '2021-04-16 12:26:52', 'Hi mikey i am billy bob'),
(29, 28, 1, '2021-04-16 12:27:05', 'Hi mikey i am billy bob'),
(32, 28, 1, '2021-04-16 15:04:09', 'hi'),
(35, 28, 2, '2021-04-16 16:25:33', 'hello'),
(36, 28, 2, '2021-04-16 16:29:51', 'test 2'),
(37, 27, 2, '2021-04-16 16:32:50', 'Hello billy bob!');

-- --------------------------------------------------------

--
-- Table structure for table `profilepictures`
--

CREATE TABLE `profilepictures` (
  `profilepictureid` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profilepictures`
--

INSERT INTO `profilepictures` (`profilepictureid`, `name`, `userid`) VALUES
(0, 0, 23);

-- --------------------------------------------------------

--
-- Table structure for table `userevent`
--

CREATE TABLE `userevent` (
  `userid` int(11) NOT NULL,
  `eventid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usergroups`
--

CREATE TABLE `usergroups` (
  `userid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `usergroups_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usergroups`
--

INSERT INTO `usergroups` (`userid`, `groupid`, `usergroups_id`) VALUES
(26, 2, 1),
(28, 1, 38),
(28, 3, 39),
(23, 2, 44),
(28, 2, 45),
(27, 2, 47),
(23, 1, 48);

-- --------------------------------------------------------

--
-- Table structure for table `userhobbies`
--

CREATE TABLE `userhobbies` (
  `userid` int(11) NOT NULL,
  `hobbyid` int(11) NOT NULL,
  `userhobbiesId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userhobbies`
--

INSERT INTO `userhobbies` (`userid`, `hobbyid`, `userhobbiesId`) VALUES
(22, 1, 21),
(23, 2, 22),
(23, 5, 24),
(24, 1, 25),
(25, 4, 26),
(26, 1, 27),
(26, 5, 28),
(26, 7, 29),
(23, 3, 30),
(23, 4, 31),
(27, 8, 32),
(28, 1, 33),
(28, 2, 34),
(28, 3, 35),
(28, 4, 36),
(28, 5, 37),
(28, 6, 38),
(28, 7, 39),
(28, 8, 40),
(28, 9, 41),
(28, 10, 42),
(28, 11, 43),
(28, 12, 44),
(27, 1, 45),
(27, 2, 46),
(27, 3, 47),
(27, 4, 48),
(27, 5, 49),
(27, 6, 50),
(27, 7, 51),
(27, 9, 52),
(27, 10, 53),
(27, 11, 54),
(27, 12, 55);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `location` varchar(45) DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `DateOfBirth` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `email`, `password`, `location`, `bio`, `created_at`, `DateOfBirth`) VALUES
(14, '', '', '$2y$10$xqN8etw6TXqXdg7z0D6ghOltjewc7XxUboyIhiW.kbaaBFKa9nGWu', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00'),
(21, 'kevin', '', '$2y$10$y5cjoQqpl4H0OsH9ge40XOkqvK6R9p0qRCXfF2haBBp6EvJ04iEjy', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00'),
(22, 'kyle', '33', '$2y$10$SCNVrPw66Gr7K1LcrcSN.er7gV.y.plNVc1ZQv965V3hqKgWMosI.', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00'),
(23, 'mikey', 'michael@hotmail.com', '$2y$10$APY5QAdEwT//JR0TqJZwvellTaVzxymbPQP7RpThagT5d.zp7gwpi', 'birmingham', 'my name is mikey', '2021-04-01 15:04:30', '0000-00-00'),
(24, 'ChessmanMagee', '1234', '$2y$10$loftTNKtBcYXZnr4263gTeD.UNErgg62cEg0NRJww4JyM289ZPDb6', NULL, NULL, '2021-04-08 19:59:08', '0000-00-00'),
(25, 'asdf', '1234', '$2y$10$WJ3Zyf9/NroKWfPNUslmUOIWaLX3esk3JZwA7xwx3da4.igN4YapC', NULL, NULL, '2021-04-08 20:06:23', '0000-00-00'),
(26, 'kev', '18051646@stu.mmu.ac.uk', '$2y$10$kY0kScri2xOCJG91OVGD7OPM5n3bHTT64EeGSMPLHsENGplSo6uba', 'manchester', 'my name is kev and i like cheese', '2021-04-08 21:17:10', '1997-04-08'),
(27, 'Mikey1', '1', '$2y$10$nSzD88KrTMSJ09tMbjyfPe1.5ZyTjOchHkkvCYq7CLLKPzi3yJdW.', 'bham', 'sad', '2021-04-15 16:55:01', '0000-00-00'),
(28, 'Billy bob', '1', '$2y$10$8wZpyE3s1c4HENHTBury3ukynSYIZuNki0eauF/ym3NORVC/E1CCS', 'bham', 'My name is bob and i\'m a fan of most things', '2021-04-16 12:20:16', '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`eventid`),
  ADD UNIQUE KEY `eventid_UNIQUE` (`eventid`);

--
-- Indexes for table `grouphobbies`
--
ALTER TABLE `grouphobbies`
  ADD PRIMARY KEY (`grouphobbies_id`),
  ADD KEY `hobbyid_grouphobbies` (`hobbyid`),
  ADD KEY `groupid_grouphobbies` (`groupid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`groupid`),
  ADD UNIQUE KEY `groupid_UNIQUE` (`groupid`);

--
-- Indexes for table `hobbies`
--
ALTER TABLE `hobbies`
  ADD PRIMARY KEY (`hobbyid`),
  ADD UNIQUE KEY `hobbyid_UNIQUE` (`hobbyid`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postid`),
  ADD UNIQUE KEY `postid_UNIQUE` (`postid`),
  ADD KEY `userid_posts_idx` (`userid`),
  ADD KEY `groupid_posts_idx` (`groupid`);

--
-- Indexes for table `profilepictures`
--
ALTER TABLE `profilepictures`
  ADD PRIMARY KEY (`profilepictureid`),
  ADD KEY `profilepicture_userid` (`userid`);

--
-- Indexes for table `userevent`
--
ALTER TABLE `userevent`
  ADD KEY `userid_userevent_idx` (`userid`),
  ADD KEY `eventid_userevent_idx` (`eventid`);

--
-- Indexes for table `usergroups`
--
ALTER TABLE `usergroups`
  ADD PRIMARY KEY (`usergroups_id`),
  ADD KEY `userid_idx` (`userid`),
  ADD KEY `groupid_idx` (`groupid`);

--
-- Indexes for table `userhobbies`
--
ALTER TABLE `userhobbies`
  ADD PRIMARY KEY (`userhobbiesId`),
  ADD KEY `userid_idx` (`userid`),
  ADD KEY `hobbyid_idx` (`hobbyid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `userid_UNIQUE` (`userid`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `eventid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grouphobbies`
--
ALTER TABLE `grouphobbies`
  MODIFY `grouphobbies_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hobbies`
--
ALTER TABLE `hobbies`
  MODIFY `hobbyid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `usergroups`
--
ALTER TABLE `usergroups`
  MODIFY `usergroups_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `userhobbies`
--
ALTER TABLE `userhobbies`
  MODIFY `userhobbiesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grouphobbies`
--
ALTER TABLE `grouphobbies`
  ADD CONSTRAINT `groupid_grouphobbies` FOREIGN KEY (`groupid`) REFERENCES `groups` (`groupid`),
  ADD CONSTRAINT `hobbyid_grouphobbies` FOREIGN KEY (`hobbyid`) REFERENCES `hobbies` (`hobbyid`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `groupid_posts` FOREIGN KEY (`groupid`) REFERENCES `groups` (`groupid`),
  ADD CONSTRAINT `userid_posts` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `profilepictures`
--
ALTER TABLE `profilepictures`
  ADD CONSTRAINT `profilepicture_userid` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `userevent`
--
ALTER TABLE `userevent`
  ADD CONSTRAINT `eventid_userevent` FOREIGN KEY (`eventid`) REFERENCES `events` (`eventid`),
  ADD CONSTRAINT `userid_userevent` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `usergroups`
--
ALTER TABLE `usergroups`
  ADD CONSTRAINT `groupid` FOREIGN KEY (`groupid`) REFERENCES `groups` (`groupid`),
  ADD CONSTRAINT `userid_usergroups` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `userhobbies`
--
ALTER TABLE `userhobbies`
  ADD CONSTRAINT `hobbyid_userhobbies` FOREIGN KEY (`hobbyid`) REFERENCES `hobbies` (`hobbyid`),
  ADD CONSTRAINT `userid_userhobbies` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
