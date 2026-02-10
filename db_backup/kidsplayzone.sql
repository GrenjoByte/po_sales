-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2025 at 03:02 AM
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
-- Database: `kidsplayzone`
--

-- --------------------------------------------------------

--
-- Table structure for table `client_profiles`
--

CREATE TABLE `client_profiles` (
  `client_id` int(11) NOT NULL,
  `guardian_name` varchar(100) NOT NULL,
  `guardian_contact` varchar(30) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `birthdate` date NOT NULL,
  `profile_image` text NOT NULL,
  `client_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_profiles`
--

INSERT INTO `client_profiles` (`client_id`, `guardian_name`, `guardian_contact`, `full_name`, `gender`, `birthdate`, `profile_image`, `client_status`) VALUES
(1, 'Renzo Advincula', '0992-203-2198', 'Sealthiel Rose Advincula', 'F', '2022-01-12', 'profile_1763751258.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_checkouts`
--

CREATE TABLE `pos_checkouts` (
  `pos_checkout_id` int(11) NOT NULL,
  `pos_checkout_code` varchar(50) NOT NULL,
  `pos_item_id` int(11) NOT NULL,
  `pos_item_name` varchar(255) NOT NULL,
  `pos_item_price` decimal(10,2) NOT NULL,
  `pos_item_count` int(11) NOT NULL,
  `pos_item_unit` varchar(50) NOT NULL,
  `pos_item_image` varchar(255) DEFAULT NULL,
  `pos_item_subtotal` decimal(10,2) NOT NULL,
  `pos_checkout_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pos_inventory`
--

CREATE TABLE `pos_inventory` (
  `pos_item_id` int(11) NOT NULL,
  `pos_item_name` varchar(200) NOT NULL,
  `pos_item_price` decimal(10,2) NOT NULL,
  `pos_item_image` text NOT NULL,
  `pos_item_stock` int(11) NOT NULL,
  `pos_item_unit` varchar(10) NOT NULL,
  `pos_item_low` int(11) NOT NULL,
  `pos_item_status` int(11) NOT NULL DEFAULT 1
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
-- Table structure for table `time_logs`
--

CREATE TABLE `time_logs` (
  `log_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `activity` text NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_logs`
--

INSERT INTO `time_logs` (`log_id`, `client_id`, `activity`, `time_stamp`) VALUES
(1, 1, '<strong>Account Created</strong>', '2025-11-21 18:54:18');

-- --------------------------------------------------------

--
-- Table structure for table `time_manager`
--

CREATE TABLE `time_manager` (
  `client_id` int(11) NOT NULL,
  `time_date` date DEFAULT NULL,
  `start_time` time NOT NULL,
  `rate_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_rates`
--

CREATE TABLE `time_rates` (
  `rate_id` int(11) NOT NULL,
  `hour` int(11) NOT NULL,
  `minute` int(11) NOT NULL,
  `price` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_rates`
--

INSERT INTO `time_rates` (`rate_id`, `hour`, `minute`, `price`) VALUES
(0, 0, 0, 350.00),
(1, 1, 0, 180.00),
(2, 0, 30, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `time_reports`
--

CREATE TABLE `time_reports` (
  `report_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `time` varchar(10) NOT NULL,
  `rate` float NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_profiles`
--
ALTER TABLE `client_profiles`
  ADD PRIMARY KEY (`client_id`);

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
-- Indexes for table `time_logs`
--
ALTER TABLE `time_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `time_manager`
--
ALTER TABLE `time_manager`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `time_rates`
--
ALTER TABLE `time_rates`
  ADD PRIMARY KEY (`rate_id`);

--
-- Indexes for table `time_reports`
--
ALTER TABLE `time_reports`
  ADD PRIMARY KEY (`report_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client_profiles`
--
ALTER TABLE `client_profiles`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pos_checkouts`
--
ALTER TABLE `pos_checkouts`
  MODIFY `pos_checkout_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pos_inventory`
--
ALTER TABLE `pos_inventory`
  MODIFY `pos_item_id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `time_logs`
--
ALTER TABLE `time_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `time_manager`
--
ALTER TABLE `time_manager`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_rates`
--
ALTER TABLE `time_rates`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `time_reports`
--
ALTER TABLE `time_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
