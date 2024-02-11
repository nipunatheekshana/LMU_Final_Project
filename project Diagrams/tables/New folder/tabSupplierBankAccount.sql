/*
Navicat MariaDB Data Transfer

Source Server         : ERPNext 12
Source Server Version : 100236
Source Host           : localhost:3306
Source Database       : MISL_ERP

Target Server Type    : MariaDB
Target Server Version : 100236
File Encoding         : 65001

Date: 2022-05-17 07:52:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tabSupplierBankAccount
-- ----------------------------
DROP TABLE IF EXISTS `tabSupplierBankAccount`;
CREATE TABLE `tabSupplierBankAccount` (
  `SupBankID` int(11) NOT NULL,
  `SupID` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SupBankTitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `BankAccNo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `AccountName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `BankCountry` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `Bank` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Branch` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `BranchAddress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SwiftCode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Created_By` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `Modified_By` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `listIndx` tinyint(4) DEFAULT 0,
  `Enabled` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`SupID`,`SupBankID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
