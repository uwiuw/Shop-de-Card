--- Alter Table or some update db --- firah_39

ALTER TABLE  `menu` CHANGE  `page_uri`  `page_uri` VARCHAR( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE  `customer` CHANGE  `phone_number`  `phone_number` VARCHAR( 20 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE  `menu` ADD  `ext_url` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `page_uri`;





--- 6 jan 2012 --

ALTER TABLE  `customer` ADD  `account_type` ENUM(  'personal',  'business' ) NOT NULL DEFAULT  'personal' AFTER  `customer_id`;
ALTER TABLE  `customer` ADD  `state` VARCHAR( 100 ) NOT NULL AFTER  `city`;
ALTER TABLE  `customer` ADD  `company_name` VARCHAR( 150 ) NOT NULL AFTER  `customer_last_name`;


-- 9 Jan 2012 ---
DELETE FROM `cherub`.`menu` WHERE `menu`.`menu_id` = 112;
ALTER TABLE  `menu` ADD  `target` TINYINT( 1 ) UNSIGNED NOT NULL COMMENT  '1=_blank, 0=none' AFTER  `page_uri`;

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id_newsletter` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_newsletter`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `total` double NOT NULL,
  `order_date` datetime NOT NULL,
  `delivery_date` datetime NOT NULL,
  `payment_date` datetime NOT NULL,
  PRIMARY KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

