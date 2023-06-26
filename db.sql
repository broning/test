SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DATE` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `FIO` varchar(255) NOT NULL,
  `PRICE` float NOT NULL,
  `ITEMS` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `order_status`;
CREATE TABLE `order_status` (
  `ORDER_ID` int(11) NOT NULL,
  `DATE` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `OPERATION` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `STATUS` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `PICTURE` varchar(255) NOT NULL,
  `SORT` int(11) NOT NULL,
  `PRICE` float NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `product` (`ID`, `NAME`, `DESCRIPTION`, `PICTURE`, `SORT`, `PRICE`) VALUES
(1,	'Apple iPhone 14 Pro Max',	'Смартфон Apple iPhone 14 Pro Max Dual SIM 128 ГБ, золотой',	'',	100,	100000),
(2,	'Ноутбук Apple 13.3, Apple M1',	'13.3\" Ноутбук Apple 13.3, Apple M1 (3.2 ГГц), RAM 8 ГБ, SSD, Apple M1, macOS, (MGN93RU/A)',	'',	200,	72000),
(3,	'Apple watch Series 8',	'Умные часы Apple watch Series 8 GPS 41mm, темная ночь, S/M',	'',	300,	34000);