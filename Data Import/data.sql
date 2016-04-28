-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2016 at 04:50 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `money_lover`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(140) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'GangBang'),
(2, 'ahihi');

-- --------------------------------------------------------

--
-- Table structure for table `indentites`
--

CREATE TABLE `indentites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `device` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `token_created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `indentites`
--

INSERT INTO `indentites` (`id`, `user_id`, `token`, `device`, `token_created_date`) VALUES
(1, 1, '73a395f4b62a75ba12512e2d2b3b6dac', '231123', '2016-03-28 18:00:36'),
(7, 8, '222a312f1eddd6bd8d6d5f36c56e78cd', 'ios69696', '2016-04-21 14:49:20'),
(60, 8, '291aba32fe355f1405856ec5f9246736', 'random', '2016-04-27 06:13:27'),
(61, 8, '483b51f67a919986a350fb65e24385dc', 'random', '2016-04-27 06:20:54'),
(62, 8, 'b2d0115f5a533d2e0863b96ee3df0dc4', 'random', '2016-04-27 06:22:26'),
(63, 8, 'a6990d4399c5fd57a91cdb002a3a5501', 'random', '2016-04-27 06:24:04'),
(64, 8, 'dde278ca1efd3d6cb545161184f82e7f', 'random', '2016-04-27 06:24:28'),
(65, 8, '0c523146cde45da17bd23eac169a072b', 'random', '2016-04-27 06:26:53'),
(66, 8, '4a3fd335c301bf92337d2ea9ad8063f8', 'random', '2016-04-27 06:31:24'),
(67, 8, 'ee6c1fb1c7102e19a1e3bb03611ab981', 'random', '2016-04-27 06:33:57'),
(68, 8, '48ac26df8378dc1bd500bb3b419a218b', 'random', '2016-04-27 06:34:51'),
(69, 8, 'd06d06ed1382104fe9af0fe6ae07485f', 'random', '2016-04-27 06:40:37'),
(70, 8, '6c99dbd14e8e03337e2aabb6fdb49601', 'random', '2016-04-27 06:42:58'),
(71, 8, 'f19e2730c94d87f6a6f62de2cb189f8d', 'random', '2016-04-27 06:43:29'),
(72, 8, '579a9ea5c846f8fe0655b0c995c3b298', 'random', '2016-04-27 08:24:22'),
(73, 8, 'e72a9bc48dcfd9ff184316381bc3c95a', 'random', '2016-04-27 08:53:20'),
(74, 8, '6bea1212b725cc919d7b2d74f46695b9', 'random', '2016-04-28 16:43:57');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `cost` decimal(10,2) NOT NULL,
  `note` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `user_id`, `category_id`, `cost`, `note`, `created_date`) VALUES
(1, 1, 1, '21312.00', 'sfdasf', '2016-04-14 00:00:00'),
(2, 2, 1, '121212.00', 'fuck u bitch', '2016-06-06 06:18:00'),
(3, 1, 2, '123123.00', 'sadcasfdasf', '2016-04-20 00:00:00'),
(4, 1, 1, '123123.21', 'asdasdasd', '2016-04-08 16:07:51'),
(6, 1, 2, '69669.97', 'fucking work', '2016-04-08 16:10:09'),
(7, 1, 2, '6667.00', 'hehehe', '2016-04-08 16:29:05'),
(8, 1, 2, '12312.23', '', '2016-04-27 06:15:46'),
(9, 1, 2, '12312.23', NULL, '2016-04-27 06:20:10'),
(10, 1, 2, '123123.00', 'Test note', '2016-04-27 06:22:24'),
(11, 1, 2, '123123.00', 'Test note', '2016-04-27 06:24:00'),
(12, 1, 2, '123123.00', 'Test note', '2016-04-27 06:24:24'),
(13, 1, 2, '123123.00', 'Test note', '2016-04-27 06:26:49'),
(14, 1, 2, '0.00', NULL, '2016-04-27 06:27:35'),
(15, 1, 2, '123123.00', 'Test note', '2016-04-27 06:31:13'),
(16, 1, 2, '1231.12', NULL, '2016-04-27 06:31:39'),
(17, 1, 2, '123123.00', 'Test note', '2016-04-27 06:33:52'),
(18, 1, 2, '123123.00', 'Test note', '2016-04-27 06:34:47'),
(19, 1, 2, '123123.00', 'Test note', '2016-04-27 06:40:31'),
(20, 1, 2, '123123.00', 'Test note', '2016-04-27 06:42:54'),
(21, 1, 2, '123123.00', 'Test note', '2016-04-27 06:43:25'),
(22, 1, 2, '123123.00', 'Test note', '2016-04-27 08:24:18'),
(23, 1, 2, '123123.00', 'Test note', '2016-04-27 08:53:14'),
(24, 1, 2, '123123.00', 'Test note', '2016-04-28 16:43:51');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_full_name` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `user_phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_email`, `user_pass`, `user_full_name`, `user_phone`, `create_date`) VALUES
(1, 'th', '123456', 'thinh dap trai', '1656220922', '2016-03-10 00:00:00'),
(2, 'thjnh195@gmail.comm', '123456', 'adfafasf', '231123', '2016-03-29 16:35:14'),
(3, 'thjnh195@gmsaail.comm', '123456', 'adfafasf', '231123', '2016-03-29 16:35:28'),
(8, 'thjnh195@gmail.com', '$2y$10$112Qs1yDMwOyUQ2jC01Ib.ujrZniG3ileFwSQ/Xii2.u17KZMIl76', 'con cec con cec', '+84 696969', '2016-04-21 14:49:14'),
(9, 'thjnh195@gmail.comdsfg', '$2y$10$k.49pnviYQIkpoCIgX1QLuZdZJKvgFw5b2CbuiKZFh/yR4AEm4G1y', 'con cec con cec', '+84 696969', '2016-04-25 06:12:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `indentites`
--
ALTER TABLE `indentites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_62573C6D5F37A13B` (`token`),
  ADD KEY `IDX_62573C6DA76ED395` (`user_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F4AB8A06A76ED395` (`user_id`),
  ADD KEY `IDX_F4AB8A0612469DE2` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UNIQ_2DA17977550872C` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `indentites`
--
ALTER TABLE `indentites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `indentites`
--
ALTER TABLE `indentites`
  ADD CONSTRAINT `FK_62573C6DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `FK_F4AB8A0612469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `FK_F4AB8A06A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
