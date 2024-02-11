/*
Navicat MariaDB Data Transfer

Source Server         : ERPNext 12
Source Server Version : 100236
Source Host           : localhost:3306
Source Database       : MISL_ERP

Target Server Type    : MariaDB
Target Server Version : 100236
File Encoding         : 65001

Date: 2022-05-17 07:53:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tabBank
-- ----------------------------
DROP TABLE IF EXISTS `tabBank`;
CREATE TABLE `tabBank` (
  `BankID` int(10) NOT NULL,
  `bank_name` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `BankType` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Created_By` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `Modified_By` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `listIndx` tinyint(4) DEFAULT 0,
  `Enabled` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`BankID`),
  UNIQUE KEY `bank_name` (`bank_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED;
