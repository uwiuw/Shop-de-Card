-- phpMyAdmin SQL Dump
-- version 3.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 21, 2011 at 06:58 PM
-- Server version: 5.1.54
-- PHP Version: 5.3.5-1ubuntu7.4

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_cat` int(3) NOT NULL,
  `title` varchar(300) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `stock` int(4) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_cat`,`title`,`price`,`stock`,`product_id`),
  UNIQUE KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
