-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2026 at 07:49 PM
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
  `user_id` int(11) NOT NULL,
  `pos_checkout_code` varchar(50) NOT NULL,
  `pos_item_id` int(11) NOT NULL,
  `pos_item_code` varchar(100) NOT NULL,
  `pos_item_name` varchar(255) NOT NULL,
  `pos_item_price` decimal(10,2) NOT NULL,
  `pos_item_quantity` decimal(10,2) NOT NULL,
  `pos_item_unit` varchar(50) NOT NULL,
  `pos_discount_type` varchar(30) NOT NULL,
  `pos_discount_value` decimal(10,2) NOT NULL,
  `pos_checkout_subtotal` decimal(10,2) NOT NULL,
  `pos_checkout_total` decimal(10,2) NOT NULL,
  `pos_checkout_date` datetime NOT NULL DEFAULT current_timestamp(),
  `pos_checkout_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pos_checkouts`
--

INSERT INTO `pos_checkouts` (`pos_checkout_id`, `user_id`, `pos_checkout_code`, `pos_item_id`, `pos_item_code`, `pos_item_name`, `pos_item_price`, `pos_item_quantity`, `pos_item_unit`, `pos_discount_type`, `pos_discount_value`, `pos_checkout_subtotal`, `pos_checkout_total`, `pos_checkout_date`, `pos_checkout_status`) VALUES
(1, 2, 'CO-0001', 1, 'c2_apple_450ml', 'C2 Apple', 45.00, 3.00, 'piece', '', 0.00, 135.00, 135.00, '2026-04-02 22:45:19', 2),
(2, 2, 'CO-0002', 1, 'c2_apple_450ml', 'C2 Apple', 45.00, 2.00, 'piece', '', 0.00, 90.00, 90.00, '2026-04-02 22:45:49', 2),
(3, 9, 'CO-0003', 2, 'c2_greentea_450ml', 'C2 Greentea', 43.00, 1.00, 'piece', 'senior', 0.20, 0.00, 34.40, '2026-05-03 00:43:36', 1),
(4, 9, 'CO-0003', 3, 'c2_lemon_450ml', 'C2 Lemon', 46.00, 1.00, 'piece', 'senior', 0.20, 0.00, 36.80, '2026-05-03 00:43:36', 1),
(5, 9, 'CO-0004', 2, 'c2_greentea_450ml', 'C2 Greentea', 43.00, 1.00, 'piece', 'none', 0.00, 0.00, 43.00, '2026-05-03 00:45:50', 1),
(6, 9, 'CO-0004', 3, 'c2_lemon_450ml', 'C2 Lemon', 46.00, 4.00, 'piece', 'none', 0.00, 0.00, 184.00, '2026-05-03 00:45:50', 1),
(7, 9, 'CO-0005', 3, 'c2_lemon_450ml', 'C2 Lemon', 46.00, 3.00, 'piece', 'none', 0.00, 0.00, 138.00, '2026-05-03 01:25:22', 1);

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
(1, 'C2 Apple', 'c2_apple_450ml', 'c2_apple_1l.jpg', 45.00, 27, 'piece', 5, 1),
(2, 'C2 Greentea', 'c2_greentea_450ml', 'c2_greentea.webp', 43.00, 5, 'piece', 5, 1),
(3, 'C2 Lemon', 'c2_lemon_450ml', 'c2_lemon.webp', 46.00, 4, 'piece', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_item_codes`
--

CREATE TABLE `pos_item_codes` (
  `pos_item_id` int(11) NOT NULL,
  `pos_barcode_value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pos_item_codes`
--

INSERT INTO `pos_item_codes` (`pos_item_id`, `pos_barcode_value`) VALUES
(3, '6954301166405'),
(2, 'SN:25120019');

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

--
-- Dumping data for table `pos_logs`
--

INSERT INTO `pos_logs` (`pos_log_id`, `pos_activity_type`, `pos_code`, `pos_activity`, `timestamp`) VALUES
(1, 'Item Updating', 'Item ID: ', '<strong>Updated:</strong><br>Item Name, Item Price, Item Unit, Current Stock, Low Stock Level', '2026-03-25 13:32:42'),
(2, 'Item Updating', 'Item ID: 2', '<strong>Updated:</strong><br>Low Stock Level', '2026-03-25 13:34:02'),
(3, 'Item Updating', 'Item ID: 2', '<strong>Updated:</strong><br>Low Stock Level', '2026-03-25 13:36:57'),
(4, 'Item Updating', 'Item ID: 2', '<strong>Updated:</strong><br>Low Stock Level', '2026-03-25 13:38:49'),
(5, 'Item Updating', 'Item ID: 2', '<strong>Updated:</strong><br>Low Stock Level', '2026-03-25 13:43:20'),
(6, 'Item Updating', 'Item ID: 2', '<strong>Updated:</strong><br>Low Stock Level', '2026-03-25 13:46:59'),
(7, 'Item Updating', 'Item ID: 3', '<strong>Updated:</strong><br>Current Stock', '2026-03-25 13:55:31'),
(8, 'Barcode Creation', 'Item ID: 3', '<strong>Added Barcode:</strong><br>6936685220683', '2026-03-31 16:36:38'),
(9, 'Barcode Creation', 'Item ID: 3', '<strong>Added Barcode:</strong><br>4800888195708', '2026-03-31 16:52:39'),
(10, 'Barcode Creation', 'Item ID: 2', '<strong>Added Barcode:</strong><br>4800888195708', '2026-03-31 16:54:10'),
(11, 'Barcode Creation', 'Item ID: 2', '<strong>Added Barcode:</strong><br>6936685220683', '2026-03-31 16:54:26'),
(12, 'Barcode Creation', 'Item ID: 1', '<strong>Added Barcode:</strong><br>SN:25120019', '2026-04-02 14:10:12'),
(13, 'Sale', 'Item ID: 1', '<strong>Sold:</strong><br>C2 Apple (x3 piece)', '2026-04-02 14:45:19'),
(14, 'Sale', 'Item ID: 1', '<strong>Sold:</strong><br>C2 Apple (x2 piece)', '2026-04-02 14:45:49'),
(15, 'Restocking', 'Item ID: 2', '<strong>Restocked:</strong><br>C2 Greentea (+3 piece)', '2026-05-02 09:16:19'),
(16, 'Restocking', 'Item ID: 3', '<strong>Restocked:</strong><br>C2 Lemon (+6 piece)', '2026-05-02 09:16:19'),
(17, 'Barcode Deletion', 'Item ID: 3', '<strong>Removed Barcode:</strong><br>6936685220683', '2026-05-02 11:19:58'),
(18, 'Barcode Deletion', 'Item ID: 3', '<strong>Removed Barcode:</strong><br>4800888195708', '2026-05-02 11:20:00'),
(19, 'Barcode Deletion', 'Item ID: 1', '<strong>Removed Barcode:</strong><br>SN:25120019', '2026-05-02 11:20:08'),
(20, 'Account Creation', 'User ID: 4', '<strong>Created Account:</strong><br>Sealthiel Rose Advincula (@rose) [Cashier]', '2026-05-02 14:38:41'),
(21, 'Account Creation', 'User ID: 9', '<strong>Created Account:</strong><br>Sealthiel Rose Advincula (@rose) [Cashier]', '2026-05-02 15:23:20'),
(22, 'Barcode Creation', 'Item ID: 3', '<strong>Added Barcode:</strong><br>6954301166405', '2026-05-02 16:40:51'),
(23, 'Barcode Creation', 'Item ID: 2', '<strong>Added Barcode:</strong><br>SN:25120019', '2026-05-02 16:41:07'),
(24, 'Item Updating', 'Item ID: 3', '<strong>Updated:</strong><br>Current Stock', '2026-05-02 17:20:21'),
(25, 'Item Updating', 'Item ID: 2', '<strong>Updated:</strong><br>Current Stock, Low Stock Level', '2026-05-02 17:27:31'),
(26, 'Account Update', 'User ID: 9', '<strong>Updated Account:</strong><br>Status: Active → Inactive', '2026-05-02 17:28:47'),
(27, 'Account Update', 'User ID: 9', '<strong>Updated Account:</strong><br>Status: Inactive → Active', '2026-05-02 17:28:52'),
(28, 'Restocking', 'Item ID: 1', '<strong>Restocked:</strong><br>C2 Apple (+4 piece)', '2026-05-02 17:41:21'),
(29, 'Restocking', 'Item ID: 3', '<strong>Restocked:</strong><br>C2 Lemon (+4 piece)', '2026-05-02 17:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `pos_restocking`
--

CREATE TABLE `pos_restocking` (
  `pos_restocking_id` int(11) NOT NULL,
  `pos_restocking_code` varchar(50) NOT NULL,
  `pos_item_id` int(11) NOT NULL,
  `pos_item_code` varchar(100) NOT NULL,
  `pos_item_name` varchar(255) NOT NULL,
  `pos_item_price` decimal(10,2) NOT NULL,
  `pos_item_quantity` decimal(10,2) NOT NULL,
  `pos_item_unit` varchar(50) NOT NULL,
  `pos_restocking_total` decimal(10,2) NOT NULL,
  `pos_restocking_date` datetime NOT NULL DEFAULT current_timestamp(),
  `pos_restocking_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pos_restocking`
--

INSERT INTO `pos_restocking` (`pos_restocking_id`, `pos_restocking_code`, `pos_item_id`, `pos_item_code`, `pos_item_name`, `pos_item_price`, `pos_item_quantity`, `pos_item_unit`, `pos_restocking_total`, `pos_restocking_date`, `pos_restocking_status`) VALUES
(1, 'R2_2026', 2, 'c2_greentea_450ml', 'C2 Greentea', 43.00, 3.00, 'piece', 129.00, '2026-05-02 00:00:00', 2),
(2, 'R2_2026', 3, 'c2_lemon_450ml', 'C2 Lemon', 46.00, 6.00, 'piece', 276.00, '2026-05-02 00:00:00', 2),
(3, 'R3_2026', 1, 'c2_apple_450ml', 'C2 Apple', 45.00, 4.00, 'piece', 180.00, '2026-05-03 00:00:00', 1),
(4, 'R3_2026', 3, 'c2_lemon_450ml', 'C2 Lemon', 46.00, 4.00, 'piece', 184.00, '2026-05-03 00:00:00', 1);

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
(1, 'sakimart', '$2b$10$lr5RVADqlDcsPGMuy1EZCOHmoyzuIbV4g5sySc/HI6UkFZBl3GpYq'),
(9, 'rose', '$2y$10$.8d6XBljN4zvnjTqVtVkHuiX7tviEVL3uixE5Y5PtxMBi9ilB2qMW');

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
  `email_address` varchar(100) NOT NULL,
  `user_type` int(11) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `first_name`, `middle_name`, `last_name`, `gender`, `email_address`, `user_type`, `user_status`) VALUES
(1, 'Saki Mart', '', 'Administrator', 'Male', 'superadmin@sakimart.com', 8, 1),
(9, 'Sealthiel Rose', 'Nite', 'Advincula', 'female', 'rose@gmail.com', 2, 1);

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
  MODIFY `pos_checkout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pos_inventory`
--
ALTER TABLE `pos_inventory`
  MODIFY `pos_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pos_logs`
--
ALTER TABLE `pos_logs`
  MODIFY `pos_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `pos_restocking`
--
ALTER TABLE `pos_restocking`
  MODIFY `pos_restocking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
