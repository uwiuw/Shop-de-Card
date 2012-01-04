-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 03, 2012 at 06:59 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.6-8ubuntu0ppa5~maverick1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cherub`
--

-- --------------------------------------------------------

--
-- Table structure for table `be_users`
--

CREATE TABLE IF NOT EXISTS `be_users` (
  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(254) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `group` int(10) unsigned DEFAULT NULL,
  `activation_key` varchar(32) DEFAULT NULL,
  `last_visit` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `password` (`password`),
  KEY `group` (`group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `be_users`
--

INSERT INTO `be_users` (`id_user`, `username`, `password`, `email`, `active`, `group`, `activation_key`, `last_visit`, `created`, `modified`) VALUES
(1, 'Administrator', 'a424c7ae34227766c8f477c860fad0a1b98078f2', 'coder5@ymail.com', 1, 2, NULL, '2011-12-27 14:15:55', '2011-12-21 19:54:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `shortdesc` varchar(255) NOT NULL,
  `longdesc` text NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `parentid` int(11) NOT NULL,
  PRIMARY KEY (`name`,`shortdesc`),
  UNIQUE KEY `category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`, `shortdesc`, `longdesc`, `status`, `parentid`) VALUES
(102, 'Digital Downloads', 'Short Description', 'Long Description', 'active', 1),
(101, 'Movies, Music & Games', 'Short Descriptions', 'Long Description', 'active', 1),
(99, 'Books', 'Here you can write a short description of books category.', 'Here you can write a long description of books category.', 'active', 1),
(1, 'Webshop', '', '', 'active', 1),
(107, 'Cherub_products', '', '', 'active', 105),
(105, 'Defense', '', '', 'active', 1),
(100, 'CD', 'Here you can write a short description of this category.', 'Here you can write a long description of this category.', 'active', 1),
(103, 'Computers & Office', 'Short Description', 'Long Description', 'active', 1),
(104, 'Electronics', 'Short Description', 'Long Description', 'active', 1),
(109, 'pengaman', 'pengaman', '', 'active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `checkout_forms`
--

CREATE TABLE IF NOT EXISTS `checkout_forms` (
  `checkout_forms_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `type` varchar(64) NOT NULL DEFAULT '',
  `mandatory` varchar(1) NOT NULL DEFAULT '0',
  `display_log` char(1) NOT NULL DEFAULT '0',
  `default` varchar(128) NOT NULL DEFAULT '0',
  `active` varchar(1) NOT NULL DEFAULT '1',
  `checkout_order` int(10) unsigned NOT NULL DEFAULT '0',
  `unique_name` varchar(255) NOT NULL DEFAULT '',
  `options` varchar(255) NOT NULL DEFAULT '',
  `checkout_set` varchar(64) NOT NULL DEFAULT '0',
  PRIMARY KEY (`name`,`type`,`unique_name`),
  UNIQUE KEY `checkout_forms_id` (`checkout_forms_id`),
  KEY `checkout_order` (`checkout_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `checkout_forms`
--

INSERT INTO `checkout_forms` (`checkout_forms_id`, `name`, `type`, `mandatory`, `display_log`, `default`, `active`, `checkout_order`, `unique_name`, `options`, `checkout_set`) VALUES
(1, 'Your billing/contact details', 'heading', '0', '0', '', '1', 1, '', '', '0'),
(2, 'First Name', 'text', '1', '1', '', '1', 2, 'billingfirstname', '', '0'),
(3, 'Last Name', 'text', '1', '1', '', '1', 3, 'billinglastname', '', '0'),
(4, 'Address', 'address', '1', '0', '', '1', 4, 'billingaddress', '', '0'),
(5, 'City', 'city', '1', '0', '', '1', 5, 'billingcity', '', '0'),
(6, 'State', 'text', '0', '0', '', '1', 6, 'billingstate', '', '0'),
(7, 'Country', 'country', '1', '0', '', '1', 7, 'billingcountry', '', '0'),
(8, 'Postal Code', 'text', '0', '0', '', '1', 8, 'billingpostcode', '', '0'),
(9, 'Email', 'email', '1', '1', '', '1', 9, 'billingemail', '', '0'),
(10, 'Shipping Address', 'heading', '0', '0', '', '1', 10, 'delivertoafriend', '', '0'),
(11, 'First Name', 'text', '0', '0', '', '1', 11, 'shippingfirstname', '', '0'),
(12, 'Last Name', 'text', '0', '0', '', '1', 12, 'shippinglastname', '', '0'),
(13, 'Address', 'address', '0', '0', '', '1', 13, 'shippingaddress', '', '0'),
(14, 'City', 'city', '0', '0', '', '1', 14, 'shippingcity', '', '0'),
(15, 'State', 'text', '0', '0', '', '1', 15, 'shippingstate', '', '0'),
(16, 'Country', 'delivery_country', '0', '0', '', '1', 16, 'shippingcountry', '', '0'),
(17, 'Postal Code', 'text', '0', '0', '', '1', 17, 'shippingpostcode', '', '0'),
(18, 'Phone', 'text', '1', '0', '', '1', 8, 'billingphone', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(50) NOT NULL,
  `customer_first_name` varchar(50) NOT NULL,
  `customer_last_name` varchar(50) NOT NULL,
  `phone_number` int(10) unsigned NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `post_code` int(10) unsigned NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `password`, `customer_first_name`, `customer_last_name`, `phone_number`, `email`, `address`, `city`, `post_code`) VALUES
(76, 'da39a3ee5e6b4b0d', 'haidar', 'mar''ie', 4294967295, 'coder5@ahamail.co.id', 'jl. raden saleh 1 no 3a', 'bandung', 40291),
(77, 'da39a3ee5e6b4b0d', 'doni', 'irawans', 182313, 'coders@ahamail.co.id', 'jl. ters sindang barang no.14', 'bandung', 40291),
(79, 'a1190e457b064c0c', 'haidar', 'mar''ie', 4294967295, 'coder5@ymail.com', 'jl. ters sindang barang no .14', 'bandung', 40291),
(80, '', 'Danny', 'Test', 3082098, 'coder5@aha.co.id', 'jl. ter sindang barang no.14', 'bandung', 209831),
(81, '', 'roni', 'cod', 12312313, 'darmawan.soad@yahoo.com', 'jl. ter sindang barang no.14', 'bandung', 23423424);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=default, 0=not_show',
  `extension` varchar(20) NOT NULL,
  `size` varchar(40) NOT NULL,
  `type` varchar(20) NOT NULL,
  `url` varchar(255) NOT NULL,
  `medium_url` varchar(255) NOT NULL,
  `thumbnail_url` varchar(255) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`image_id`, `product_id`, `name`, `default`, `extension`, `size`, `type`, `url`, `medium_url`, `thumbnail_url`) VALUES
(8, 111, 'fathien.jpg', 0, '.jpg', '39846', 'image/jpeg', '/assets/product/', '', '/assets/product_thumb/'),
(15, 123, 'book1.jpg', 0, '.jpg', '37940', 'image/jpeg', '/assets/product/', '', '/assets/product_thumb/'),
(10, 115, 'lion.jpg', 0, '.jpg', '54654', 'image/jpeg', '/assets/product/', '', '/assets/product_thumb/'),
(11, 117, 'blank_tshirt.png', 0, '.png', '113928', 'image/png', '/assets/product/', '', '/assets/product_thumb/'),
(12, 117, 'DigitaLink_Blank_T-Shirt.png', 0, '.png', '182123', 'image/png', '/assets/product/', '', '/assets/product_thumb/'),
(13, 118, 'l_g4d8454e1a45dd.jpg', 0, '.jpg', '4092', 'image/jpeg', '/assets/product/', '', '/assets/product_thumb/'),
(14, 122, 'Navicat.png', 0, '.png', '30745', 'image/png', '/assets/product/', '', '/assets/product_thumb/'),
(16, 123, 'books1.jpg', 0, '.jpg', '77984', 'image/jpeg', '/assets/product/', '', '/assets/product_thumb/'),
(17, 124, 'buku-tamu.gif', 0, '.gif', '29074', 'image/gif', '/assets/product/', '', '/assets/product_thumb/'),
(18, 0, '5099.jpg', 0, '.jpg', '5541', 'image/jpeg', '/assets/product/', '', '/assets/product_thumb/'),
(19, 0, '5099.jpg', 0, '.jpg', '5541', 'image/jpeg', '/assets/product/', '', '/assets/product_thumb/');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `shortdesc` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `page_uri` varchar(60) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `parentid` int(10) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `page_id` (`page_uri`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=132 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `name`, `shortdesc`, `content`, `page_uri`, `status`, `parentid`, `order`) VALUES
(107, 'Webshop', '', '', '0', 'active', 0, 20),
(112, 'Home', '', '', 'webshop', 'active', 107, 10),
(113, 'About', '', '', 'about_us', 'inactive', 107, 20),
(114, 'Returns Policy', 'Returns Policy', '', 'return_policy', 'active', 107, 30),
(115, 'My Account', '', '', 'productinformation', 'inactive', 114, 10),
(116, 'Gift card', '', '', 'gift_card', 'inactive', 114, 20),
(117, 'Shipping', '', '', 'shipping', 'active', 107, 30),
(118, 'Term & Condition', 'Term & Condition', '', 'payment.html', 'active', 107, 40),
(120, 'Return Policy', '', '', '0', 'active', 107, 60),
(121, 'Products', '', '', '0', 'inactive', 107, 25),
(122, 'News', '', '', 'news', 'active', 107, 50),
(124, 'Contact us', '', '', 'contact_us', 'active', 107, 70),
(125, 'Go to checkout', 'shopping cart', '', 'checkout', 'active', 107, 80),
(131, 'payment', 'payment', '', 'payment', 'active', 107, 122);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `total` double NOT NULL,
  `order_date` datetime NOT NULL,
  `delivery_date` datetime NOT NULL,
  `payment_date` datetime NOT NULL,
  PRIMARY KEY (`customer_id`,`total`,`delivery_date`,`payment_date`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `customer_id`, `total`, `order_date`, `delivery_date`, `payment_date`) VALUES
(60, 80, 268, '2011-12-28 12:25:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(61, 81, 686, '2011-12-28 14:12:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE IF NOT EXISTS `order_item` (
  `order_item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(84, 60, 77, 1, 268.00),
(85, 61, 97, 1, 268.00),
(86, 61, 75, 1, 418.00);

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `path` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`page_id`, `name`, `keywords`, `description`, `path`, `content`, `status`, `category_id`) VALUES
(25, 'Web shops', '', '', 'webshop', '<h1>Your heading here.</h1>\n<h2>Content from weshop page in the back-end</h2>\n\n<h1>Your heading here.</h1>\n<h2>Content from weshop page in the back-end</h2>', 'active', 0),
(26, 'About us', '', '', 'about_us', '<h2>About us</h2>\nPellentesque habitant morbi trist', 'active', 0),
(27, 'Product information', '', '', 'productinformation', '<h2>Product information</h2>\nThunder, thundeercats! Thundercats!', 'active', 0),
(28, 'Shopping guide', '', '', 'shopping_guide', '<h1>Shopping guide</h1>\nTop Cat! The most effectual.', 'active', 0),
(29, 'Gift card', '', '', 'gift_card', '<h2>Gift card</h2>\nLorem ipsum dolor.', 'active', 0),
(30, 'Shipping', '', '', 'shipping', '<h2>Shipping information</h2><Lorem ipsum dolor sit ameerat', 'active', 0),
(33, 'News', '', '', 'news', '<h2>News</h2>\nUlysses, Ulyssese.', 'active', 0),
(35, 'Contact us', 'contact_us', 'contact_us', 'contact_us', 'Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us Contact Us v', 'active', 0),
(38, 'Go to checkout', '', '', 'checkout', '', 'active', 0),
(40, 'payment', 'payment', 'payment', 'payment', 'payment payment payment payment payment payment payment payment payment ', 'active', 0),
(42, 'haidar', 'haidar', 'haidar', 'haidar', 'haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar haidar ', 'active', 0),
(43, 'Return Policy', 'Return Policy', 'Return Policy', 'return_policy', 'Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy Return Policy v', 'active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(3) NOT NULL,
  `name` varchar(300) NOT NULL,
  `shortdesc` varchar(255) NOT NULL,
  `longdesc` text NOT NULL,
  `product_order` int(11) NOT NULL,
  `class` varchar(255) NOT NULL,
  `grouping` varchar(16) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `featured` enum('none','front','webshop') NOT NULL,
  `other_feature` enum('none','most sold','new product') NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `stock` int(4) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`category_id`,`name`,`price`,`stock`,`product_id`),
  UNIQUE KEY `product_id` (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=127 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `category_id`, `name`, `shortdesc`, `longdesc`, `product_order`, `class`, `grouping`, `status`, `featured`, `other_feature`, `image`, `thumbnail`, `price`, `stock`, `create_date`) VALUES
(71, 102, 'Shortland2', '', '', 0, '', '', 'active', 'webshop', 'none', 'assets/images/digital_downloads/242x440_5.jpg', 'assets/images/digital_downloads/thumbnails/114x207_5.jpg', 268, 0, '2011-12-22 06:21:43'),
(72, 102, 'D2301-01', '', '', 0, '', '', 'active', 'webshop', 'new product', 'assets/images/computers_&_office/242x440_8.jpg', 'assets/images/computers_&_office/thumbnails/114x207_8.jpg', 268, 0, '2011-12-22 06:21:43'),
(73, 102, 'Friendship', '', '', 0, '', '', 'active', 'webshop', 'none', 'assets/images/movies,_music_&_games/242x440_8.jpg', 'assets/images/movies,_music_&_games/thumbnails/114x207_8.jpg', 198, 0, '2011-12-22 06:21:43'),
(74, 101, 'Placerat', '', '', 0, '', '', 'active', 'webshop', 'new product', 'assets/images/movies,_music_&_games/242x440_9.jpg', 'assets/images/movies,_music_&_games/thumbnails/114x207_9.jpg', 268, 0, '2011-12-22 06:21:43'),
(75, 101, 'Elementum', '', '', 0, '', '', 'active', 'webshop', 'most sold', 'assets/images/movies,_music_&_games/242x440_2.jpg', 'assets/images/movies,_music_&_games/thumbnails/114x207_2.jpg', 418, 0, '2011-12-22 06:21:43'),
(76, 101, 'Porttitor', '', '', 0, '', '', 'active', 'webshop', '', 'assets/images/movies,_music_&_games/242x440_10.jpg', 'assets/images/movies,_music_&_games/thumbnails/114x207_10.jpg', 268, 0, '2011-12-22 06:21:43'),
(77, 103, 'Rerefe', '', '', 0, '', '', 'active', 'webshop', 'most sold', 'assets/images/computers_&_office/242x440_17.jpg', 'assets/images/computers_&_office/thumbnails/114x207_17.jpg', 268, 0, '2011-12-22 06:21:43'),
(78, 103, 'Rre resettr', '', '', 0, '', '', 'active', 'webshop', 'most sold', 'assets/images/computers_&_office/242x440_11.jpg', 'assets/images/computers_&_office/thumbnails/114x207_11.jpg', 268, 0, '2011-12-22 06:21:43'),
(79, 103, 'Pruyyuty', '', '', 0, '', '', 'active', 'webshop', 'new product', 'assets/images/computers_&_office/242x440_12.jpg', 'assets/images/computers_&_office/thumbnails/114x207_12.jpg', 268, 0, '2011-12-22 06:21:43'),
(82, 99, 'Gfwee', '', '', 0, '', '', 'active', 'webshop', '', 'assets/images/books/242x440_14.jpg', 'assets/images/books/thumbnails/114x207_14.jpg', 268, 0, '2011-12-22 06:21:43'),
(84, 99, 'Sjuer', '', '', 0, '', '', 'active', 'webshop', '', 'assets/images/books/242x440_16.jpg', 'assets/images/books/thumbnails/114x207_16.jpg', 268, 0, '2011-12-22 06:21:43'),
(85, 99, 'Isbjorn', '', '', 0, '', '', 'active', 'webshop', 'most sold', 'assets/images/books/242x440_16.jpg', 'assets/images/books/thumbnails/114x207_16.jpg', 498, 0, '2011-12-22 06:21:43'),
(89, 99, 'Medite eret', '', '', 0, '', '', 'active', 'webshop', 'most sold', 'assets/images/books/242x440_17.jpg', 'assets/images/books/thumbnails/114x207_17.jpg', 268, 0, '2011-12-22 06:21:43'),
(97, 104, 'Oyenter', '', '', 0, '', '', 'active', 'webshop', 'most sold', 'assets/images/electronics/242x440_7.jpg', 'assets/images/electronics/thumbnails/114x207_7.jpg', 268, 0, '2011-12-22 06:21:43'),
(103, 104, 'Ville hjempener', '', '', 0, '', '', 'active', 'webshop', 'most sold', 'assets/images/movies,_music_&_games/242x440_10.jpg', 'assets/images/movies,_music_&_games/thumbnails/114x207_10.jpg', 418, 0, '2011-12-22 06:21:43'),
(104, 104, 'Den here ire ierrr tere', '', '', 0, '', '', 'active', 'webshop', 'new product', 'assets/images/movies,_music_&_games/242x440_4.jpg', 'assets/images/movies,_music_&_games/thumbnails/114x207_4.jpg', 418, 0, '2011-12-22 06:21:43'),
(105, 100, 'Alvieun', '', '', 0, '', '', 'active', 'webshop', 'new product', 'assets/images/movies,_music_&_games/242x440_7.jpg', 'assets/images/movies,_music_&_games/thumbnails/114x207_7.jpg', 418, 0, '2011-12-22 06:21:43'),
(106, 100, 'Truatu', '', '', 0, '', '', 'active', 'webshop', 'most sold', 'assets/images/movies,_music_&_games/242x440_2.jpg', 'assets/images/movies,_music_&_games/thumbnails/114x207_2.jpg', 268, 0, '2011-12-22 06:21:43'),
(118, 0, '1', '', '', 0, '', '', 'active', 'none', 'none', '', '', 0, 0, '2012-01-02 08:42:33'),
(123, 99, 'books', 'books books books books books ', 'books books books books ', 0, 'books', 'books', 'active', 'front', 'none', '', '', 99, 0, '2012-01-03 11:07:19'),
(108, 102, 'product2', 'product2', 'product2', 1, '', '', 'active', 'none', 'none', '', '', 90, 0, '2011-12-22 07:03:13'),
(122, 1, 'navicat', 'navicat', 'navicat', 0, '', '', 'active', 'none', 'none', '', '', 111, 0, '2012-01-02 13:11:57'),
(121, 0, '1', '', '', 0, '', '', 'active', 'none', 'none', '', '', 0, 0, '2012-01-02 08:46:56'),
(120, 0, '1', '', '', 0, '', '', 'active', 'none', 'none', '', '', 0, 0, '2012-01-02 08:45:27'),
(119, 0, '1', '', '', 0, '', '', 'active', 'none', 'none', '', '', 0, 0, '2012-01-02 08:44:45'),
(117, 102, 'Shirts haidar testing this', 'Shirts haidar testing this', 'haidar testing this', 0, '', '', 'active', 'none', 'none', '', '', 313, 0, '2012-01-02 04:04:41'),
(124, 99, 'Buku 2', 'Buku 2 Buku 2 Buku 2 Buku 2 Buku 2 Buku 2', 'Buku 2 Buku 2Buku 2 Buku 2Buku 2 Buku 2Buku 2 Buku 2Buku 2 Buku 2Buku 2 Buku 2Buku 2 Buku 2', 0, '', 'books', 'active', 'none', 'none', '', '', 44, 0, '2012-01-03 11:09:01'),
(125, 0, '1', '', '', 0, '', '', 'active', 'none', 'none', '', '', 0, 0, '2012-01-03 11:10:15'),
(126, 102, 'Cherub Defense', 'Cherub Defense Cherub Defense Cherub Defense Cherub Defense ', 'Cherub Defense Cherub Defense Cherub Defense ', 0, 'defense', 'defense', 'active', 'none', 'none', '', '', 55, 0, '2012-01-03 11:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_logs`
--

CREATE TABLE IF NOT EXISTS `purchase_logs` (
  `purchase_logs_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `totalprice` decimal(11,2) NOT NULL DEFAULT '0.00',
  `statusno` smallint(6) NOT NULL DEFAULT '0',
  `sessionid` varchar(255) NOT NULL DEFAULT '',
  `transactid` varchar(255) NOT NULL DEFAULT '',
  `authcode` varchar(255) NOT NULL DEFAULT '',
  `processed` bigint(20) unsigned NOT NULL DEFAULT '1',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL DEFAULT '',
  `gateway` varchar(64) NOT NULL DEFAULT '',
  `billing_country` char(6) NOT NULL DEFAULT '',
  `shipping_country` char(6) NOT NULL DEFAULT '',
  `base_shipping` decimal(11,2) NOT NULL DEFAULT '0.00',
  `email_sent` char(1) NOT NULL DEFAULT '0',
  `stock_adjusted` char(1) NOT NULL DEFAULT '0',
  `discount_value` decimal(11,2) NOT NULL DEFAULT '0.00',
  `discount_data` text,
  `track_id` varchar(50) NOT NULL DEFAULT '',
  `billing_region` char(6) NOT NULL DEFAULT '',
  `shipping_region` char(6) NOT NULL DEFAULT '',
  `find_us` varchar(255) NOT NULL DEFAULT '',
  `engravetext` varchar(255) DEFAULT '',
  `shipping_method` varchar(64) DEFAULT NULL,
  `shipping_option` varchar(128) DEFAULT NULL,
  `affiliate_id` varchar(32) DEFAULT NULL,
  `plugin_version` varchar(32) DEFAULT NULL,
  `notes` text,
  `wpec_taxes_total` decimal(11,2) DEFAULT NULL,
  `wpec_taxes_rate` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`totalprice`,`track_id`,`user_id`,`authcode`,`statusno`),
  UNIQUE KEY `purchase_logs_id` (`purchase_logs_id`),
  KEY `gateway` (`gateway`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `users_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_name` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_name`,`user_email`),
  UNIQUE KEY `users_id` (`users_id`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
