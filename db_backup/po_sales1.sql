-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2026 at 10:03 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `po_sales`
--

-- --------------------------------------------------------

--
-- Table structure for table `pos_checkouts`
--

CREATE TABLE `pos_checkouts` (
  `pos_checkout_id` int(11) NOT NULL,
  `pos_checkout_code` varchar(50) NOT NULL,
  `pos_item_id` int(11) NOT NULL,
  `pos_item_code` varchar(100) NOT NULL,
  `pos_item_name` varchar(255) NOT NULL,
  `pos_item_price` decimal(10,2) NOT NULL,
  `pos_item_quantity` decimal(10,2) NOT NULL,
  `pos_item_unit` varchar(50) NOT NULL,
  `pos_checkout_subtotal` decimal(10,2) NOT NULL,
  `pos_checkout_total` decimal(10,2) NOT NULL,
  `pos_checkout_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pos_inventory`
--

CREATE TABLE `pos_inventory` (
  `pos_item_id` int(11) NOT NULL,
  `pos_item_name` varchar(200) NOT NULL,
  `pos_item_code` varchar(50) NOT NULL,
  `pos_item_image` varchar(100) NOT NULL,
  `pos_item_price` decimal(10,2) NOT NULL,
  `pos_item_stock` int(11) NOT NULL,
  `pos_item_unit` varchar(10) NOT NULL,
  `pos_item_low` int(11) NOT NULL,
  `pos_item_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pos_inventory`
--

INSERT INTO `pos_inventory` (`pos_item_id`, `pos_item_name`, `pos_item_code`, `pos_item_image`, `pos_item_price`, `pos_item_stock`, `pos_item_unit`, `pos_item_low`, `pos_item_status`) VALUES
(1, 'C2 Apple', 'C2-apple-450ml', 'c2_apple_1l.jpg', 45.00, 23, 'piece', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_item_codes`
--

CREATE TABLE `pos_item_codes` (
  `pos_item_code` varchar(50) NOT NULL,
  `pos_barcode_value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pos_logs`
--

CREATE TABLE `pos_logs` (
  `pos_log_id` int(11) NOT NULL,
  `pos_activity_type` varchar(50) NOT NULL,
  `pos_code` varchar(50) NOT NULL,
  `pos_activity` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pos_restocking`
--

CREATE TABLE `pos_restocking` (
  `pos_restocking_id` int(11) NOT NULL,
  `pos_restocking_code` varchar(50) NOT NULL,
  `pos_item_id` int(11) NOT NULL,
  `pos_item_count` int(11) NOT NULL,
  `pos_restocking_date` date NOT NULL,
  `pos_restocking_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supply_checkouts`
--

CREATE TABLE `supply_checkouts` (
  `supply_checkout_id` int(11) NOT NULL,
  `supply_checkout_code` varchar(50) NOT NULL,
  `supply_item_id` int(11) NOT NULL,
  `supply_item_name` varchar(255) NOT NULL,
  `supply_item_price` decimal(10,2) NOT NULL,
  `supply_item_count` int(11) NOT NULL,
  `supply_item_unit` varchar(50) NOT NULL,
  `supply_item_image` varchar(255) DEFAULT NULL,
  `supply_item_subtotal` decimal(10,2) NOT NULL,
  `supply_checkout_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supply_inventory`
--

CREATE TABLE `supply_inventory` (
  `supply_item_id` int(11) NOT NULL,
  `supply_item_name` varchar(200) NOT NULL,
  `supply_item_price` decimal(10,2) NOT NULL,
  `supply_item_image` text NOT NULL,
  `supply_item_stock` int(11) NOT NULL,
  `supply_item_unit` varchar(10) NOT NULL,
  `supply_item_low` int(11) NOT NULL,
  `supply_item_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supply_logs`
--

CREATE TABLE `supply_logs` (
  `supply_log_id` int(11) NOT NULL,
  `supply_activity_type` varchar(50) NOT NULL,
  `supply_code` varchar(50) NOT NULL,
  `supply_activity` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supply_restocking`
--

CREATE TABLE `supply_restocking` (
  `supply_restocking_id` int(11) NOT NULL,
  `supply_restocking_code` varchar(50) NOT NULL,
  `supply_item_id` int(11) NOT NULL,
  `supply_item_count` int(11) NOT NULL,
  `supply_restocking_date` date NOT NULL,
  `supply_restocking_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`user_id`, `username`, `password`) VALUES
(1, 'grenjo8', '123456Aa');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email_address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `first_name`, `middle_name`, `last_name`, `gender`, `email_address`) VALUES
(1, 'renzo', 'ferreras', 'advincula', 'male', 'advincularenzo@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pos_checkouts`
--
ALTER TABLE `pos_checkouts`
  ADD PRIMARY KEY (`pos_checkout_id`);

--
-- Indexes for table `pos_inventory`
--
ALTER TABLE `pos_inventory`
  ADD PRIMARY KEY (`pos_item_id`);

--
-- Indexes for table `pos_logs`
--
ALTER TABLE `pos_logs`
  ADD PRIMARY KEY (`pos_log_id`);

--
-- Indexes for table `pos_restocking`
--
ALTER TABLE `pos_restocking`
  ADD PRIMARY KEY (`pos_restocking_id`);

--
-- Indexes for table `supply_checkouts`
--
ALTER TABLE `supply_checkouts`
  ADD PRIMARY KEY (`supply_checkout_id`);

--
-- Indexes for table `supply_inventory`
--
ALTER TABLE `supply_inventory`
  ADD PRIMARY KEY (`supply_item_id`);

--
-- Indexes for table `supply_logs`
--
ALTER TABLE `supply_logs`
  ADD PRIMARY KEY (`supply_log_id`);

--
-- Indexes for table `supply_restocking`
--
ALTER TABLE `supply_restocking`
  ADD PRIMARY KEY (`supply_restocking_id`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pos_checkouts`
--
ALTER TABLE `pos_checkouts`
  MODIFY `pos_checkout_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pos_inventory`
--
ALTER TABLE `pos_inventory`
  MODIFY `pos_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pos_logs`
--
ALTER TABLE `pos_logs`
  MODIFY `pos_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pos_restocking`
--
ALTER TABLE `pos_restocking`
  MODIFY `pos_restocking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supply_checkouts`
--
ALTER TABLE `supply_checkouts`
  MODIFY `supply_checkout_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supply_inventory`
--
ALTER TABLE `supply_inventory`
  MODIFY `supply_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supply_logs`
--
ALTER TABLE `supply_logs`
  MODIFY `supply_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supply_restocking`
--
ALTER TABLE `supply_restocking`
  MODIFY `supply_restocking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
