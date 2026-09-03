-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2025 at 08:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monate_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `branch_location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `branch_location`, `created_at`) VALUES
(1, 'Thohoyandou_admin@example.com', '123', 'Thohoyandou', '2025-09-17 04:57:02'),
(2, 'Mukula_admin@example.com', '123', 'Mukula', '2025-09-17 04:57:02'),
(3, 'Lufule_admin@example.com', '123', 'Lufule', '2025-09-17 04:57:02');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_location` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `sauce` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `branch_location`, `item_id`, `name`, `price`, `quantity`, `sauce`, `image`, `created_at`) VALUES
(50, 1, 'Mukula', 3, 'fried chicken', 50.00, 1, 'MILD', '../admin/menu_item/menu_68cc2810ccf732.58742028.jpg', '2025-09-18 22:36:29'),
(51, 1, 'Lufule', 4, 'fried chicken', 50.00, 1, 'BBQ', '../admin/menu_item/menu_68cc4c26d7f0a8.62031450.jpg', '2025-09-18 22:36:40'),
(52, 1, 'Thohoyandou', 1, 'fried chicken', 50.00, 2, 'MILD', '../admin/menu_item/menu_68ca41d43b56e2.87343729.jpg', '2025-09-18 22:46:38');

-- --------------------------------------------------------

--
-- Table structure for table `menuitems`
--

CREATE TABLE `menuitems` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `branch_location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menuitems`
--

INSERT INTO `menuitems` (`id`, `name`, `price`, `description`, `category`, `image`, `branch_location`, `created_at`) VALUES
(1, 'fried chicken', 50.00, 'Chichen . chips . tomato', 'CHICKEN', 'menu_68ca41d43b56e2.87343729.jpg', 'Thohoyandou', '2025-09-17 05:06:28'),
(2, 'fried chicken', 50.00, 'kb0u', 'SHARING', 'menu_68cc17265afb18.41821459.jpg', 'Thohoyandou', '2025-09-18 14:28:54'),
(3, 'fried chicken', 50.00, 'chips . chicken . tomato', 'CHICKEN', 'menu_68cc2810ccf732.58742028.jpg', 'Mukula', '2025-09-18 15:41:04'),
(4, 'fried chicken', 50.00, 'Small Chips . 1 chicken . tomato', 'CHICKEN', 'menu_68cc4c26d7f0a8.62031450.jpg', 'Lufule', '2025-09-18 18:15:02');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_location` varchar(255) NOT NULL,
  `order_type` enum('pickup','delivery') NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `building` varchar(255) DEFAULT NULL,
  `town` varchar(100) DEFAULT NULL,
  `suburb` varchar(100) DEFAULT NULL,
  `postal` varchar(20) DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `tip` decimal(10,2) DEFAULT 0.00,
  `delivery_cost` decimal(10,2) DEFAULT 0.00,
  `payment_method` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Ready','Delivered') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `branch_location`, `order_type`, `street`, `building`, `town`, `suburb`, `postal`, `instructions`, `phone`, `tip`, `delivery_cost`, `payment_method`, `total_amount`, `created_at`, `status`) VALUES
(13, 1, 'Mukula', 'pickup', '', '', '', '', '', '', '0730243864', 0.00, 0.00, '0', 100.00, '2025-09-18 18:00:04', 'Pending'),
(14, 1, 'Thohoyandou', 'pickup', '', '', '', '', '', '', '0664453336', 0.00, 0.00, '0', 200.00, '2025-09-18 18:01:08', 'Pending'),
(15, 1, 'Thohoyandou', 'pickup', '', '', '', '', '', '', '0664453336', 0.00, 0.00, '0', 200.00, '2025-09-18 18:02:15', 'Pending'),
(16, 1, 'Thohoyandou', 'pickup', '', '', '', '', '', '', '0745148725', 0.00, 0.00, '0', 200.00, '2025-09-18 18:02:33', 'Pending'),
(17, 1, 'Lufule', 'pickup', '', '', '', '', '', '', '0745148725', 50.00, 0.00, '0', 100.00, '2025-09-18 18:15:47', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `sauce` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `item_id`, `name`, `price`, `quantity`, `sauce`, `image`) VALUES
(12, 13, 3, 'fried chicken', 50.00, 2, '0', '../admin/menu_item/menu_68cc2810ccf732.58742028.jpg'),
(13, 14, 1, 'fried chicken', 50.00, 4, '0', '../admin/menu_item/menu_68ca41d43b56e2.87343729.jpg'),
(14, 16, 1, 'fried chicken', 50.00, 4, '0', '../admin/menu_item/menu_68ca41d43b56e2.87343729.jpg'),
(15, 17, 4, 'fried chicken', 50.00, 1, '0', '../admin/menu_item/menu_68cc4c26d7f0a8.62031450.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `mobile`, `dob`, `password`, `created_at`) VALUES
(1, 'MrBuku', 'akonahombedzi4@gmail.com', '0730243864', '2004-06-22', '$2y$10$CZtoZK2u9rJiXiJxB825F.YkzIQSFgbWZMqIa00HXRrIowdgqpsZS', '2025-09-17 04:49:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cart` (`user_id`,`branch_location`,`item_id`,`sauce`);

--
-- Indexes for table `menuitems`
--
ALTER TABLE `menuitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `menuitems`
--
ALTER TABLE `menuitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
