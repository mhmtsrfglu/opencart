-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 04, 2020 at 12:48 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `opencart`
--

-- --------------------------------------------------------

--
-- Table structure for table `oc_notifications`
--

CREATE TABLE `oc_notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `sort_order` int(3) DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oc_notifications`
--

INSERT INTO `oc_notifications` (`id`, `title`, `content`, `sort_order`, `date_added`) VALUES
(7, 'İlk Bildirim', 'Bu bildirim deneme amaçlı olmalıdır                    \r\n                  ', 1, '0000-00-00 00:00:00'),
(8, 'İkinci Bildirim', 'deneme amaçlıdır                    \r\n                  ', 2, '2020-04-04 10:54:37'),
(9, 'üçüncü bildirim', 'üçüncü deneme bildirimi                    \r\n                  ', 8, '2020-04-04 12:43:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oc_notifications`
--
ALTER TABLE `oc_notifications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oc_notifications`
--
ALTER TABLE `oc_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
