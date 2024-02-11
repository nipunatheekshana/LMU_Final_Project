/*
Navicat MariaDB Data Transfer

Source Server         : ERPNext 12
Source Server Version : 100236
Source Host           : localhost:3306
Source Database       : MISL_ERP

Target Server Type    : MariaDB
Target Server Version : 100236
File Encoding         : 65001

Date: 2022-05-12 08:15:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tabAddress
-- ----------------------------
DROP TABLE IF EXISTS `tabAddress`;
CREATE TABLE `tabAddress` (
  `AddressID` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `AddressTitle` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emailAddress` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Phone` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Fax` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Longitude` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `LongLat` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Latitude` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `AddressType` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `AddrelessLine1` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `AddrelessLine2` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CityTown` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Country` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PostalCode` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PreferedBillingAddress` tinyint(1) DEFAULT 0,
  `PreferedShippingAddress` tinyint(1) DEFAULT 0,
  `Created_By` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `Modified_By` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `listIndx` tinyint(1) DEFAULT 0,
  `Enabled` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`AddressID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
