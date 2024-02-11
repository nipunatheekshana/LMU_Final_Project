/*
Navicat MariaDB Data Transfer

Source Server         : ERPNext 12
Source Server Version : 100236
Source Host           : localhost:3306
Source Database       : MISL_ERP

Target Server Type    : MariaDB
Target Server Version : 100236
File Encoding         : 65001

Date: 2022-05-12 08:08:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tabCustomer
-- ----------------------------
DROP TABLE IF EXISTS `tabCustomer`;
CREATE TABLE `tabCustomer` (
  `CusCode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CusName` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CusRegNo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CusType` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CusGroup` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CusCountry` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `BillingCurrency` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DefltLanguage` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PrimaryContactPerson` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `PrimaryContactAddress` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `MobileNo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emailAddress` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `LicenceNo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PriceList` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PrimaryBankAccount` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Created_By` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `Modified_By` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `listIndx` tinyint(4) DEFAULT 0,
  `Enabled` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`CusCode`,`emailAddress`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
