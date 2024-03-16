-- CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
CREATE USER IF NOT EXISTS bidfusionUser@localhost IDENTIFIED BY 'B!dFus!on123';

DROP DATABASE IF EXISTS `bid_fusion`; 
SET default_storage_engine=InnoDB;

CREATE DATABASE IF NOT EXISTS bid_fusion
    DEFAULT CHARACTER SET utf8mb4 
    DEFAULT COLLATE utf8mb4_unicode_ci;
USE bid_fusion;

GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'bidfusionUser'@'localhost';
GRANT ALL PRIVILEGES ON `bidfusionuser`.* TO 'bidfusionUser'@'localhost';
GRANT ALL PRIVILEGES ON `bid_fusion`.* TO 'bidfusionUser'@'localhost';
FLUSH PRIVILEGES;

-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 14, 2018 at 05:11 AM
-- Server version: 5.6.38
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `bid_fusion
--

-- --------------------------------------------------------

--
-- Table structure for table `AdminUser`
--

-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 15, 2018 at 03:00 AM
-- Server version: 5.6.38
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `bid_fusion`
--

-- --------------------------------------------------------

--
-- Table structure for table `AdminUser`
--

CREATE TABLE `AdminUser` (
  `adminID` int(16) UNSIGNED NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `AdminUser`
--

INSERT INTO `AdminUser` (`adminID`, `user_name`, `position`) VALUES
(1, 'admin1', 'Technical Support'),
(2, 'admin2', 'Chief Techy');

-- --------------------------------------------------------

--
-- Table structure for table `Bid`
--

CREATE TABLE `Bid` (
  `bidID` int(16) UNSIGNED NOT NULL,
  `bid_date_time` datetime NOT NULL,
  `bid_amount` decimal(12,2) NOT NULL,
  `itemID` int(16) UNSIGNED NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Bid`
--

INSERT INTO `Bid` (`bidID`, `bid_date_time`, `bid_amount`, `itemID`, `user_name`) VALUES
(1, '2018-03-30 14:53:00', '50.00', 1, 'user4'),
(2, '2018-03-30 16:45:00', '55.00', 1, 'user5'),
(3, '2018-03-30 19:28:00', '75.00', 1, 'user4'),
(4, '2018-03-31 10:00:00', '85.00', 1, 'user5'),
(5, '2018-04-01 13:55:00', '80.00', 2, 'user6'),
(6, '2018-04-04 08:37:00', '1500.00', 3, 'user1'),
(7, '2018-04-04 09:15:00', '1501.00', 3, 'user3'),
(8, '2018-04-04 12:27:00', '1795.00', 3, 'user1'),
(9, '2018-04-08 20:20:00', '20.00', 7, 'user4'),
(10, '2018-04-09 21:15:00', '25.00', 7, 'user2');

-- --------------------------------------------------------

--
-- Table structure for table `Item`
--

CREATE TABLE `Item` (
  `itemID` int(16) UNSIGNED NOT NULL,
  `date_time` datetime NOT NULL,
  `item_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_bid` decimal(12,2) NOT NULL,
  `reserve` decimal(12,2) NOT NULL,
  `ends_in` datetime NOT NULL,
  `get_it_now` decimal(12,2) NOT NULL,
  `returnable` tinyint(1) NOT NULL,
  `category` enum('Art','Books','Electronics','Home & Garden','Sporting Goods','Toys','Other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_condition` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Item`
--

INSERT INTO `Item` (`itemID`, `date_time`, `item_name`, `description`, `start_bid`, `reserve`, `ends_in`, `get_it_now`, `returnable`, `category`, `user_name`, `item_condition`) VALUES
(1, '2018-03-28 12:22:36', 'Garmin GPS', 'This is a great GPS.', '50.00', '70.00', '2018-03-31 12:22:36', '99.00', 0, 'Electronics', 'user1', 3),
(2, '2018-03-31 14:14:21', 'Canon Powershot', 'Point and shoot!', '40.00', '60.00', '2018-04-01 14:14:21', '80.00', 0, 'Electronics', 'user1', 2),
(3, '2018-04-02 09:19:48', 'Nikon D3', 'New and in box!', '1.00', '1800.00', '2018-04-05 09:19:48', '2000.00', 0, 'Electronics', 'user2', 4),
(4, '2018-03-29 15:33:48', 'Danish Art Book', 'Delicious Danish Art', '10.00', '10.00', '2018-04-05 15:33:48', '15.00', 1, 'Art', 'user3', 3),
(5, '2018-04-02 16:48:48', 'SQL in 10 Minutes', 'Learn SQL really fast!', '5.00', '10.00', '2018-04-05 16:48:48', '12.00', 0, 'Books', 'admin1', 1),
(6, '2018-04-01 10:01:48', 'SQL in 8 Minutes', 'Learn SQL even faster!', '5.00', '8.00', '2018-04-08 10:01:48', '10.00', 0, 'Books', 'admin2', 2),
(7, '2018-04-02 22:09:48', 'Pull-up Bar', 'Works on any door frame.', '20.00', '25.00', '2018-04-09 22:09:48', '40.00', 1, 'Sporting Goods', 'user6', 4),
(8, '2018-04-10 17:46:37', 'Garmin GPS', 'If you just want basic, frills-free navigation.', '25.00', '50.00', '2018-04-17 17:46:37', '75.00', 0, 'Electronics', 'admin2', 1),
(9, '2018-04-10 17:48:36', 'MacBook Pro', 'A keyboard refined for an even better hands-on experience.', '1.00', '1500.00', '2018-04-17 17:48:36', '0.00', 0, 'Electronics', 'user4', 3),
(10, '2018-04-10 17:50:16', 'Microsoft Surface', 'CPU: 2.4GHz Intel Core i5-6300U (dual-core, 3MB cache, up to 3GHz with Turbo Boost.', '500.00', '750.00', '2018-04-17 17:50:16', '899.00', 0, 'Electronics', 'user5', 2),
(33, '2018-04-14 08:24:24', 'iwatch 3', 'New in the box', '100.00', '200.00', '2018-04-21 08:24:24', '300.00', 1, 'Electronics', 'user1', 4);

-- --------------------------------------------------------

--
-- Table structure for table `Rating`
--

CREATE TABLE `Rating` (
  `ratingID` int(16) UNSIGNED NOT NULL,
  `rating_date_time` datetime NOT NULL,
  `stars` int(11) NOT NULL,
  `comments` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `itemID` int(16) UNSIGNED NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Rating`
--

INSERT INTO `Rating` (`ratingID`, `rating_date_time`, `stars`, `comments`, `itemID`, `user_name`) VALUES
(1, '2018-03-30 17:00:00', 5, 'Great GPS!', 1, 'user2'),
(2, '2018-03-30 18:00:00', 2, 'Not so great GPS!', 1, 'user3'),
(3, '2018-03-30 19:00:00', 4, 'A favorite of mine.', 1, 'user4'),
(4, '2018-04-01 16:46:00', 4, 'Go for the Italian stuff instead.', 4, 'user1'),
(5, '2018-04-06 23:56:00', 1, 'Not recommended.', 6, 'admin1'),
(6, '2018-04-07 13:32:00', 3, 'This book is okay.', 6, 'user1'),
(7, '2018-04-07 14:44:00', 5, 'I learned SQL in 8 minutes!', 6, 'user2');

-- --------------------------------------------------------

--
-- Stand-in structure for view `rt`
-- (See below for the actual view)
--
CREATE TABLE `rt` (
`user_name` varchar(50)
,`rated` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `sold1`
-- (See below for the actual view)
--
CREATE TABLE `sold1` (
`itemID` int(16) unsigned
,`user_name` varchar(50)
,`sold_for` decimal(12,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `sold2`
-- (See below for the actual view)
--
CREATE TABLE `sold2` (
`itemID` int(16) unsigned
,`user_name` varchar(50)
,`sold_for` decimal(12,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `sold3`
-- (See below for the actual view)
--
CREATE TABLE `sold3` (
`user_name` varchar(50)
,`sold` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ur1`
-- (See below for the actual view)
--
CREATE TABLE `ur1` (
`user_name` varchar(50)
,`listed` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ur2`
-- (See below for the actual view)
--
CREATE TABLE `ur2` (
`user_name` varchar(50)
,`listed` bigint(21)
,`purchased` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ur3`
-- (See below for the actual view)
--
CREATE TABLE `ur3` (
`user_name` varchar(50)
,`listed` bigint(21)
,`sold` bigint(21)
,`purchased` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `userID` int(16) NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userID`, `user_name`, `first_name`, `last_name`, `password`, `created_at`) VALUES
(1, 'user1', 'Danite', 'Kelor', 'pass1', '2020-08-29 21:36:09'),
(2, 'user2', 'Dodra', 'Kiney', 'pass2', '2020-08-29 21:36:46'),
(3, 'user3', 'Peran', 'Bishop', 'pass3', '2020-08-29 21:37:45'),
(4, 'user4', 'Randy', 'Roran', 'pass4', '2020-08-29 21:37:59'),
(5, 'user5', 'Ashod', 'Iankel', 'pass5', '2020-08-29 21:38:26'),
(6, 'user6', 'Cany', 'Achant', 'pass6', '2020-08-29 21:38:38'),
(7, 'admin1', 'Riley', 'Fuiss', 'opensesame', '2020-08-29 21:38:49'),
(8, 'admin2', 'Tonnis', 'Kinser', 'opensesayou', '2020-08-29 21:39:01'),
(9, 'user99', 'another', 'name', 'pass99', '2020-08-29 21:39:11'),
(10, 'user10', 'User', 'Ten', 'pass10', '2020-08-29 21:39:33'),
(11, 'user11', 'User', 'Eleven', '0102812fbd5f73aa18aa0bae2cd8f79f', '2020-08-29 21:39:44'),
(16, 'user12', 'User', 'Twelve', 'pass12', '2024-03-15 00:52:03');

-- --------------------------------------------------------

--
-- Structure for view `rt`
--
DROP TABLE IF EXISTS `rt`;

CREATE ALGORITHM=UNDEFINED DEFINER=`bidfusionUser`@`localhost` SQL SECURITY DEFINER VIEW `rt`  AS  select `rating`.`user_name` AS `user_name`,count(`rating`.`user_name`) AS `rated` from `rating` group by `rating`.`user_name` ;

-- --------------------------------------------------------

--
-- Structure for view `sold1`
--
DROP TABLE IF EXISTS `sold1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`bidfusionUser`@`localhost` SQL SECURITY DEFINER VIEW `sold1`  AS  select `bid`.`itemID` AS `itemID`,`bid`.`user_name` AS `user_name`,max(`bid`.`bid_amount`) AS `sold_for` from `bid` group by `bid`.`itemID` ;

-- --------------------------------------------------------

--
-- Structure for view `sold2`
--
DROP TABLE IF EXISTS `sold2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`bidfusionUser`@`localhost` SQL SECURITY DEFINER VIEW `sold2`  AS  select `sold1`.`itemID` AS `itemID`,`sold1`.`user_name` AS `user_name`,`sold1`.`sold_for` AS `sold_for` from (`sold1` join `item`) where ((`sold1`.`itemID` = `item`.`itemID`) and (`sold1`.`sold_for` >= `item`.`reserve`)) ;

-- --------------------------------------------------------

--
-- Structure for view `sold3`
--
DROP TABLE IF EXISTS `sold3`;

CREATE ALGORITHM=UNDEFINED DEFINER=`bidfusionUser`@`localhost` SQL SECURITY DEFINER VIEW `sold3`  AS  select `item`.`user_name` AS `user_name`,count(`item`.`user_name`) AS `sold` from (`item` join `sold2` on((`item`.`itemID` = `sold2`.`itemID`))) group by `item`.`user_name` ;

-- --------------------------------------------------------

--
-- Structure for view `ur1`
--
DROP TABLE IF EXISTS `ur1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`bidfusionUser`@`localhost` SQL SECURITY DEFINER VIEW `ur1`  AS  select `user`.`user_name` AS `user_name`,count(`item`.`itemID`) AS `listed` from (`user` left join `item` on((`user`.`user_name` = `item`.`user_name`))) group by `user`.`user_name` ;

-- --------------------------------------------------------

--
-- Structure for view `ur2`
--
DROP TABLE IF EXISTS `ur2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`bidfusionUser`@`localhost` SQL SECURITY DEFINER VIEW `ur2`  AS  select `ur1`.`user_name` AS `user_name`,`ur1`.`listed` AS `listed`,count(`sold2`.`user_name`) AS `purchased` from (`ur1` left join `sold2` on((`ur1`.`user_name` = `sold2`.`user_name`))) group by `ur1`.`user_name` ;

-- --------------------------------------------------------

--
-- Structure for view `ur3`
--
DROP TABLE IF EXISTS `ur3`;

CREATE ALGORITHM=UNDEFINED DEFINER=`bidfusionUser`@`localhost` SQL SECURITY DEFINER VIEW `ur3`  AS  select `ur2`.`user_name` AS `user_name`,`ur2`.`listed` AS `listed`,`sold3`.`sold` AS `sold`,`ur2`.`purchased` AS `purchased` from (`ur2` left join `sold3` on((`ur2`.`user_name` = `sold3`.`user_name`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AdminUser`
--
ALTER TABLE `AdminUser`
  ADD PRIMARY KEY (`adminID`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `Bid`
--
ALTER TABLE `Bid`
  ADD PRIMARY KEY (`bidID`),
  ADD KEY `FK_Bid_itemID_Item_itemID` (`itemID`),
  ADD KEY `FK_Bid_user_name_User_user_name` (`user_name`);

--
-- Indexes for table `Item`
--
ALTER TABLE `Item`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `FK_Item_user_name_User_user_name` (`user_name`);

--
-- Indexes for table `Rating`
--
ALTER TABLE `Rating`
  ADD PRIMARY KEY (`ratingID`),
  ADD KEY `fk_Rating_itemID_Item_itemID` (`itemID`),
  ADD KEY `fk_Rating_userName_User_user_name` (`user_name`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AdminUser`
--
ALTER TABLE `AdminUser`
  MODIFY `adminID` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Bid`
--
ALTER TABLE `Bid`
  MODIFY `bidID` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Item`
--
ALTER TABLE `Item`
  MODIFY `itemID` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `Rating`
--
ALTER TABLE `Rating`
  MODIFY `ratingID` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `userID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AdminUser`
--
ALTER TABLE `AdminUser`
  ADD CONSTRAINT `FK_AdminUser_user_name_User_user_name` FOREIGN KEY (`user_name`) REFERENCES `User` (`user_name`);

--
-- Constraints for table `Bid`
--
ALTER TABLE `Bid`
  ADD CONSTRAINT `FK_Bid_itemID_Item_itemID` FOREIGN KEY (`itemID`) REFERENCES `Item` (`itemID`),
  ADD CONSTRAINT `FK_Bid_user_name_User_user_name` FOREIGN KEY (`user_name`) REFERENCES `User` (`user_name`);

--
-- Constraints for table `Item`
--
ALTER TABLE `Item`
  ADD CONSTRAINT `FK_Item_user_name_User_user_name` FOREIGN KEY (`user_name`) REFERENCES `User` (`user_name`);

--
-- Constraints for table `Rating`
--
ALTER TABLE `Rating`
  ADD CONSTRAINT `fk_Rating_itemID_Item_itemID` FOREIGN KEY (`itemID`) REFERENCES `Item` (`itemID`),
  ADD CONSTRAINT `fk_Rating_userName_User_user_name` FOREIGN KEY (`user_name`) REFERENCES `User` (`user_name`);
