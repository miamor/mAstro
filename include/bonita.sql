-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 01, 2015 at 05:38 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bonita`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE IF NOT EXISTS `activities` (
  `id` int(255) NOT NULL,
  `type` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `uid` int(255) NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(255) NOT NULL,
  `title` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `cover` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `likes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `title`, `link`, `avatar`, `cover`, `website`, `facebook`, `twitter`, `likes`, `time`) VALUES
(1, 'Brand 1', 'brand-1', 'http://localhost/bonita/data/img/Venice.jpg', 'http://localhost/bonita/data/img/Paris-8.jpg', '', '', '', '1, 2, 3', '');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(255) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `title` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `show` int(1) NOT NULL DEFAULT '1',
  `for` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `cat_id`, `title`, `link`, `show`, `for`, `time`) VALUES
(1, 0, 'Clothing', 'clothing', 1, '', ''),
(2, 1, 'Coats', 'coats', 1, '', ''),
(3, 1, 'Jackets', 'jackets', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `channels`
--

CREATE TABLE IF NOT EXISTS `channels` (
  `id` int(255) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `des` longtext COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE IF NOT EXISTS `collections` (
  `id` int(255) NOT NULL,
  `cat_id` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Categories items belong to',
  `coid` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Collections pinged to',
  `bid` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `title` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `thumb` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `des` longtext COLLATE utf8_unicode_ci NOT NULL,
  `for` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `show` int(1) NOT NULL DEFAULT '1',
  `likes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dislikes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `cat_id`, `coid`, `bid`, `uid`, `title`, `link`, `thumb`, `des`, `for`, `show`, `likes`, `dislikes`, `time`) VALUES
(1, '1, 2, 3', '', 1, 1, 'Collection 1', 'collection-1', 'http://localhost/bonita/data/img/Venice.jpg', 'Des', 'f', 1, '1, 2, 3', '4', '');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE IF NOT EXISTS `colors` (
  `id` int(255) NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` char(6) COLLATE utf8_unicode_ci NOT NULL,
  `items` int(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `color`, `code`, `items`) VALUES
(1, 'black', '000000', 0),
(2, 'black', '111111', 0);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(255) NOT NULL,
  `cat_id` int(255) NOT NULL COMMENT 'Category id',
  `coid` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Collections id',
  `br_link` varchar(3000) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Brand id',
  `brand` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `uid` int(255) NOT NULL,
  `uip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `des` longtext COLLATE utf8_unicode_ci NOT NULL,
  `specification` longtext COLLATE utf8_unicode_ci NOT NULL,
  `snippets` longtext COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sale` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Eg: 20 for 20%',
  `thumbs` longtext COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numbers` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Size-Total-Left (Eg: S-5-2|M-2-1|L-5-0)',
  `show` int(1) NOT NULL DEFAULT '1',
  `views` int(255) NOT NULL,
  `likes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dislikes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `fav` longtext COLLATE utf8_unicode_ci NOT NULL,
  `for` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT 'm:male|f:female',
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `cat_id`, `coid`, `br_link`, `brand`, `uid`, `uip`, `title`, `link`, `des`, `specification`, `snippets`, `price`, `sale`, `thumbs`, `code`, `numbers`, `show`, `views`, `likes`, `dislikes`, `fav`, `for`, `time`) VALUES
(1, 3, '1', 'brand-1', 'Brand 1', 2, '', 'Item 1', 'item-1', 'This is description for item 1', 'Specification', 'Snippets', '500000', '20', 'Paris-8.jpg::Thumbnail title::CCCCCC+FFFFFF+CC9999+999999+CCCC99+996666+FFCCCC+CCCCFF|Paris-5.jpg::Thumbnail title::FFCC99+FFCCCC+FFFFCC+CC6666+CC9966+CC9999+CCCC99+CCCC66|Venice.jpg::Thumbnail title::333333+000000+000033+996666+663333+CC9966+666666+003333', 'M25000', 'S-5-5|M-5-2', 1, 72, '1,2,3', '4,5', '', 'f', '1428634005'),
(2, 2, '1', 'brand-1', 'Brand 1', 1, '', 'Item 2', 'item-2', 'This is description for item 2', 'Specification', 'Snippets', '500000', '5', 'Paris-5.jpg::Thumbnail title::CCCCCC+FFFFFF+CC9999+999999+CCCC99+996666+FFCCCC+CCCCFF|Paris-8.jpg::Thumbnail title::FFCC99+FFCCCC+FFFFCC+CC6666+CC9966+CC9999+CCCC99+CCCC66|Venice.jpg::Thumbnail title::333333+000000+000033+996666+663333+CC9966+666666+003333', 'M35000', 'S-5-5|M-5-2', 1, 0, '', '', '', 'f', ''),
(3, 2, '1', 'brand-1', 'Brand 1', 1, '', 'Item 3', 'item-3', 'This is description for item 3', 'Specification', 'Snippets', '500000', '13', 'Venice.jpg::Thumbnail title::333333+000000+000033+996666+663333+CC9966+666666+003333|Paris-8.jpg::Thumbnail title::CCCCCC+FFFFFF+CC9999+999999+CCCC99+996666+FFCCCC+CCCCFF|Paris-5.jpg::Thumbnail title::FFCC99+FFCCCC+FFFFCC+CC6666+CC9966+CC9999+CCCC99+CCCC66', 'M35000', 'S-5-5|M-5-2', 1, 0, '', '', '', 'f', ''),
(4, 2, '1', 'brand-1', 'Brand 1', 1, '', 'Item 4', 'item-4', 'This is description for item 4', 'Specification', 'Snippets', '500000', '37', '11.jpg|Paris-8.jpg|Paris-5.jpg', 'M35000', 'S-5-5|M-5-2', 1, 0, '', '', '', 'f', ''),
(5, 3, '1', 'brand-1', 'Brand 1', 1, '', 'Item 5', 'item-5', 'This is description for item 5', 'Specification', 'Snippets', '500000', '50', '12.jpg|Paris-8.jpg|Paris-5.jpg', 'M35000', 'S-5-5|M-5-2', 1, 0, '', '', '', 'f', '');

-- --------------------------------------------------------

--
-- Table structure for table `item_book`
--

CREATE TABLE IF NOT EXISTS `item_book` (
  `id` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `uip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `iid` int(255) NOT NULL,
  `start` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `end` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `process` int(1) NOT NULL COMMENT '0:None|1:In process|2:Delivered|3:Confirm received|4:Confirm returned the goods & Completed',
  `p1` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'process 1 time',
  `p2` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'process 2 time',
  `p3` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'process 3 time',
  `p4` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'process 4 time',
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_ratings`
--

CREATE TABLE IF NOT EXISTS `item_ratings` (
  `id` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `uip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `iid` int(255) NOT NULL,
  `rate` int(1) NOT NULL,
  `title` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `likes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dislikes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `show` int(1) NOT NULL DEFAULT '1',
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_views`
--

CREATE TABLE IF NOT EXISTS `item_views` (
  `id` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `uip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `iid` int(255) NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(255) NOT NULL,
  `uip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `cover` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `bcoin` int(255) NOT NULL,
  `gender` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT 'm:male|f:female',
  `followers` longtext COLLATE utf8_unicode_ci NOT NULL,
  `following` longtext COLLATE utf8_unicode_ci NOT NULL,
  `online` int(1) NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `uip`, `username`, `last_name`, `first_name`, `avatar`, `cover`, `bcoin`, `gender`, `followers`, `following`, `online`, `time`, `last_activity`) VALUES
(1, '', 'admin', 'The', 'Admin', 'http://localhost/bonita/data/img/Paris-5.jpg', 'http://localhost/bonita/data/img/Paris-8.jpg', 1000, 'f', '2, 3', '', 0, '', ''),
(2, '', 'miamor', 'West', 'Miamor', 'http://localhost/bonita/data/img/Venice.jpg', 'http://localhost/bonita/data/img/Paris-8.jpg', 1000, 'f', '1, 3', '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `mix`
--

CREATE TABLE IF NOT EXISTS `mix` (
  `id` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `uip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `thumb` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `items` longtext COLLATE utf8_unicode_ci NOT NULL,
  `des` longtext COLLATE utf8_unicode_ci NOT NULL,
  `likes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dislikes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `views` int(255) NOT NULL,
  `fav` longtext COLLATE utf8_unicode_ci NOT NULL,
  `for` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `show` int(1) NOT NULL DEFAULT '1',
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mix`
--

INSERT INTO `mix` (`id`, `uid`, `uip`, `title`, `link`, `thumb`, `items`, `des`, `likes`, `dislikes`, `views`, `fav`, `for`, `show`, `time`) VALUES
(1, 2, '', 'Mix 1', 'mix-1', 'http://cdnc.lystit.com/460/900/r/collections/2015/04/07/1252546-232142144.jpeg', '1,2,3,4,5', 'This is the description<br/>This is the description<br/>This is the descriptionThis is the descriptionThis is the description<br/>This is the description', '1,2,3,4', '5,6', 43, '1,2,3', 'f', 1, ''),
(2, 2, '', 'Mix 2', 'mix-2', 'http://cdnc.lystit.com/460/900/r/collections/2015/04/07/1252546-232142144.jpeg', '1,2,3,4,5', 'This is the description', '1,2,3,4', '5,6', 43, '1,2,3', 'f', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `mix_ratings`
--

CREATE TABLE IF NOT EXISTS `mix_ratings` (
  `id` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `uip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `iid` int(255) NOT NULL,
  `rate` int(1) NOT NULL,
  `title` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `likes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dislikes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `show` int(1) NOT NULL DEFAULT '1',
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_ratings`
--

CREATE TABLE IF NOT EXISTS `service_ratings` (
  `id` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `uip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `iid` int(255) NOT NULL,
  `rate` int(1) NOT NULL,
  `title` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `likes` longblob NOT NULL,
  `show` int(1) NOT NULL DEFAULT '1',
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE IF NOT EXISTS `shops` (
  `id` int(255) NOT NULL,
  `title` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `cover` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `likes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `title`, `link`, `avatar`, `cover`, `website`, `facebook`, `twitter`, `likes`, `time`) VALUES
(1, 'Shop 1', 'shop-1', 'http://localhost/bonita/data/img/Venice.jpg', 'http://localhost/bonita/data/img/Paris-8.jpg', '', '', '', '1, 2, 3', '');

-- --------------------------------------------------------

--
-- Table structure for table `trends`
--

CREATE TABLE IF NOT EXISTS `trends` (
  `id` int(255) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `des` longtext COLLATE utf8_unicode_ci NOT NULL,
  `followers` longtext COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `channels`
--
ALTER TABLE `channels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_book`
--
ALTER TABLE `item_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_ratings`
--
ALTER TABLE `item_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_views`
--
ALTER TABLE `item_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mix`
--
ALTER TABLE `mix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mix_ratings`
--
ALTER TABLE `mix_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_ratings`
--
ALTER TABLE `service_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trends`
--
ALTER TABLE `trends`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `channels`
--
ALTER TABLE `channels`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `item_book`
--
ALTER TABLE `item_book`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_ratings`
--
ALTER TABLE `item_ratings`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_views`
--
ALTER TABLE `item_views`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mix`
--
ALTER TABLE `mix`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mix_ratings`
--
ALTER TABLE `mix_ratings`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `service_ratings`
--
ALTER TABLE `service_ratings`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `trends`
--
ALTER TABLE `trends`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
