/*
Navicat MariaDB Data Transfer

Source Server         : ERPNext 12
Source Server Version : 100236
Source Host           : localhost:3306
Source Database       : MISL_ERP

Target Server Type    : MariaDB
Target Server Version : 100236
File Encoding         : 65001

Date: 2022-05-12 08:08:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tabSupplierGroup
-- ----------------------------
DROP TABLE IF EXISTS `tabSupplierGroup`;
CREATE TABLE `tabSupplierGroup` (
  `SupGroupCode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SupGroupName` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isGroup` tinyint(4) DEFAULT NULL,
  `ParentSupGroupID` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `Created_By` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `Modified_By` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `listIndx` tinyint(4) DEFAULT 0,
  `Enabled` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`SupGroupCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
