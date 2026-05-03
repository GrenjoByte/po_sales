-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2026 at 04:15 PM
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
  `pos_item_price` decimal(10,2) NOT NULL,
  `pos_item_stock` int(11) NOT NULL,
  `pos_item_unit` varchar(10) NOT NULL,
  `pos_item_low` int(11) NOT NULL,
  `pos_item_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pos_inventory`
--

INSERT INTO `pos_inventory` (`pos_item_id`, `pos_item_name`, `pos_item_code`, `pos_item_price`, `pos_item_stock`, `pos_item_unit`, `pos_item_low`, `pos_item_status`) VALUES
(1, 'C2 Apple', 'c2_apple_450ml', 45.00, 27, 'piece', 5, 1),
(2, 'C2 Greentea', 'c2_greentea_450ml', 43.00, 5, 'piece', 5, 1),
(3, 'C2 Lemon', 'c2_lemon_450ml', 46.00, 4, 'piece', 5, 1),
(4, 'Dove Men +care', 'dove_men clean_comfort', 213.00, 0, 'piece', 5, 1),
(5, '2D Image Barcode Scanner', '2d_barcode_scanner', 1225.72, 2, 'piece', 1, 1),
(6, 'Koko Krunch Econo Pack', 'koko_crunch_450g', 210.00, 14, 'box', 5, 1),
(7, ' Scenery Perfume', 'scenery_perfume_100ml', 2135.82, 5, 'bottle', 2, 1),
(8, '31-in-1 Electronic Screwdriver Set', '31_in_1 screwdriver', 152.00, 4, 'set', 2, 1),
(9, '3m Tape Measure', '3m_measure_tape', 53.00, 0, 'piece', 7, 1),
(10, 'Mini Rechargeable Flashlight', 'mini_flashlight', 213.00, 20, 'piece', 5, 1),
(11, 'Griffinberg Guitar', 'griffinberg_medium', 8729.00, 5, 'piece', 2, 1),
(12, 'Facial Tissue', 'face_tissue_120ply', 30.00, 50, 'piece', 10, 1),
(13, 'Xiaomi Sound Pocket', 'xiaomi_sound_pocker', 859.00, 2, 'piece', 2, 1),
(14, 'Panda Ballpen', 'panda_ballpen', 9.00, 200, 'piece', 20, 1),
(15, 'HDMI Cable 3m', 'hdmi_cable_3m', 290.00, 20, 'piece', 2, 1),
(16, 'Steam Deck OLED 512gb', 'steam_deck_oled_512gb', 42000.00, 2, 'set', 1, 1),
(17, 'Magnetic Phone Cooler', 'mag_phone_cooler', 690.00, 3, 'box', 2, 1);

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
(29, 'Restocking', 'Item ID: 3', '<strong>Restocked:</strong><br>C2 Lemon (+4 piece)', '2026-05-02 17:41:21'),
(30, 'Account Update', 'User ID: 1', '<strong>Updated Account:</strong><br>Type: Superadmin → Admin', '2026-05-03 07:10:53'),
(31, 'Account Update', 'User ID: 1', '<strong>Updated Account:</strong><br>No significant changes', '2026-05-03 07:12:20'),
(32, 'Item Creation', 'Item ID: 4', '<strong>Created:</strong><br>Item Name: Dove Men +care<br>Item Code: dove_men clean_comfort<br>Item Price: ₱213.00<br>Item Unit: piece<br>Current Stock: 20<br>Low Stock Level: 5', '2026-05-03 07:13:21'),
(33, 'Item Creation', 'Item ID: 5', '<strong>Created:</strong><br>Item Name: 2D Image Barcode Scanner<br>Item Code: 2d_barcode_scanner<br>Item Price: ₱1,225.72<br>Item Unit: piece<br>Current Stock: 2<br>Low Stock Level: 1', '2026-05-03 07:14:01'),
(34, 'Item Creation', 'Item ID: 6', '<strong>Created:</strong><br>Item Name: Koko Krunch Econo Pack<br>Item Code: koko_crunch_450g<br>Item Price: ₱210.00<br>Item Unit: box<br>Current Stock: 14<br>Low Stock Level: 5', '2026-05-03 07:15:32'),
(35, 'Item Creation', 'Item ID: 7', '<strong>Created:</strong><br>Item Name:  Scenery Perfume<br>Item Code: scenery_perfume_100ml<br>Item Price: ₱2,135.82<br>Item Unit: bottle<br>Current Stock: 5<br>Low Stock Level: 2', '2026-05-03 07:17:20'),
(36, 'Item Creation', 'Item ID: 8', '<strong>Created:</strong><br>Item Name: 31-in-1 Electronic Screwdriver Set<br>Item Code: 31_in_1 screwdriver<br>Item Price: ₱152.00<br>Item Unit: set<br>Current Stock: 4<br>Low Stock Level: 2', '2026-05-03 07:18:08'),
(37, 'Item Creation', 'Item ID: 9', '<strong>Created:</strong><br>Item Name: 3m Tape Measure<br>Item Code: 3m_measure_tape<br>Item Price: ₱53.00<br>Item Unit: piece<br>Current Stock: 20<br>Low Stock Level: 7', '2026-05-03 07:18:49'),
(38, 'Item Creation', 'Item ID: 10', '<strong>Created:</strong><br>Item Name: Mini Rechargeable Flashlight<br>Item Code: mini_flashlight<br>Item Price: ₱213.00<br>Item Unit: piece<br>Current Stock: 20<br>Low Stock Level: 5', '2026-05-03 07:19:29'),
(39, 'Item Creation', 'Item ID: 11', '<strong>Created:</strong><br>Item Name: Griffinberg Guitar<br>Item Code: griffinberg_medium<br>Item Price: ₱87,290.00<br>Item Unit: piece<br>Current Stock: 5<br>Low Stock Level: 2', '2026-05-03 07:21:41'),
(40, 'Sale Void', 'Sale Code: CO-0003', '<strong>Voided Sale:</strong><br>C2 Greentea (x1.00 piece)<br>C2 Lemon (x1.00 piece)', '2026-05-03 08:25:23'),
(41, 'Sale Restore', 'Sale Code: CO-0003', '<strong>Restored Sale:</strong><br>C2 Greentea (x1.00 piece)<br>C2 Lemon (x1.00 piece)', '2026-05-03 08:29:00'),
(42, 'Sale Item Void', 'Sale Code: CO-0003', '<strong>Voided Item:</strong><br>C2 Lemon (x1.00 piece)', '2026-05-03 08:29:58'),
(43, 'Item Updating', 'Item ID: 4', '<strong>Updated:</strong><br>Current Stock', '2026-05-03 11:03:42'),
(44, 'Item Updating', 'Item ID: 9', '<strong>Updated:</strong><br>Current Stock', '2026-05-03 11:03:50'),
(45, 'Item Updating', 'Item ID: 11', '<strong>Updated:</strong><br>Item Price', '2026-05-03 11:19:39'),
(46, 'Sale Item Restore', 'Sale Code: CO-0002', '<strong>Restored Item:</strong><br>C2 Apple (x2.00 piece)', '2026-05-03 11:28:11'),
(47, 'Item Creation', 'Item ID: 12', '<strong>Created:</strong><br>Item Name: Facial Tissue<br>Item Code: face_tissue_120ply<br>Item Price: ₱30.00<br>Item Unit: piece<br>Current Stock: 50<br>Low Stock Level: 10', '2026-05-03 13:21:43'),
(48, 'Item Creation', 'Item ID: 13', '<strong>Created:</strong><br>Item Name: Xiaomi Sound Pocket<br>Item Code: xiaomi_sound_pocker<br>Item Price: ₱859.00<br>Item Unit: piece<br>Current Stock: 2<br>Low Stock Level: 2', '2026-05-03 13:22:29'),
(49, 'Item Creation', 'Item ID: 14', '<strong>Created:</strong><br>Item Name: Panda Ballpen<br>Item Code: panda_ballpen<br>Item Price: ₱9.00<br>Item Unit: piece<br>Current Stock: 200<br>Low Stock Level: 20', '2026-05-03 13:23:03'),
(50, 'Item Creation', 'Item ID: 15', '<strong>Created:</strong><br>Item Name: HDMI Cable 3m<br>Item Code: hdmi_cable_3m<br>Item Price: ₱290.00<br>Item Unit: piece<br>Current Stock: 20<br>Low Stock Level: 2', '2026-05-03 13:23:39'),
(51, 'Item Creation', 'Item ID: 16', '<strong>Created:</strong><br>Item Name: Steam Deck OLED 512gb<br>Item Code: steam_deck_oled_512gb<br>Item Price: ₱42,000.00<br>Item Unit: set<br>Current Stock: 2<br>Low Stock Level: 1', '2026-05-03 13:24:46'),
(52, 'Item Creation', 'Item ID: 17', '<strong>Created:</strong><br>Item Name: Magnetic Phone Cooler<br>Item Code: mag_phone_cooler<br>Item Price: ₱690.00<br>Item Unit: box<br>Current Stock: 3<br>Low Stock Level: 2', '2026-05-03 13:25:42'),
(53, 'Sale Item Restore', 'Sale Code: CO-0003', '<strong>Restored Item:</strong><br>C2 Lemon (x1.00 piece)', '2026-05-03 13:34:15'),
(54, 'Sale Item Void', 'Sale Code: CO-0002', '<strong>Voided Item:</strong><br>C2 Apple (x2.00 piece)', '2026-05-03 13:35:31'),
(55, 'Sale Item Void', 'Sale Code: CO-0003', '<strong>Voided Item:</strong><br>C2 Lemon (x1.00 piece)', '2026-05-03 13:36:18'),
(56, 'Sale Item Restore', 'Sale Code: CO-0003', '<strong>Restored Item:</strong><br>C2 Lemon (x1.00 piece)', '2026-05-03 13:37:34'),
(57, 'Sale Item Void', 'Sale Code: CO-0003', '<strong>Voided Item:</strong><br>C2 Lemon (x1.00 piece)', '2026-05-03 13:38:24'),
(58, 'Sale Item Restore', 'Sale Code: CO-0003', '<strong>Restored Item:</strong><br>C2 Lemon (x1.00 piece)', '2026-05-03 13:38:36'),
(59, 'Account Creation', 'User ID: 10', '<strong>Created Account:</strong><br>Renzo Advincula (@grenjo8) [Admin]', '2026-05-03 13:55:04');

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
(9, 'rose', '$2y$10$.8d6XBljN4zvnjTqVtVkHuiX7tviEVL3uixE5Y5PtxMBi9ilB2qMW'),
(10, 'grenjo8', '$2y$10$XwwU7qilgamtTVQpGyoloOg.2XN11GxWsRZnMUSBreF8OEfQnDAhK');

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
(1, 'Saki Mart', '', 'Administrator', 'male', 'superadmin@sakimart.com', 8, 1),
(9, 'Sealthiel Rose', 'Nite', 'Advincula', 'female', 'rose@gmail.com', 2, 1),
(10, 'Renzo', 'Ferreras', 'Advincula', 'male', 'advincularenzo@gmail.com', 1, 1);

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
  MODIFY `pos_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pos_logs`
--
ALTER TABLE `pos_logs`
  MODIFY `pos_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `pos_restocking`
--
ALTER TABLE `pos_restocking`
  MODIFY `pos_restocking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
