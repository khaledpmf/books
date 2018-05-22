-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 22, 2018 at 03:18 AM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tcomtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` mediumtext NOT NULL,
  `author` mediumtext NOT NULL,
  `released` mediumtext NOT NULL,
  `img_url` mediumtext,
  `happened` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `released`, `img_url`, `happened`) VALUES
(46, 'Some title 2', 'Mihajlo Marjanovic', '05/21/2018', '1526956686.jpg', '2018-05-21 10:38:06'),
(41, 'Anna Karenina', 'Leo Tolstoy', '04/10/1877', '1526940257.jpg', '2018-05-21 10:40:06'),
(45, 'Some title', 'Mihajlo Marjanovic', '05/06/1877', '1526956653.jpg', '2018-05-21 13:38:06'),
(42, 'Madame Bovary', 'Gustave Flaubert', '12/15/1856', '1526940393.jpg', '2018-05-21 13:39:21'),
(43, 'Middlemarch', 'Ann Evans', '01/01/1871', '1526940506.jpg', '2018-05-21 13:39:35'),
(44, 'PHP', 'Zend Technologies', '05/21/2018', '1526943006.jpg', '2018-05-21 13:39:53');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
