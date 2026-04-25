-- ============================================================
-- AutoSmart Inventory Management System
-- Database: autosmart
-- Generated: 2025
-- Default Login: admin@gmail.com / admin
-- Password stored as SHA1 hash
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- --------------------------------------------------------
-- Database
-- --------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `autosmart` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `autosmart`;

-- --------------------------------------------------------
-- Table: user_details
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_type` enum('master','user') NOT NULL,
  `user_status` enum('Active','Inactive') NOT NULL,
  `entered_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Default admin user: admin@gmail.com / admin (SHA1 hashed)
INSERT INTO `user_details` (`id`,`user_email`,`user_password`,`user_name`,`user_type`,`user_status`,`entered_by`) VALUES
(1,'admin@gmail.com','d033e22ae348aeb5660fc2140aec35850c4da997','admin','master','Active',0);

-- --------------------------------------------------------
-- Table: category
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(250) NOT NULL,
  `category_status` enum('active','inactive') NOT NULL,
  `entered_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `category` (`id`,`category_name`,`category_status`,`entered_by`) VALUES
(1,'Ice Cream','active',1),
(2,'Dairy Day','active',1);

-- --------------------------------------------------------
-- Table: uom
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `uom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uom_name` varchar(100) NOT NULL,
  `uom_code` varchar(20) NOT NULL DEFAULT '',
  `uom_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `entered_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uom_name` (`uom_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `uom` (`id`,`uom_name`,`uom_code`,`uom_status`,`entered_by`) VALUES
(1,'Bag','BAG','active',1),
(2,'Box','BOX','active',1),
(5,'Pieces','PCS','active',1);

-- --------------------------------------------------------
-- Table: brand
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `brand_name` varchar(250) NOT NULL,
  `brand_status` enum('active','inactive') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `brand_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------
-- Table: company_profile
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `company_profile` (
  `company_name` varchar(100) NOT NULL,
  `place` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `distributor` text NOT NULL,
  `GSTIN` varchar(15) NOT NULL,
  `contact_no` bigint(20) NOT NULL,
  `alt_contact_no` bigint(20) NOT NULL,
  `name_of_the_account` varchar(100) NOT NULL,
  `account_no` bigint(20) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `branch` varchar(50) NOT NULL,
  `IFSC` varchar(15) NOT NULL,
  `for` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `company_profile` VALUES
('Shri Marutheshwar Agencies','BAGALKOT','Near Maruti Service Station\r\nRoopland Industrial Area Vidygiri Bagalkot','Dairy Day Ice Cream, Octorich Dairy Products and Namkeens','29CSLPM4303H1ZL',7019263193,0,'SHRI MARUTESHWAR AGENCIES',43437905380,'STATE BANK OF INDIA','NAVANAGAR','SBIN0004452','Shri Marutheshwar Agencies');

-- --------------------------------------------------------
-- Table: supplier_details
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `supplier_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firm_name` varchar(30) NOT NULL,
  `contact_person_name` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `contact_no` bigint(10) NOT NULL,
  `alt_contact_no` bigint(10) NOT NULL DEFAULT 0,
  `email_id` varchar(30) NOT NULL DEFAULT '',
  `zipcode` int(6) NOT NULL DEFAULT 0,
  `GSTIN` varchar(15) NOT NULL DEFAULT '',
  `bank_name` varchar(30) NOT NULL DEFAULT '',
  `branch_name` varchar(20) NOT NULL DEFAULT '',
  `bank_act_name` varchar(30) NOT NULL DEFAULT '',
  `bank_act_no` bigint(16) NOT NULL DEFAULT 0,
  `IFSC_code` varchar(12) NOT NULL DEFAULT '',
  `entered_by` int(20) NOT NULL DEFAULT 0,
  `supplier_status` enum('active','inactive') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `entered_by` (`entered_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `supplier_details` (`id`,`firm_name`,`contact_person_name`,`address`,`contact_no`,`alt_contact_no`,`email_id`,`zipcode`,`GSTIN`,`bank_name`,`branch_name`,`bank_act_name`,`bank_act_no`,`IFSC_code`,`entered_by`,`supplier_status`) VALUES
(22,'Vishal Enterprises','Vishal','Blr',1234567890,1223412312,'v@v.com',232321,'29ABCDE2344V2Z1','SBI','GDG','Vishal',1212121111,'SBI020323',1,'active');

-- --------------------------------------------------------
-- Table: customer_details
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `customer_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `firm_name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `place` varchar(150) DEFAULT NULL,
  `customer_type` varchar(50) NOT NULL,
  `GSTIN` varchar(15) DEFAULT NULL,
  `contact_no` bigint(10) DEFAULT NULL,
  `email_id` varchar(30) DEFAULT NULL,
  `zipcode` int(6) DEFAULT NULL,
  `entered_by` varchar(20) DEFAULT NULL,
  `customer_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `customer_details` (`id`,`customer_name`,`firm_name`,`address`,`place`,`customer_type`,`GSTIN`,`contact_no`,`email_id`,`zipcode`,`entered_by`,`customer_status`) VALUES
(20,'Test Customer','','NULL','NULL','Unregistered','',NULL,NULL,NULL,'1','active');

-- --------------------------------------------------------
-- Table: product
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(300) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `uom_id` int(11) NOT NULL,
  `unit_conversion` int(11) NOT NULL DEFAULT 1,
  `tax_status` enum('taxable','non-taxable') NOT NULL,
  `SGST` double NOT NULL DEFAULT 0,
  `CGST` double NOT NULL DEFAULT 0,
  `min_stock_quantity` int(11) NOT NULL DEFAULT 0,
  `entered_by` int(11) NOT NULL DEFAULT 0,
  `product_status` enum('active','inactive') NOT NULL,
  `init_stock_quantity` double NOT NULL DEFAULT 0,
  `as_on_date` date NOT NULL,
  `HSN_code` bigint(20) NOT NULL DEFAULT 0,
  `size` text DEFAULT NULL,
  `grade` text DEFAULT NULL,
  `product_image` varchar(100) DEFAULT NULL,
  `product_barcode` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `uom_id` (`uom_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_ibfk_3` FOREIGN KEY (`uom_id`) REFERENCES `uom` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `product` (`id`,`category_id`,`product_name`,`supplier_id`,`uom_id`,`unit_conversion`,`tax_status`,`SGST`,`CGST`,`min_stock_quantity`,`entered_by`,`product_status`,`init_stock_quantity`,`as_on_date`,`HSN_code`) VALUES
(21,2,'Cone Ice Cream',22,2,10,'taxable',2.5,2.5,10,1,'active',10,'2025-09-01',1212);

-- --------------------------------------------------------
-- Table: stock_details
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock_details` (
  `stock_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `total_purchase_quantity` double NOT NULL DEFAULT 0,
  `total_sales_quantity` double NOT NULL DEFAULT 0,
  `stock_available` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`stock_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `stock_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `stock_details` (`stock_id`,`product_id`,`total_purchase_quantity`,`total_sales_quantity`,`stock_available`) VALUES
(33,21,10,0,10);

-- --------------------------------------------------------
-- Table: purchase_invoice
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `purchase_invoice` (
  `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `date_of_purchase` date NOT NULL,
  `invoice_cash_bill_no` bigint(20) NOT NULL DEFAULT 0,
  `bill_amount` double NOT NULL DEFAULT 0,
  `SGST` double NOT NULL DEFAULT 0,
  `CGST` double NOT NULL DEFAULT 0,
  `total_amount` double NOT NULL DEFAULT 0,
  `purchase_status` enum('active','inactive') NOT NULL,
  `entered_by` int(11) NOT NULL DEFAULT 0,
  `date_of_entry` date NOT NULL,
  PRIMARY KEY (`purchase_id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `purchase_invoice_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AUTO_INCREMENT=48;

INSERT INTO `purchase_invoice` (`purchase_id`,`supplier_id`,`date_of_purchase`,`invoice_cash_bill_no`,`bill_amount`,`SGST`,`CGST`,`total_amount`,`purchase_status`,`entered_by`,`date_of_entry`) VALUES
(45,22,'2025-09-01',0,1000,0,0,1000,'active',1,'2025-09-07'),
(47,22,'2025-09-02',12111,1000,25,25,1050,'active',1,'2025-09-07');

-- --------------------------------------------------------
-- Table: purchase_details
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `purchase_details` (
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `unit_cost` double NOT NULL DEFAULT 0,
  `quantity` double NOT NULL DEFAULT 0,
  `purchase_uom` varchar(30) NOT NULL DEFAULT '',
  KEY `product_id` (`product_id`),
  KEY `purchase_invoice_key` (`purchase_id`),
  CONSTRAINT `purchase_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `purchase_details_ibfk_2` FOREIGN KEY (`purchase_id`) REFERENCES `purchase_invoice` (`purchase_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `purchase_details` (`purchase_id`,`product_id`,`unit_cost`,`quantity`,`purchase_uom`) VALUES
(47,21,100,10,'Pieces');

-- --------------------------------------------------------
-- Table: inventory_order
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventory_order` (
  `inventory_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_no` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `inventory_order_total` double(10,2) NOT NULL DEFAULT 0.00,
  `pdiscount` int(11) NOT NULL DEFAULT 0,
  `pcess` int(11) NOT NULL DEFAULT 0,
  `inventory_order_date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `bill_type` varchar(15) NOT NULL DEFAULT 'Tax Invoice',
  `payment_status` enum('cash','credit') NOT NULL DEFAULT 'cash',
  `inventory_order_status` varchar(100) NOT NULL DEFAULT 'active',
  `inventory_order_created_date` date NOT NULL,
  PRIMARY KEY (`inventory_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AUTO_INCREMENT=3;

-- --------------------------------------------------------
-- Table: inventory_order_product
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventory_order_product` (
  `inventory_order_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `price` double(10,2) NOT NULL DEFAULT 0.00,
  `tax` double(10,2) NOT NULL DEFAULT 0.00,
  `sale_uom` varchar(30) NOT NULL DEFAULT '',
  KEY `inventory_order_id` (`inventory_order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `inventory_order_product_ibfk_1` FOREIGN KEY (`inventory_order_id`) REFERENCES `inventory_order` (`inventory_order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inventory_order_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------
-- Table: qinventory_order
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `qinventory_order` (
  `inventory_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `inventory_order_total` double(10,2) NOT NULL DEFAULT 0.00,
  `inventory_order_date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `inventory_order_status` varchar(100) NOT NULL DEFAULT 'active',
  `inventory_order_created_date` date NOT NULL,
  PRIMARY KEY (`inventory_order_id`),
  KEY `user_id` (`user_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `qinventory_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `qinventory_order_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------
-- Table: qinventory_order_product
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `qinventory_order_product` (
  `inventory_order_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `price` double(10,2) NOT NULL DEFAULT 0.00,
  `sale_uom` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`inventory_order_product_id`),
  KEY `inventory_order_id` (`inventory_order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `qinventory_order_product_ibfk_1` FOREIGN KEY (`inventory_order_id`) REFERENCES `inventory_order` (`inventory_order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `qinventory_order_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------
-- Table: customer_payment
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `customer_payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `total_amount_to_be_paid` double NOT NULL DEFAULT 0,
  `amount_paid` double NOT NULL DEFAULT 0,
  `balance` double NOT NULL DEFAULT 0,
  `entered_by` int(11) NOT NULL DEFAULT 0,
  `date_of_entry` date NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_payment_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AUTO_INCREMENT=3;

-- --------------------------------------------------------
-- Table: customer_payment_details
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `customer_payment_details` (
  `transaction_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `inventory_order_id` int(11) NOT NULL,
  `bill_amount` double NOT NULL DEFAULT 0,
  `amount_paid` double NOT NULL DEFAULT 0,
  `balance` double NOT NULL DEFAULT 0,
  `mode_of_payment` enum('cash','cheque','credit','BroughtForward') NOT NULL,
  `cheque_number` bigint(20) NOT NULL DEFAULT 0,
  `cheque_date` date DEFAULT NULL,
  `cheque_bank_name` varchar(30) NOT NULL DEFAULT '',
  `date_of_payment` date NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `payment_id` (`payment_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_payment_details_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `customer_payment` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `customer_payment_details_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AUTO_INCREMENT=10;

-- --------------------------------------------------------
-- Table: display_details
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `display_details` (
  `display_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `unit_display` int(11) NOT NULL DEFAULT 0,
  `unit_rate` int(11) NOT NULL DEFAULT 0,
  `total_display_amount` int(11) NOT NULL DEFAULT 0,
  `date_of_display` date NOT NULL,
  `entered_by` varchar(11) NOT NULL DEFAULT '',
  `last_modified_on` datetime NOT NULL,
  PRIMARY KEY (`display_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `display_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------
-- Table: supplier_payment
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `supplier_payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `total_amount_to_be_paid` double NOT NULL DEFAULT 0,
  `amount_paid` double NOT NULL DEFAULT 0,
  `balance` double NOT NULL DEFAULT 0,
  `entered_by` int(11) NOT NULL DEFAULT 0,
  `date_of_entry` date NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `supplier_payment_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AUTO_INCREMENT=35;

INSERT INTO `supplier_payment` (`payment_id`,`supplier_id`,`total_amount_to_be_paid`,`amount_paid`,`balance`,`entered_by`,`date_of_entry`) VALUES
(34,22,2050,0,2050,1,'2025-09-07');

-- --------------------------------------------------------
-- Table: supplier_payment_details
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `supplier_payment_details` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `bill_amount` double NOT NULL DEFAULT 0,
  `amount_paid` double NOT NULL DEFAULT 0,
  `balance` double NOT NULL DEFAULT 0,
  `mode_of_payment` enum('','cash','RTGS','BroughtForward') DEFAULT NULL,
  `UTR_number` varchar(50) DEFAULT NULL,
  `UTR_bank_name` varchar(50) DEFAULT NULL,
  `date_of_payment` date DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `supplier_payment_details_ibfk_1` (`payment_id`),
  KEY `supplier_payment_details_ibfk_3` (`purchase_id`),
  CONSTRAINT `supplier_payment_details_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `supplier_payment` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `supplier_payment_details_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `supplier_payment_details_ibfk_3` FOREIGN KEY (`purchase_id`) REFERENCES `purchase_invoice` (`purchase_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AUTO_INCREMENT=40;

-- --------------------------------------------------------
-- Views
-- --------------------------------------------------------
CREATE OR REPLACE VIEW `product_wise_stock_in_details` AS
  SELECT pd.product_id, s.firm_name AS supplier_name, pi.date_of_purchase,
         pd.quantity AS stock_in, pd.purchase_uom
  FROM purchase_invoice pi
  JOIN purchase_details pd ON pi.purchase_id = pd.purchase_id
  JOIN supplier_details s  ON pi.supplier_id = s.id
  ORDER BY pi.date_of_purchase ASC;

CREATE OR REPLACE VIEW `product_wise_stock_out_details` AS
  SELECT ivp.product_id, c.customer_name, iv.inventory_order_date,
         ivp.quantity AS stock_out, ivp.sale_uom
  FROM inventory_order_product ivp
  JOIN inventory_order iv     ON ivp.inventory_order_id = iv.inventory_order_id
  JOIN customer_details c     ON iv.customer_id = c.id
  ORDER BY iv.inventory_order_date ASC;

COMMIT;
