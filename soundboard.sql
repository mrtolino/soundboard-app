-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-09-06 05:02:06
-- 服务器版本： 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `soundboard`
--

-- --------------------------------------------------------

--
-- 表的结构 `boards`
--

CREATE TABLE `boards` (
  `u_id` int(11) NOT NULL,
  `u_user_id` int(11) NOT NULL,
  `title` char(30) NOT NULL,
  `public` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `boards`
--

INSERT INTO `boards` (`u_id`, `u_user_id`, `title`, `public`) VALUES
(1, 1, 'testboard', 0),
(3, 1, 'testing', 0),
(4, 1, 'hello', 1),
(5, 1, 'hello there', 0),
(6, 1, 'test2', 1),
(7, 1, 'test3', 0),
(9, 1, 'helloooo', 1),
(11, 1, 'name', 1),
(12, 5, 'man', 1),
(13, 1, 'gfas', 1),
(14, 5, 'mmcc', 1);

-- --------------------------------------------------------

--
-- 表的结构 `content`
--

CREATE TABLE `content` (
  `u_id` int(11) NOT NULL,
  `u_board_id` int(11) NOT NULL,
  `u_img_filename` varchar(255) NOT NULL,
  `u_sound_filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `content`
--

INSERT INTO `content` (`u_id`, `u_board_id`, `u_img_filename`, `u_sound_filename`) VALUES
(8, 3, '999f23c0300f697812ecdbf4b8f68409ddaa37a7.png', '92e4f111a32ad296f080565eb56b9305bf47e88b.wav'),
(10, 3, '630d507869ca07726649469e7b5d72c00bc31d8d.png', '32ef2a03e46f3d186d847464b1daa41f6c89fe98.wav'),
(11, 3, 'a1e33ae1532107a5470ed4e5330803336399136f.png', 'f4aeb7a6294fe200087e1366477833c1d3d4f9bb.wav'),
(12, 3, '32d9b8e4d6f32ac49c661ebad67dd8aa7bd40e14.png', 'fa230b831692d53b211649e488c1a58d93e52920.wav'),
(13, 4, 'cd76ba503de4f8e0fa036eb4e3810fe1697d45fb.jpg', 'e30c03900245afb77d6dadec7ad3dfe241e2b7ca.wav'),
(15, 12, 'bb8b6297535b52289135fa85279f2ac44d18d074.png', 'c561e1d32d2d3e8e1056e23a63a5461421293540.wav'),
(16, 12, '0937f9a2cb85f4f2e54643b1f0e5a65e1605fc48.png', '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3');

-- --------------------------------------------------------

--
-- 表的结构 `log_baccess`
--

CREATE TABLE `log_baccess` (
  `log_id` int(11) NOT NULL,
  `log_boardname` text,
  `log_username` text,
  `log_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `log_baccess`
--

INSERT INTO `log_baccess` (`log_id`, `log_boardname`, `log_username`, `log_timestamp`) VALUES
(15, 'helloooo', 'admin', '2017-09-04 01:14:03'),
(16, 'test2', 'admin', '2017-09-04 01:14:04'),
(17, 'name', 'admin', '2017-09-04 01:14:06'),
(18, 'test2', 'admin', '2017-09-04 01:14:40'),
(19, 'asdfgfa', 'admin', '2017-09-04 01:14:55'),
(20, 'asdfgfa', 'visitor', '2017-09-04 01:15:29'),
(21, 'hello', 'visitor', '2017-09-04 01:41:12'),
(22, 'asdfgfa', 'visitor', '2017-09-04 01:41:42'),
(23, 'asdfgfa', 'visitor', '2017-09-04 01:42:01'),
(24, 'asdfgfa', 'visitor', '2017-09-04 01:56:50'),
(25, 'asdfgfa', 'visitor', '2017-09-04 01:57:18'),
(26, 'asdfgfa', 'aaa', '2017-09-04 01:57:42'),
(27, 'asdfgfa', 'aaa', '2017-09-04 01:58:12'),
(28, 'helloooo', 'visitor', '2017-09-04 03:10:53'),
(29, 'test2', 'visitor', '2017-09-04 03:11:02'),
(30, 'test2', 'visitor', '2017-09-04 03:11:18'),
(31, 'test2', 'visitor', '2017-09-04 03:11:41'),
(32, 'hello', 'visitor', '2017-09-04 03:11:43'),
(33, 'man', 'visitor', '2017-09-04 03:11:49'),
(34, 'gfas', 'visitor', '2017-09-04 03:11:54'),
(35, 'mmcc', 'visitor', '2017-09-04 03:11:56'),
(36, 'name', 'visitor', '2017-09-04 03:11:58'),
(37, 'name', 'visitor', '2017-09-04 03:12:00'),
(38, 'name', 'visitor', '2017-09-04 03:13:02'),
(39, 'test2', 'visitor', '2017-09-04 03:13:17'),
(40, 'test2', 'visitor', '2017-09-04 03:15:35'),
(41, 'hello', 'visitor', '2017-09-04 03:15:40'),
(42, 'test2', 'visitor', '2017-09-04 03:15:42'),
(43, 'hello', 'visitor', '2017-09-04 03:17:30'),
(44, 'man', 'visitor', '2017-09-04 03:17:32'),
(45, 'man', 'visitor', '2017-09-04 03:19:01'),
(46, 'hello', 'visitor', '2017-09-04 03:20:14'),
(47, 'man', 'visitor', '2017-09-04 03:20:16'),
(48, 'man', 'visitor', '2017-09-04 03:23:26'),
(49, 'man', 'visitor', '2017-09-04 03:24:13'),
(50, 'man', 'visitor', '2017-09-04 03:24:14'),
(51, 'man', 'visitor', '2017-09-04 03:24:37'),
(52, 'man', 'visitor', '2017-09-04 03:24:38'),
(53, 'man', 'visitor', '2017-09-04 03:24:38'),
(54, 'man', 'visitor', '2017-09-04 03:26:40'),
(55, 'man', 'visitor', '2017-09-04 03:43:34'),
(56, 'man', 'visitor', '2017-09-04 03:43:34'),
(57, 'man', 'visitor', '2017-09-04 03:43:34'),
(58, 'man', 'visitor', '2017-09-04 03:43:34'),
(59, 'man', 'visitor', '2017-09-04 03:43:34'),
(60, 'man', 'visitor', '2017-09-04 03:43:35'),
(61, 'man', 'visitor', '2017-09-04 03:47:36'),
(62, 'man', 'visitor', '2017-09-04 03:47:49'),
(63, 'man', 'visitor', '2017-09-04 03:49:15'),
(64, 'man', 'visitor', '2017-09-04 03:49:19'),
(65, 'man', 'visitor', '2017-09-04 03:50:47'),
(66, 'man', 'visitor', '2017-09-04 03:51:19'),
(67, 'man', 'visitor', '2017-09-04 03:51:26'),
(68, 'man', 'visitor', '2017-09-04 04:00:07'),
(69, 'man', 'visitor', '2017-09-04 04:00:16'),
(70, 'man', 'visitor', '2017-09-04 04:00:17'),
(71, 'man', 'visitor', '2017-09-04 04:02:15'),
(72, 'man', 'visitor', '2017-09-04 04:02:32'),
(73, 'man', 'visitor', '2017-09-04 04:04:50'),
(74, 'man', 'visitor', '2017-09-04 04:04:54'),
(75, 'man', 'visitor', '2017-09-04 04:05:10'),
(76, 'man', 'visitor', '2017-09-04 04:11:46'),
(77, 'man', 'visitor', '2017-09-04 04:12:16'),
(78, 'hello', 'visitor', '2017-09-04 04:22:25'),
(79, 'man', 'visitor', '2017-09-04 04:22:26'),
(80, 'hello', 'admin', '2017-09-04 04:32:29'),
(81, 'man', 'visitor', '2017-09-04 04:32:43'),
(82, 'mmcc', 'aaa', '2017-09-04 04:33:01'),
(83, 'mmcc', 'aaa', '2017-09-04 04:33:03'),
(84, 'man', 'aaa', '2017-09-04 04:33:05'),
(85, 'test2', 'visitor', '2017-09-04 04:33:18'),
(86, 'name', 'visitor', '2017-09-04 04:33:20'),
(87, 'hello', 'visitor', '2017-09-04 04:33:21'),
(88, 'man', 'visitor', '2017-09-04 04:33:24'),
(89, 'hello', 'visitor', '2017-09-04 04:34:34'),
(90, 'test2', 'visitor', '2017-09-04 04:45:54'),
(91, 'hello', 'visitor', '2017-09-04 04:45:55'),
(92, 'hello', 'visitor', '2017-09-04 06:13:14'),
(93, 'man', 'visitor', '2017-09-04 06:13:24'),
(94, 'man', 'visitor', '2017-09-04 06:14:41');

-- --------------------------------------------------------

--
-- 表的结构 `log_login`
--

CREATE TABLE `log_login` (
  `log_id` int(11) NOT NULL,
  `log_uname` text NOT NULL,
  `log_inout` int(11) NOT NULL,
  `log_issuccessful` tinyint(1) NOT NULL,
  `log_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `log_login`
--

INSERT INTO `log_login` (`log_id`, `log_uname`, `log_inout`, `log_issuccessful`, `log_timestamp`) VALUES
(9, '123', 1, 0, '2017-09-04 01:04:27'),
(10, 'aaa', 1, 1, '2017-09-04 01:04:27'),
(11, 'aaa', 0, 1, '2017-09-04 01:04:27'),
(12, 'shant', 1, 1, '2017-09-04 01:08:41'),
(13, 'shant', 0, 1, '2017-09-04 01:08:53'),
(14, 'aaa', 1, 1, '2017-09-04 01:08:56'),
(15, 'aaa', 0, 1, '2017-09-04 01:09:02'),
(16, 'admin', 1, 1, '2017-09-04 01:09:34'),
(17, 'admin', 0, 1, '2017-09-04 01:15:28'),
(18, 'aaa', 1, 1, '2017-09-04 01:57:39'),
(19, 'aaa', 0, 1, '2017-09-04 02:38:53'),
(20, 'admin', 1, 1, '2017-09-04 02:38:58'),
(21, 'admin', 0, 1, '2017-09-04 03:10:53'),
(22, 'admin', 1, 1, '2017-09-04 03:17:37'),
(23, 'admin', 0, 1, '2017-09-04 03:19:00'),
(24, 'admin', 1, 1, '2017-09-04 03:19:21'),
(25, 'admin', 0, 1, '2017-09-04 03:20:13'),
(26, 'aaa', 1, 1, '2017-09-04 04:14:38'),
(27, 'aaa', 0, 1, '2017-09-04 04:14:41'),
(28, 'admin', 1, 1, '2017-09-04 04:14:44'),
(29, 'admin', 0, 1, '2017-09-04 04:22:24'),
(30, 'admin', 1, 1, '2017-09-04 04:22:37'),
(31, 'admin', 0, 1, '2017-09-04 04:32:42'),
(32, 'aaa', 1, 1, '2017-09-04 04:32:57'),
(33, 'aaa', 0, 1, '2017-09-04 04:33:16'),
(34, 'shant', 1, 1, '2017-09-04 04:48:00'),
(35, 'shant', 0, 1, '2017-09-04 05:01:46'),
(36, 'admin', 1, 1, '2017-09-04 05:01:49'),
(37, 'admin', 0, 1, '2017-09-04 06:02:35'),
(38, 'i54cxy', 1, 0, '2017-09-04 06:13:21');

-- --------------------------------------------------------

--
-- 表的结构 `log_saccess`
--

CREATE TABLE `log_saccess` (
  `log_id` int(11) NOT NULL,
  `log_soundfile` text NOT NULL,
  `log_username` text NOT NULL,
  `log_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `log_saccess`
--

INSERT INTO `log_saccess` (`log_id`, `log_soundfile`, `log_username`, `log_timestamp`) VALUES
(1, '', 'visitor', '2017-09-04 01:53:37'),
(2, '', 'visitor', '2017-09-04 01:54:06'),
(3, '', 'visitor', '2017-09-04 01:54:47'),
(4, 'c561e1d32d2d3e8e1056e23a63a5461421293540.wav', 'visitor', '2017-09-04 01:57:20'),
(5, 'c561e1d32d2d3e8e1056e23a63a5461421293540.wav', 'aaa', '2017-09-04 01:57:43'),
(6, 'c561e1d32d2d3e8e1056e23a63a5461421293540.wav', 'aaa', '2017-09-04 01:58:13'),
(7, 'e4ec67875b7c76d0138dd20db0dcf3a2a638e85b.wav', 'visitor', '2017-09-04 03:19:02'),
(8, 'e4ec67875b7c76d0138dd20db0dcf3a2a638e85b.wav', 'visitor', '2017-09-04 03:19:03'),
(9, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 03:20:17'),
(10, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 03:20:22'),
(11, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 03:20:23'),
(12, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 03:20:23'),
(13, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 03:20:24'),
(14, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 03:41:27'),
(15, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 03:41:48'),
(16, 'sounds[index].title', 'visitor', '2017-09-04 03:49:20'),
(17, 'sounds[index].title', 'visitor', '2017-09-04 03:49:22'),
(18, 'c561e1d32d2d3e8e1056e23a63a5461421293540.wav', 'visitor', '2017-09-04 04:11:47'),
(19, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 04:12:12'),
(20, 'c561e1d32d2d3e8e1056e23a63a5461421293540.wav', 'visitor', '2017-09-04 04:12:13'),
(21, 'c561e1d32d2d3e8e1056e23a63a5461421293540.wav', 'visitor', '2017-09-04 04:14:10'),
(22, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 04:14:12'),
(23, 'c561e1d32d2d3e8e1056e23a63a5461421293540.wav', 'visitor', '2017-09-04 04:14:15'),
(24, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 04:14:17'),
(26, 'c561e1d32d2d3e8e1056e23a63a5461421293540.wav', 'visitor', '2017-09-04 04:22:27'),
(27, '', 'admin', '2017-09-04 04:22:59'),
(28, '', 'admin', '2017-09-04 04:23:03'),
(29, '', 'admin', '2017-09-04 04:23:16'),
(30, '', 'admin', '2017-09-04 04:23:18'),
(31, '', 'admin', '2017-09-04 04:23:58'),
(32, '', 'admin', '2017-09-04 04:24:22'),
(33, '', 'admin', '2017-09-04 04:24:57'),
(34, '', 'admin', '2017-09-04 04:25:17'),
(35, '', 'admin', '2017-09-04 04:25:40'),
(36, '', 'admin', '2017-09-04 04:26:19'),
(37, '', 'admin', '2017-09-04 04:26:40'),
(38, '', 'admin', '2017-09-04 04:28:38'),
(39, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'admin', '2017-09-04 04:29:17'),
(40, 'c561e1d32d2d3e8e1056e23a63a5461421293540.wav', 'admin', '2017-09-04 04:29:27'),
(41, 'e30c03900245afb77d6dadec7ad3dfe241e2b7ca.wav', 'admin', '2017-09-04 04:32:30'),
(42, 'e30c03900245afb77d6dadec7ad3dfe241e2b7ca.wav', 'admin', '2017-09-04 04:32:32'),
(43, 'c561e1d32d2d3e8e1056e23a63a5461421293540.wav', 'visitor', '2017-09-04 04:32:44'),
(44, 'c561e1d32d2d3e8e1056e23a63a5461421293540.wav', 'aaa', '2017-09-04 04:33:06'),
(45, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'aaa', '2017-09-04 04:33:07'),
(46, 'c561e1d32d2d3e8e1056e23a63a5461421293540.wav', 'visitor', '2017-09-04 06:13:24'),
(47, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 06:13:27'),
(48, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 06:13:41'),
(49, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 06:14:24'),
(50, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 06:14:26'),
(51, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 06:14:42'),
(52, 'c561e1d32d2d3e8e1056e23a63a5461421293540.wav', 'visitor', '2017-09-04 06:48:06'),
(53, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 06:48:08'),
(54, '6d1e2a1443902fc8204e90bfa87d0bbf0647d749.mp3', 'visitor', '2017-09-04 06:48:10');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_uname` char(30) NOT NULL,
  `u_pword` varchar(256) NOT NULL,
  `u_fname` char(20) NOT NULL,
  `u_lname` char(30) NOT NULL,
  `u_email` char(40) NOT NULL,
  `u_isadmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`u_id`, `u_uname`, `u_pword`, `u_fname`, `u_lname`, `u_email`, `u_isadmin`) VALUES
(1, 'shant', '01f6a10bdd16c8efdde27878dd15e5e3ffa11702fe1b49c7743fdbb7156b3dd8', 'shant', 'shant', 'shant', 0),
(2, 'test', '8b58f9b9cfbe51b89ccd29e96233c99a81814f83fdccd3422ebb648f58ce94b6', 'test', 'test', 'test', 0),
(4, 'test2', '158b93f90c527a3d0e703a1f2caf02e4786a5e9aeaf97ecce1671496daa23657', 'test2', 'test2', 'test2', 0),
(5, 'admin', '9e00ca91f646ab28a8cd4a180fb225da0bf755512a73d08ccecdb933b8669a0a', 'a', 'a', 'a', 1),
(6, 'aaa', '4f9c4274e675b7facb817aa76ac28e503cf87a4006a60e6e92e41024d51fe4c0', 'aaa', 'aaa', 'aaa', 0),
(7, 'bb', '1cb13063699d54670d70ed0819de862f387ad18fc9494dd7cd065508584afcbe', 'bb', 'bb', 'bb', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `user_id_idx` (`u_user_id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`u_id`),
  ADD KEY `board_id_idx` (`u_board_id`);

--
-- Indexes for table `log_baccess`
--
ALTER TABLE `log_baccess`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `log_login`
--
ALTER TABLE `log_login`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `log_saccess`
--
ALTER TABLE `log_saccess`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_uname` (`u_uname`),
  ADD UNIQUE KEY `u_email` (`u_email`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `boards`
--
ALTER TABLE `boards`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- 使用表AUTO_INCREMENT `content`
--
ALTER TABLE `content`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- 使用表AUTO_INCREMENT `log_baccess`
--
ALTER TABLE `log_baccess`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- 使用表AUTO_INCREMENT `log_login`
--
ALTER TABLE `log_login`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- 使用表AUTO_INCREMENT `log_saccess`
--
ALTER TABLE `log_saccess`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 限制导出的表
--

--
-- 限制表 `boards`
--
ALTER TABLE `boards`
  ADD CONSTRAINT `userID` FOREIGN KEY (`u_user_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `boardID` FOREIGN KEY (`u_board_id`) REFERENCES `boards` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
