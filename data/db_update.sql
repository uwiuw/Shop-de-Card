--- Alter Table or some update db --- firah_39

ALTER TABLE  `menu` CHANGE  `page_uri`  `page_uri` VARCHAR( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE  `customer` CHANGE  `phone_number`  `phone_number` VARCHAR( 20 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE  `menu` ADD  `ext_url` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `page_uri`




