CREATE TABLE `smartshop_category` (
  `categoryid` int(11) NOT NULL auto_increment,
  `parentid` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `description` TEXT NOT NULL,
  `weight` int(11) NOT NULL,
  `image` varchar(255) NOT NULL default '',
  `dohtml` tinyint(1) NOT NULL default '1',
  `dosmiley` tinyint(1) NOT NULL default '1',
  `doxcode` tinyint(1) NOT NULL default '1',
  `doimage` tinyint(1) NOT NULL default '1',
  `dobr` tinyint(1) NOT NULL default '1',
  `meta_keywords` TEXT NOT NULL,
  `meta_description` TEXT NOT NULL,
  `short_url` VARCHAR(255) NOT NULL,
   `hasitem` tinyint(1) NOT NULL default '1',
   `searchable` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`categoryid`)
) TYPE=MyISAM COMMENT='SmartShop by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;


CREATE TABLE `smartshop_item` (
  `itemid` int(11) NOT NULL auto_increment,
  `parentid` int(11) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL default '',
  `price` float NOT NULL default '0',
  `currency` varchar(100) NOT NULL default '',
  `uid` int(11) NOT NULL default '0',
  `date` int(11) NOT NULL default '0',
  `no_exp` tinyint(1) NOT NULL default '0',
  `exp_date` int(11) NOT NULL default '0',
  `counter` int(11) NOT NULL default '0',
  `status` int(1) NOT NULL default '-1',
  `mail_status` int(1) NOT NULL default '-1',
  `weight` int(11) NOT NULL default '0',
  `dohtml` tinyint(1) NOT NULL default '1',
  `dosmiley` tinyint(1) NOT NULL default '1',
  `doxcode` tinyint(1) NOT NULL default '1',
  `doimage` tinyint(1) NOT NULL default '1',
  `dobr` tinyint(1) NOT NULL default '1',
  `meta_keywords` TEXT NOT NULL,
  `meta_description` TEXT NOT NULL,
  `short_url` VARCHAR(255) NOT NULL,
  PRIMARY KEY  (`itemid`)
) TYPE=MyISAM COMMENT='SmartShop by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartshop_item_attribut` (
  `item_attributid` int(11) NOT NULL auto_increment,
  `attributid` int(11) NOT NULL default '0',
  `itemid` int(11) NOT NULL default '0',
  `value` TEXT NOT NULL,
  PRIMARY KEY  (`item_attributid`)
) TYPE=MyISAM COMMENT='SmartShop by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;


CREATE TABLE `smartshop_category_attribut` (
  `attributid` int(11) NOT NULL auto_increment,
  `parentid` int(11) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `caption` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `att_type` varchar(100) NOT NULL default '',
  `dependent_attributid` int(11) NOT NULL default '0',
  `options` text NOT NULL,
  `required` tinyint(1) NOT NULL default '1',
  `att_default` varchar(255) NOT NULL default '',
  `sortable` tinyint(1) NOT NULL default '1',
  `searchable` tinyint(1) NOT NULL default '1',
  `display` tinyint(1) NOT NULL default '1',
  `summarydisp` tinyint(1) NOT NULL default '0',
  `custom_rendering` text NOT NULL,
  `weight` int(11) NOT NULL default '0',
  PRIMARY KEY  (`attributid`)
) TYPE=MyISAM COMMENT='SmartShop by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartshop_attribut_option` (
  `optionid` int(11) NOT NULL auto_increment,
  `attributid` int(11) NOT NULL default '0',
  `linked_attribut_option_id` int(11) NOT NULL default '0',
  `caption` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`optionid`)
) TYPE=MyISAM COMMENT='SmartShop by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartshop_transaction` (
  `transactionid` int(11) NOT NULL auto_increment,
  `tran_date` int(11) NOT NULL default '0',
  `tran_status` int(1) NOT NULL default '-1',
  `itemid` int(11) NOT NULL default '0',
  `tran_uid` int(11) NOT NULL default '0',
  `price` float NOT NULL default '0',
  `currency` varchar(100) NOT NULL default '',
  `quantity` int(11) NOT NULL default '0',
  PRIMARY KEY  (`transactionid`)
) TYPE=MyISAM COMMENT='SmartShop by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;


CREATE TABLE `smartshop_meta` (
  `metakey` varchar(50) NOT NULL default '',
  `metavalue` varchar(255) NOT NULL default '',
  `last_check` int(11) NOT NULL default '0',
  PRIMARY KEY (`metakey`)
) TYPE=MyISAM COMMENT='SmartShop by The SmartFactory <www.smartfactory.ca>' ;

INSERT INTO `smartshop_meta` VALUES ('version','1.0',0);
