/*
Navicat MariaDB Data Transfer

Source Server         : ERPNext 12
Source Server Version : 100236
Source Host           : localhost:3306
Source Database       : MISL_ERP

Target Server Type    : MariaDB
Target Server Version : 100236
File Encoding         : 65001

Date: 2022-05-17 07:52:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tabSupplier
-- ----------------------------
DROP TABLE IF EXISTS `tabSupplier`;
CREATE TABLE `tabSupplier` (
  `SupID` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_name` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_bank_account` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_id` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_category` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_withholding_category` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_transporter` tinyint(1) NOT NULL DEFAULT 0,
  `is_internal_supplier` tinyint(1) NOT NULL DEFAULT 0,
  `represents_company` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_group` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_type` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT 'Company',
  `pan` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allow_purchase_invoice_creation_without_purchase_order` tinyint(1) NOT NULL DEFAULT 0,
  `allow_purchase_invoice_creation_without_purchase_receipt` tinyint(1) NOT NULL DEFAULT 0,
  `default_currency` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_price_list` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_terms` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `on_hold` tinyint(1) NOT NULL DEFAULT 0,
  `hold_type` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `website` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `_comments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Created_By` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `Modified_By` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `listIndx` tinyint(4) DEFAULT 0,
  `Enabled` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`SupID`),
  UNIQUE KEY `represents_company` (`represents_company`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED;
