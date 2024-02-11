/*
Navicat MariaDB Data Transfer

Source Server         : ERPNext 12
Source Server Version : 100236
Source Host           : localhost:3306
Source Database       : MISL_ERP

Target Server Type    : MariaDB
Target Server Version : 100236
File Encoding         : 65001

Date: 2022-05-17 07:52:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tabCustomerAddress
-- ----------------------------
DROP TABLE IF EXISTS `tabCustomerAddress`;
CREATE TABLE `tabCustomerAddress` (
  `CusCode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `AddressID` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`CusCode`,`AddressID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
