-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2021 at 11:36 AM
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

-- Users
    -- Table structure for table `users`
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

    -- Indexes for table `users`
    ALTER TABLE `users`
    ADD PRIMARY KEY (`userid`),
    ADD UNIQUE KEY `userid_UNIQUE` (`userid`),
    ADD UNIQUE KEY `username_UNIQUE` (`username`);

    -- AUTO_INCREMENT for table `users`
    ALTER TABLE `users` MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

    -- Dumping data for table `users`
    INSERT INTO `users` (`userid`, `username`, `email`, `password`, `location`, `bio`, `created_at`, `DateOfBirth`) VALUES
    (14, '', '', '$2y$10$xqN8etw6TXqXdg7z0D6ghOltjewc7XxUboyIhiW.kbaaBFKa9nGWu', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00'),
    (21, 'kevin', '', '$2y$10$y5cjoQqpl4H0OsH9ge40XOkqvK6R9p0qRCXfF2haBBp6EvJ04iEjy', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00'),
    (22, 'kyle', '33', '$2y$10$SCNVrPw66Gr7K1LcrcSN.er7gV.y.plNVc1ZQv965V3hqKgWMosI.', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00');

-- Hobbies
    -- Table structure for table `hobbies`
    CREATE TABLE `hobbies` (
       `hobbyid` int(11) NOT NULL,
       `name` varchar(45) NOT NULL,
       `description` varchar(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    -- Indexes for table `hobbies`
    ALTER TABLE `hobbies`
    ADD PRIMARY KEY (`hobbyid`),
    ADD UNIQUE KEY `hobbyid_UNIQUE` (`hobbyid`);

    -- AUTO_INCREMENT for table `hobbies`
    ALTER TABLE `hobbies` MODIFY `hobbyid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

    -- Dumping data for table `hobbies`
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

-- User hobbies
    -- Table structure for table `userhobbies`
    CREATE TABLE `userhobbies` (
       `userid` int(11) NOT NULL,
       `hobbyid` int(11) NOT NULL,
       `userhobbiesId` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

     CHARSET=utf8;

    -- Indexes for table `userhobbies`
    ALTER TABLE `userhobbies`
    ADD PRIMARY KEY (`userhobbiesId`),
    ADD KEY `userid_idx` (`userid`),
    ADD KEY `hobbyid_idx` (`hobbyid`);

    -- Constraints for table `userhobbies`
    ALTER TABLE `userhobbies`
    ADD CONSTRAINT `hobbyid_userhobbies` FOREIGN KEY (`hobbyid`) REFERENCES `hobbies` (`hobbyid`),
    ADD CONSTRAINT `userid_userhobbies` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);
    COMMIT;

    -- AUTO_INCREMENT for table `userhobbies`
    ALTER TABLE `userhobbies` MODIFY `userhobbiesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

    -- Dumping data for table `userhobbies`
    INSERT INTO `userhobbies` (`userid`, `hobbyid`, `userhobbiesId`) VALUES (22, 1, 21);

-- Groups
    -- Table structure for table `groups`
    CREATE TABLE `groups` (
        `groupid` int(11) NOT NULL,
        `name` varchar(45) NOT NULL,
        `description` varchar(255) NOT NULL,
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    -- Indexes for table `groups`
    ALTER TABLE `groups`
    ADD PRIMARY KEY (`groupid`),
    ADD UNIQUE KEY `groupid_UNIQUE` (`groupid`);

    -- AUTO_INCREMENT for table `groups`
    ALTER TABLE `groups` MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT;

-- User Groups
    -- Table structure for table `usergroups`
    CREATE TABLE `usergroups` (
        `userid` int(11) NOT NULL,
        `groupid` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    -- Indexes for table `usergroups`
    ALTER TABLE `usergroups`
    ADD KEY `userid_idx` (`userid`),
    ADD KEY `groupid_idx` (`groupid`);

    -- Constraints for table `usergroups`
    ALTER TABLE `usergroups`
    ADD CONSTRAINT `groupid` FOREIGN KEY (`groupid`) REFERENCES `groups` (`groupid`),
    ADD CONSTRAINT `userid_usergroups` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

-- Posts
    -- Table structure for table `posts`
    CREATE TABLE `posts` (
        `postid` int(11) NOT NULL,
        `userid` int(11) NOT NULL,
        `groupid` int(11) NOT NULL,
        `posted_at` datetime NOT NULL DEFAULT current_timestamp(),
        `content` varchar(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    -- Indexes for table `posts`
    ALTER TABLE `posts`
    ADD PRIMARY KEY (`postid`),
    ADD UNIQUE KEY `postid_UNIQUE` (`postid`),
    ADD KEY `userid_posts_idx` (`userid`),
    ADD KEY `groupid_posts_idx` (`groupid`);

    -- Constraints for table `posts`
    ALTER TABLE `posts`
    ADD CONSTRAINT `groupid_posts` FOREIGN KEY (`groupid`) REFERENCES `groups` (`groupid`),
    ADD CONSTRAINT `userid_posts` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

    -- AUTO_INCREMENT for table `posts`
    ALTER TABLE `posts` MODIFY `postid` int(11) NOT NULL AUTO_INCREMENT;

-- Events
    -- Table structure for table `events`
    CREATE TABLE `events` (
        `eventid` int(11) NOT NULL,
        `name` varchar(45) NOT NULL,
        `description` varchar(255) NOT NULL,
        `location` varchar(45) NOT NULL,
        `finish_time` datetime NOT NULL,
        `start_time` datetime NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    -- Indexes for table `events`
    ALTER TABLE `events`
    ADD PRIMARY KEY (`eventid`),
    ADD UNIQUE KEY `eventid_UNIQUE` (`eventid`);

    -- AUTO_INCREMENT for table `events`
    ALTER TABLE `events` MODIFY `eventid` int(11) NOT NULL AUTO_INCREMENT;

-- User Event
    -- Table structure for table `userevent`
    CREATE TABLE `userevent` (
        `userid` int(11) NOT NULL,
        `eventid` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    -- Indexes for table `userevent`
    ALTER TABLE `userevent`
    ADD KEY `userid_userevent_idx` (`userid`),
    ADD KEY `eventid_userevent_idx` (`eventid`);

    -- Constraints for table `userevent`
    ALTER TABLE `userevent`
    ADD CONSTRAINT `eventid_userevent` FOREIGN KEY (`eventid`) REFERENCES `events` (`eventid`),
    ADD CONSTRAINT `userid_userevent` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);
