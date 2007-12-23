-- phpMyAdmin SQL Dump
-- version 2.7.0-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jun 20, 2006 at 01:35 PM
-- Server version: 5.0.18
-- PHP Version: 5.1.1
-- 
-- Database: `smart`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `xoops_smartshop_attribut_option`
-- 

DROP TABLE IF EXISTS `xoops_smartshop_attribut_option`;
CREATE TABLE `xoops_smartshop_attribut_option` (
  `optionid` int(11) NOT NULL auto_increment,
  `attrinbutid` int(11) NOT NULL default '0',
  `caption` varchar(255) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`optionid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='SmartShop by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `xoops_smartshop_attribut_option`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `xoops_smartshop_category`
-- 

DROP TABLE IF EXISTS `xoops_smartshop_category`;
CREATE TABLE `xoops_smartshop_category` (
  `categoryid` int(11) NOT NULL auto_increment,
  `parentid` int(11) NOT NULL default '0',
  `name` varchar(255) collate latin1_general_ci NOT NULL default '',
  `description` text collate latin1_general_ci NOT NULL,
  `image` varchar(255) collate latin1_general_ci NOT NULL default '',
  `dohtml` tinyint(1) NOT NULL default '1',
  `dosmiley` tinyint(1) NOT NULL default '1',
  `doxcode` tinyint(1) NOT NULL default '1',
  `doimage` tinyint(1) NOT NULL default '1',
  `dobr` tinyint(1) NOT NULL default '1',
  `meta_keywords` text collate latin1_general_ci NOT NULL,
  `meta_description` text collate latin1_general_ci NOT NULL,
  `short_url` varchar(255) collate latin1_general_ci NOT NULL,
  `hasItem` tinyint(4) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY  (`categoryid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='SmartShop by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `xoops_smartshop_category`
-- 

INSERT INTO `xoops_smartshop_category` VALUES (1, 0, 'Jeux Vidéos', 'Cat&eacute;gorie contenant des jeux vid&eacute;o', '-1', 1, 1, 1, 1, 1, 'Jeux, vidéo, description, catégorie', 'description de la catégorie Jeux vidéo', 'jeux-vid-o', 1, 0);
INSERT INTO `xoops_smartshop_category` VALUES (3, 0, 'Category 2', 'Description category 2', '', 1, 1, 1, 1, 1, '', '', '', 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `xoops_smartshop_category_attribut`
-- 

DROP TABLE IF EXISTS `xoops_smartshop_category_attribut`;
CREATE TABLE `xoops_smartshop_category_attribut` (
  `attributid` int(11) NOT NULL auto_increment,
  `parentid` int(11) NOT NULL default '0',
  `name` varchar(100) collate latin1_general_ci NOT NULL default '',
  `description` text collate latin1_general_ci NOT NULL,
  `att_type` varchar(100) collate latin1_general_ci NOT NULL,
  `required` tinyint(1) NOT NULL default '1',
  `att_default` varchar(255) collate latin1_general_ci NOT NULL,
  `sortable` tinyint(1) NOT NULL default '1',
  `searchable` tinyint(1) NOT NULL default '1',
  `display` tinyint(1) NOT NULL default '1',
  `caption` varchar(255) collate latin1_general_ci NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY  (`attributid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='SmartShop by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `xoops_smartshop_category_attribut`
-- 

INSERT INTO `xoops_smartshop_category_attribut` VALUES (4, 1, 'console', 'Nom de la console de ce jeu', 'text', 0, 'Nintendo', 1, 1, 1, 'Console', 0);
INSERT INTO `xoops_smartshop_category_attribut` VALUES (5, 1, 'annee', 'Année de publication de ce jeux', 'text', 0, '', 0, 1, 1, 'Année de publication', 0);
INSERT INTO `xoops_smartshop_category_attribut` VALUES (6, 1, 'concepteur', 'Concepteur du jeux', 'text', 0, '', 0, 1, 1, 'Concepteur', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `xoops_smartshop_item`
-- 

DROP TABLE IF EXISTS `xoops_smartshop_item`;
CREATE TABLE `xoops_smartshop_item` (
  `itemid` int(11) NOT NULL auto_increment,
  `parentid` int(11) NOT NULL default '0',
  `name` varchar(100) collate latin1_general_ci NOT NULL default '',
  `description` text collate latin1_general_ci NOT NULL,
  `image` varchar(255) collate latin1_general_ci NOT NULL default '',
  `price` int(11) NOT NULL default '0',
  `currency` varchar(100) collate latin1_general_ci NOT NULL default '',
  `uid` int(11) NOT NULL default '0',
  `date` int(11) NOT NULL default '0',
  `counter` int(11) NOT NULL default '0',
  `dohtml` tinyint(1) NOT NULL default '1',
  `dosmiley` tinyint(1) NOT NULL default '1',
  `doxcode` tinyint(1) NOT NULL default '1',
  `doimage` tinyint(1) NOT NULL default '1',
  `dobr` tinyint(1) NOT NULL default '1',
  `meta_keywords` text collate latin1_general_ci NOT NULL,
  `meta_description` text collate latin1_general_ci NOT NULL,
  `short_url` varchar(255) collate latin1_general_ci NOT NULL,
  `status` int(1) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY  (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='SmartShop by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `xoops_smartshop_item`
-- 

INSERT INTO `xoops_smartshop_item` VALUES (3, 1, 'Zelda', 'Zelda est un jeu qui, si je me souvient bien, &eacute;tait vachement cool dans le temps !', '', 0, '', 1, 1149553800, 0, 1, 1, 1, 1, 1, 'Item', '', 'e3e', 2, 0);
INSERT INTO `xoops_smartshop_item` VALUES (4, 3, 'Item 2', 'Description item 2', '', 0, '', 1, 1149554400, 0, 1, 1, 1, 1, 1, 'eeded', '', 'eeded', 2, 0);
INSERT INTO `xoops_smartshop_item` VALUES (5, 1, 'Mario Bros 1', 'description Mario Bros 1', '', 0, '', 1, 1150824000, 0, 1, 1, 1, 1, 1, 'Mario, Bros', '', 'mario-bros-1', 2, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `xoops_smartshop_item_attribut`
-- 

DROP TABLE IF EXISTS `xoops_smartshop_item_attribut`;
CREATE TABLE `xoops_smartshop_item_attribut` (
  `item_attributid` int(11) NOT NULL auto_increment,
  `attributid` int(11) NOT NULL default '0',
  `itemid` int(11) NOT NULL default '0',
  `value` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`item_attributid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='SmartShop by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `xoops_smartshop_item_attribut`
-- 

INSERT INTO `xoops_smartshop_item_attribut` VALUES (1, 4, 3, 'Sega');
INSERT INTO `xoops_smartshop_item_attribut` VALUES (2, 5, 3, '1979');
INSERT INTO `xoops_smartshop_item_attribut` VALUES (6, 4, 5, 'Nintendo');
INSERT INTO `xoops_smartshop_item_attribut` VALUES (5, 6, 3, 'Ubisoft');
INSERT INTO `xoops_smartshop_item_attribut` VALUES (7, 5, 5, '1988');
INSERT INTO `xoops_smartshop_item_attribut` VALUES (8, 6, 5, 'Nintendo');

-- --------------------------------------------------------

-- 
-- Table structure for table `xoops_smartshop_meta`
-- 

DROP TABLE IF EXISTS `xoops_smartshop_meta`;
CREATE TABLE `xoops_smartshop_meta` (
  `metakey` varchar(50) collate latin1_general_ci NOT NULL default '',
  `metavalue` varchar(255) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`metakey`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='SmartShop by The SmartFactory <www.smartfactory.ca>';

-- 
-- Dumping data for table `xoops_smartshop_meta`
-- 

INSERT INTO `xoops_smartshop_meta` VALUES ('version', '1.0');
