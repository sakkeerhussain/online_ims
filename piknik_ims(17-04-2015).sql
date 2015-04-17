-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2015 at 04:02 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `piknik_ims`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(200) NOT NULL,
  `branch` varchar(200) NOT NULL,
  `ifsc_code` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `bank_name`, `branch`, `ifsc_code`, `created_at`, `last_edited`) VALUES
(1, 'SBI', 'Mananchira', 'NULL', '2015-04-08 11:20:05', '2015-04-08 11:20:05'),
(2, 'SBI', 'Mananchira', 'NULL', '2015-04-08 11:20:05', '2015-04-08 11:20:05'),
(3, 'SBI', 'Mananchira', 'NULL', '2015-04-08 11:20:05', '2015-04-08 11:20:05');

-- --------------------------------------------------------

--
-- Table structure for table `bank_deposits`
--

CREATE TABLE IF NOT EXISTS `bank_deposits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cachier_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `description` text NOT NULL,
  `deposited_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `bank_deposits`
--

INSERT INTO `bank_deposits` (`id`, `cachier_id`, `bank_id`, `amount`, `description`, `deposited_at`, `last_edited`) VALUES
(1, 1, 1, 0, 'Balance of 12/12/2014', '2015-04-08 14:47:39', '2015-04-08 14:47:39'),
(2, 1, 1, 0, 'Balance of 12/12/2014', '2015-04-08 14:47:41', '2015-04-08 14:47:41'),
(3, 1, 1, 0, 'Balance of 12/12/2014', '2015-04-08 14:47:41', '2015-04-08 14:47:41'),
(4, 1, 1, 5000, 'Balance of 23/12/2014', '2015-04-08 15:56:54', '2015-04-08 15:56:54'),
(5, 1, 1, 5000, 'Balance of 23/12/2014', '2015-04-08 15:56:56', '2015-04-08 15:56:56'),
(6, 1, 1, 5000, 'Balance of 23/12/2014', '2015-04-08 15:56:56', '2015-04-08 15:56:56');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(200) NOT NULL,
  `copany_code` varchar(20) NOT NULL,
  `tin_number` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `copany_code`, `tin_number`, `created_at`, `last_edited`) VALUES
(1, 'Hilite Pik-Nik', 'HILITE', NULL, '2015-04-08 09:59:46', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(200) NOT NULL,
  `customer_code` varchar(50) NOT NULL,
  `company_id` int(11) NOT NULL,
  `total_purchace_amount` int(11) NOT NULL,
  `purchace_amount_to_avail_redeem` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer_name`, `customer_code`, `company_id`, `total_purchace_amount`, `purchace_amount_to_avail_redeem`, `created_at`, `last_edited`) VALUES
(1, 'Roopesh', '1/1/2015', 1, 5000, 3000, '2015-04-08 15:34:24', '2015-04-08 15:34:24'),
(2, 'Roopesh', '1/1/2015', 1, 5000, 3000, '2015-04-08 15:34:24', '2015-04-08 15:34:24'),
(3, 'Roopesh', '1/1/2015', 1, 5000, 3000, '2015-04-08 15:34:24', '2015-04-08 15:34:24'),
(4, 'Roopesh', '1/1/2015', 1, 5000, 3000, '2015-04-08 15:34:24', '2015-04-08 15:34:24');

-- --------------------------------------------------------

--
-- Table structure for table `expences`
--

CREATE TABLE IF NOT EXISTS `expences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `expences`
--

INSERT INTO `expences` (`id`, `amount`, `description`, `created_at`, `last_edited`) VALUES
(1, 2000, 'Paid Electicity bill at KSEB Kotooli', '2015-04-08 15:50:28', '2015-04-08 15:50:28'),
(2, 2000, 'Paid Electicity bill at KSEB Kotooli', '2015-04-08 15:50:28', '2015-04-08 15:50:28'),
(3, 2000, 'Paid Electicity bill at KSEB Kotooli', '2015-04-08 15:50:29', '2015-04-08 15:50:29');

-- --------------------------------------------------------

--
-- Table structure for table `inventry`
--

CREATE TABLE IF NOT EXISTS `inventry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `in_stock_count` int(11) NOT NULL,
  `cutoff_count` int(11) NOT NULL,
  `selling_prize` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `tax_category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `inventry`
--

INSERT INTO `inventry` (`id`, `item_id`, `in_stock_count`, `cutoff_count`, `selling_prize`, `company_id`, `tax_category_id`, `created_at`, `last_edited`) VALUES
(1, 1, 100, 20, 250, 1, 1, '2015-04-08 10:15:41', '2015-04-08 10:15:41'),
(2, 2, 100, 20, 250, 1, 1, '2015-04-08 10:15:43', '2015-04-08 10:15:43');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(200) NOT NULL,
  `item_code` varchar(50) NOT NULL,
  `mrp` int(11) NOT NULL,
  `purchace_rate` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `item_name`, `item_code`, `mrp`, `purchace_rate`, `created_at`, `last_edited`) VALUES
(1, 'Dry Dates', 'DD', 300, 200, '2015-04-08 09:58:21', '2015-04-08 09:58:21'),
(2, 'Tomato', 'TMT', 40, 25, '2015-04-12 15:41:56', '2015-04-12 15:41:56'),
(3, 'Ginger', 'GGR', 50, 30, '2015-04-12 15:45:17', '2015-04-12 15:45:17'),
(4, 'Apple', 'APL', 70, 50, '2015-04-12 16:56:11', '2015-04-12 16:56:11'),
(5, 'safdhdh', 'dfhdh', 10, 10, '2015-04-16 16:56:10', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchaces`
--

CREATE TABLE IF NOT EXISTS `purchaces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wendor_id` int(11) NOT NULL,
  `purchace_manager_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `stocked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `purchaces`
--

INSERT INTO `purchaces` (`id`, `wendor_id`, `purchace_manager_id`, `company_id`, `amount`, `stocked`, `created_at`, `last_edited`) VALUES
(1, 1, 3, 1, 9200, 0, '2015-04-15 17:05:21', '2015-04-15 17:05:21'),
(2, 3, 3, 1, 9205, 0, '2015-04-15 17:06:41', '2015-04-15 17:06:41'),
(3, 3, 3, 1, 1000, 0, '2015-04-15 17:11:19', '2015-04-15 17:11:19'),
(4, 1, 3, 1, 24, 0, '2015-04-16 16:45:59', '0000-00-00 00:00:00'),
(5, 2, 3, 1, 13, 0, '2015-04-16 16:54:51', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchace_items`
--

CREATE TABLE IF NOT EXISTS `purchace_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchace_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `creeated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `purchace_items`
--

INSERT INTO `purchace_items` (`id`, `purchace_id`, `item_id`, `quantity`, `rate`, `creeated_at`) VALUES
(1, 1, 1, 100, 50, '2015-04-15 17:15:29'),
(2, 1, 4, 50, 80, '2015-04-15 17:15:29'),
(3, 1, 2, 10, 20, '2015-04-15 17:15:29'),
(4, 2, 1, 100, 50, '2015-04-15 17:15:29'),
(5, 2, 4, 50, 79, '2015-04-15 17:15:29'),
(6, 2, 2, 15, 17, '2015-04-15 17:15:29'),
(7, 3, 3, 10, 100, '2015-04-15 17:15:29'),
(8, 4, 3, 3, 4, '2015-04-16 16:46:00'),
(9, 4, 4, 4, 3, '2015-04-16 16:46:00'),
(10, 5, 3, 2, 2, '2015-04-16 16:54:51'),
(11, 5, 3, 3, 3, '2015-04-16 16:54:51');

-- --------------------------------------------------------

--
-- Table structure for table `redeems`
--

CREATE TABLE IF NOT EXISTS `redeems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `cachier_id` int(11) NOT NULL,
  `redeem_amount` int(11) NOT NULL,
  `redeem_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `net_amount` int(11) NOT NULL,
  `tax_amount` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `sale_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `amount`, `net_amount`, `tax_amount`, `company_id`, `sale_at`, `last_edited`) VALUES
(1, 20, 2000, 1900, 100, 1, '2015-04-08 10:40:09', '2015-04-08 10:40:09'),
(2, 20, 2000, 1900, 100, 1, '2015-04-08 10:40:23', '2015-04-08 10:40:23');

-- --------------------------------------------------------

--
-- Table structure for table `sales_items`
--

CREATE TABLE IF NOT EXISTS `sales_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `tax` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sales_items`
--

INSERT INTO `sales_items` (`id`, `sale_id`, `item_id`, `rate`, `quantity`, `tax`, `created_at`, `last_edited`) VALUES
(1, 1, 1, 10, 5, 1, '2015-04-15 17:16:59', '2015-04-08 10:49:08'),
(2, 1, 1, 10, 5, 1, '2015-04-15 17:16:59', '2015-04-08 10:49:11'),
(3, 1, 1, 10, 5, 1, '2015-04-15 17:16:59', '2015-04-08 10:49:12'),
(4, 1, 1, 10, 5, 1, '2015-04-15 17:16:59', '2015-04-08 10:49:12'),
(5, 1, 1, 10, 5, 1, '2015-04-15 17:16:59', '2015-04-08 10:49:12'),
(6, 1, 1, 10, 5, 1, '2015-04-15 17:16:59', '2015-04-08 11:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `tax_category`
--

CREATE TABLE IF NOT EXISTS `tax_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_category_name` varchar(200) NOT NULL,
  `tax_percentage` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tax_category`
--

INSERT INTO `tax_category` (`id`, `tax_category_name`, `tax_percentage`, `created_at`, `last_edited`) VALUES
(1, '12%', 12, '2015-04-15 17:17:45', '2015-04-12 05:24:02'),
(2, '10.5%', 10.5, '2015-04-15 17:17:45', '2015-04-12 05:24:16'),
(3, '4%', 4, '2015-04-15 17:17:45', '2015-04-12 05:24:26');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `company_id` int(11) NOT NULL,
  `wacher_id` int(11) NOT NULL,
  `password_hashed` varchar(50) NOT NULL,
  `access_tocken` varchar(50) DEFAULT NULL,
  `user_type_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_accessed` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `name`, `company_id`, `wacher_id`, `password_hashed`, `access_tocken`, `user_type_id`, `created_at`, `last_edited`, `last_accessed`) VALUES
(1, 'admin', 'Pik Nik admin', 0, 0, '81dc9bdb52d04dc20036dbd8313ed055', NULL, 4, '2015-04-08 09:21:37', '2015-04-08 09:21:37', '2015-04-08 09:21:37'),
(2, 'company_admin1', 'Admin company 1', 1, 0, '81dc9bdb52d04dc20036dbd8313ed055', NULL, 3, '2015-04-08 09:21:38', '2015-04-08 09:21:38', '2015-04-08 09:21:38'),
(3, 'purchace1', 'Purchace manager company 1', 1, 0, '81dc9bdb52d04dc20036dbd8313ed055', NULL, 2, '2015-04-08 09:21:38', '2015-04-08 09:21:38', '2015-04-08 09:21:38'),
(4, 'pos1', 'POS company 1', 1, 0, '81dc9bdb52d04dc20036dbd8313ed055', NULL, 1, '2015-04-08 09:21:39', '2015-04-08 09:21:39', '2015-04-08 09:21:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `user_type_name`, `created_at`, `last_edited`) VALUES
(1, 'POS - sales', '2015-04-07 02:39:17', '2015-04-07 02:39:17'),
(2, 'manager - Purchace', '2015-04-07 02:39:51', '2015-04-07 02:39:51'),
(3, 'Company Admin', '2015-04-07 02:40:24', '2015-04-07 02:40:24'),
(4, 'Corporate Admin', '2015-04-07 02:40:45', '2015-04-07 02:40:45');

-- --------------------------------------------------------

--
-- Table structure for table `wendors`
--

CREATE TABLE IF NOT EXISTS `wendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wendor_name` varchar(200) NOT NULL,
  `total_puchace_amount` int(11) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `contact_address` varchar(250) NOT NULL,
  `wendor_tin_number` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `wendors`
--

INSERT INTO `wendors` (`id`, `wendor_name`, `total_puchace_amount`, `contact_no`, `contact_address`, `wendor_tin_number`, `created_at`, `last_edited`) VALUES
(1, 'Foreign Dates 1', 50000, '+919746393923', 'S-14,Kiraly Complex,Thondayad,Calicut', '1464896876867', '2015-04-08 16:14:45', '2015-04-08 16:14:45'),
(2, 'Foreign Dates 2', 50000, '+919746393923', 'S-14,Kiraly Complex,Thondayad,Calicut', '1464896876867', '2015-04-08 16:14:46', '2015-04-08 16:14:46'),
(3, 'Foreign Dates 3', 50000, '+919746393923', 'S-14,Kiraly Complex,Thondayad,Calicut', '1464896876867', '2015-04-08 16:14:46', '2015-04-08 16:14:46');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
