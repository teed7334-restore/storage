-- phpMyAdmin SQL Dump
-- version 4.5.0
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2015 年 09 月 28 日 15:30
-- 伺服器版本: 10.0.21-MariaDB-log
-- PHP 版本： 5.6.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `test`;

-- --------------------------------------------------------

--
-- 資料表結構 `ugroup`
--

CREATE TABLE `ugroup` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `is_disabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `ugroup`
--

INSERT INTO `ugroup` (`id`, `name`, `description`, `is_disabled`) VALUES
(1, 'Wheel', 'Super User', 0),
(2, 'System', 'System agent', 0),
(1000, 'Users', 'Users', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `account` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `home` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shell` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `is_disabled` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `user`
--

INSERT INTO `user` (`id`, `account`, `password`, `group_id`, `home`, `shell`, `is_disabled`) VALUES
(1, 'Ringo', '25d55ad283aa400af464c76d713c07ad', 1000, '/home/Ringo', '/bin/bash', 0),
(2, 'Abow', '25d55ad283aa400af464c76d713c07ad', 1000, '/home/Abow', '/bin/bash', 0),
(3, 'Joann', '25d55ad283aa400af464c76d713c07ad', 1000, '/home/Joann', '/bin/bash', 0),
(4, 'Peter', '25d55ad283aa400af464c76d713c07ad', 1000, '/home/Peter', '/bin/bash', 0),
(5, 'EVA', '25d55ad283aa400af464c76d713c07ad', 1000, '/home/EVA', '/bin/bash', 0),
(6, 'Paul', '25d55ad283aa400af464c76d713c07ad', 1000, '/home/Paul', '/bin/bash', 0),
(7, 'Baga', '25d55ad283aa400af464c76d713c07ad', 1000, '/home/Baga', '/bin/bash', 0),
(8, 'Luke', '25d55ad283aa400af464c76d713c07ad', 1000, '/home/Luke', '/bin/bash', 0),
(9, 'Bob', '25d55ad283aa400af464c76d713c07ad', 1000, '/home/Bob', '/bin/bash', 0),
(10, 'Alice', '25d55ad283aa400af464c76d713c07ad', 1000, '/home/Alice', '/bin/bash', 0),
(11, 'Joe', '25d55ad283aa400af464c76d713c07ad', 1000, '/home/Joe', '/bin/bash', 0),
(13, 'Hebe', '25d55ad283aa400af464c76d713c07ad', 1000, '/home/Hebe', '/bin/bash', 0);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `ugroup`
--
ALTER TABLE `ugroup`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_2` (`account`),
  ADD KEY `account` (`account`,`password`),
  ADD KEY `group_id` (`group_id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `ugroup`
--
ALTER TABLE `ugroup`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;
--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
