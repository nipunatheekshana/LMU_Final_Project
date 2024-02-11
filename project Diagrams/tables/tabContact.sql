/*
Navicat MariaDB Data Transfer

Source Server         : ERPNext 12
Source Server Version : 100236
Source Host           : localhost:3306
Source Database       : MISL_ERP

Target Server Type    : MariaDB
Target Server Version : 100236
File Encoding         : 65001

Date: 2022-05-12 08:07:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tabContact
-- ----------------------------
DROP TABLE IF EXISTS `tabContact`;
CREATE TABLE `tabContact` (
  `ContactID` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FirstName` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MiddleName` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LastName` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Salutation` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Designation` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Gender` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PrimaryAddress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Created_By` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `Modified_By` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `listIndx` tinyint(4) DEFAULT 0,
  `Enabled` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`ContactID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
