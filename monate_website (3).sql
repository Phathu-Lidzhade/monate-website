-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2026 at 04:05 PM
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
(54, 2, 'Thohoyandou', 1, 'fried chicken', 50.00, 1, 'MILD', '../admin/menu_item/menu_68ca41d43b56e2.87343729.jpg', '2025-09-22 09:52:37'),
(62, 3, 'Mukula', 3, 'fried chicken', 50.00, 1, 'NO SAUCE', '../admin/menu_item/menu_68cc2810ccf732.58742028.jpg', '2025-09-22 10:09:20'),
(68, 1, 'Thohoyandou', 1, 'fried chicken', 50.00, 1, 'HOT', '../admin/menu_item/menu_68ca41d43b56e2.87343729.jpg', '2025-09-23 07:44:57'),
(69, 1, 'Thohoyandou', 12, 'Fried chicken', 50.00, 1, 'HOT', '../admin/menu_item/menu_68d1b9a8720976.50599190.jpg', '2025-09-23 07:45:27');

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
(3, 'fried chicken', 50.00, 'chips . chicken . tomato', 'CHICKEN', 'menu_68cc2810ccf732.58742028.jpg', 'Mukula', '2025-09-18 15:41:04'),
(4, 'fried chicken', 50.00, 'Small Chips . 1 chicken . tomato', 'CHICKEN', 'menu_68cc4c26d7f0a8.62031450.jpg', 'Lufule', '2025-09-18 18:15:02'),
(5, 'Coke ', 12.00, 'Coke', 'DRINKS', 'menu_68d1b6872ccab6.78529436.jpeg', 'Thohoyandou', '2025-09-22 20:50:15'),
(6, 'Sprite', 12.00, 'drink', 'DRINKS', 'menu_68d1b6a7b22218.70163366.jpg', 'Thohoyandou', '2025-09-22 20:50:47'),
(7, 'Fanta', 12.00, 'drink', 'DRINKS', 'menu_68d1b6c265e213.19962498.jpg', 'Thohoyandou', '2025-09-22 20:51:14'),
(8, 'Dragon', 10.00, 'energy drink', 'DRINKS', 'menu_68d1b7238d06f4.39687029.jpg', 'Thohoyandou', '2025-09-22 20:52:51'),
(9, 'switch', 10.00, 'energy drink', 'DRINKS', 'menu_68d1b7aa089515.26965332.png', 'Thohoyandou', '2025-09-22 20:55:06'),
(10, 'Hot wings ', 40.00, '4 Wings', 'WINGS', 'menu_68d1b8604d4183.33244774.jpg', 'Thohoyandou', '2025-09-22 20:58:08'),
(11, 'KOTA 1', 40.00, 'Small ', 'KOTA', 'menu_68d1b942074062.87849063.webp', 'Thohoyandou', '2025-09-22 21:01:54'),
(12, 'Fried chicken', 50.00, 'Fried chicken and vors', 'CHICKEN', 'menu_68d1b9a8720976.50599190.jpg', 'Thohoyandou', '2025-09-22 21:03:36'),
(13, 'Big T', 100.00, 'sharing meal', 'SHARING', 'menu_68d1bd09af1140.47287620.jpg', 'Thohoyandou', '2025-09-22 21:18:01'),
(15, 'Big t 2', 100.00, 'Sharing meal', 'SHARING', 'menu_68d1bdb1aa08b1.83286496.jpg', 'Thohoyandou', '2025-09-22 21:20:50'),
(16, 'coke', 12.00, 'drink', 'DRINKS', 'menu_68d1bf8eaf9332.84125373.jpeg', 'Mukula', '2025-09-22 21:28:46'),
(17, 'sprite', 12.00, 'drink', 'DRINKS', 'menu_68d1bfafe1e2c2.12517351.jpg', 'Mukula', '2025-09-22 21:29:19'),
(18, 'switch', 10.00, 'energy drink', 'DRINKS', 'menu_68d1c001d878d0.47781167.png', 'Mukula', '2025-09-22 21:30:41');

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
(13, 1, 'Mukula', 'pickup', '', '', '', '', '', '', '0730243864', 0.00, 0.00, '0', 100.00, '2025-09-18 18:00:04', 'Delivered'),
(14, 1, 'Thohoyandou', 'pickup', '', '', '', '', '', '', '0664453336', 0.00, 0.00, '0', 200.00, '2025-09-18 18:01:08', 'Pending'),
(15, 1, 'Thohoyandou', 'pickup', '', '', '', '', '', '', '0664453336', 0.00, 0.00, '0', 200.00, '2025-09-18 18:02:15', 'Pending'),
(16, 1, 'Thohoyandou', 'pickup', '', '', '', '', '', '', '0745148725', 0.00, 0.00, '0', 200.00, '2025-09-18 18:02:33', 'Pending'),
(17, 1, 'Lufule', 'pickup', '', '', '', '', '', '', '0745148725', 50.00, 0.00, '0', 100.00, '2025-09-18 18:15:47', 'Pending'),
(18, 1, 'Thohoyandou', 'pickup', '', '', '', '', '', '', '0745148725', 0.00, 0.00, '0', 150.00, '2025-09-22 09:33:34', 'Pending'),
(19, 3, 'Thohoyandou', 'pickup', '', '', '', '', '', '', '0730243864', 0.00, 0.00, '0', 50.00, '2025-09-22 10:07:44', 'Pending'),
(20, 1, 'Thohoyandou', 'pickup', '', '', '', '', '', '', '0730243864', 0.00, 0.00, '0', 100.00, '2025-09-22 19:23:05', 'Pending'),
(21, 3, 'Thohoyandou', 'pickup', '', '', '', '', '', '', '0', 0.00, 0.00, '0', 200.00, '2025-09-22 20:18:48', 'Ready'),
(22, 1, 'Thohoyandou', 'delivery', 'westgate univen street', 'Thohoyandou', 'Thohoyandou', 'Shayandima', '0945', 'fi7dtucg', '0', 0.00, 20.00, '0', 220.00, '2025-09-22 20:34:15', 'Delivered'),
(23, 5, 'Thohoyandou', 'delivery', 'westgate univen street', 'hviy', 'Thohoyandou', 'hf9;7', '0945', 'r97r7', '0664453336', 50.00, 20.00, '0', 110.00, '2025-09-23 09:27:40', 'Delivered');

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
(15, 17, 4, 'fried chicken', 50.00, 1, '0', '../admin/menu_item/menu_68cc4c26d7f0a8.62031450.jpg'),
(16, 18, 1, 'fried chicken', 50.00, 3, '0', '../admin/menu_item/menu_68ca41d43b56e2.87343729.jpg'),
(17, 19, 1, 'fried chicken', 50.00, 1, '0', '../admin/menu_item/menu_68ca41d43b56e2.87343729.jpg'),
(18, 20, 1, 'fried chicken', 50.00, 2, '0', '../admin/menu_item/menu_68ca41d43b56e2.87343729.jpg'),
(19, 21, 1, 'fried chicken', 50.00, 2, '0', '../admin/menu_item/menu_68ca41d43b56e2.87343729.jpg'),
(20, 21, 2, 'fried chicken', 50.00, 2, '0', '../admin/menu_item/menu_68cc17265afb18.41821459.jpg'),
(21, 22, 1, 'fried chicken', 50.00, 2, '0', '../admin/menu_item/menu_68ca41d43b56e2.87343729.jpg'),
(22, 22, 2, 'fried chicken', 50.00, 2, '0', '../admin/menu_item/menu_68cc17265afb18.41821459.jpg'),
(23, 23, 10, 'Hot wings ', 40.00, 1, '0', '../admin/menu_item/menu_68d1b8604d4183.33244774.jpg');

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
(1, 'MrBuku', 'akonahombedzi4@gmail.com', '0730243864', '2004-06-22', '$2y$10$CZtoZK2u9rJiXiJxB825F.YkzIQSFgbWZMqIa00HXRrIowdgqpsZS', '2025-09-17 04:49:38'),
(2, 'Akonaho', 'ako@gmail.com', '00', '2007-01-01', '$2y$10$.NNxqmIh/5mhhnRh6Ty9IOKTYKKcc7t9J1lSASDrrzjZHMsElid6.', '2025-09-22 09:51:56'),
(3, 'tendi', 'tendani0318@gmail.com', '0727589041', '2003-11-18', '$2y$10$Mpo2a2lwa6iMMFCOHu/d5uj4y5ZePpMnN2Qs4SAIPmDVT8UCvZbuC', '2025-09-22 10:01:09'),
(4, '2', '2@mm', '0', '2000-06-20', '$2y$10$SoHpjOTsTmN2JaeT4prmA.xD0zJ9OfkFDvnkSYE1h1DexzF75iYCm', '2025-09-22 10:26:09'),
(5, 'Ras', 'Ras@gmail.com', '07270863331a', '2007-12-31', '$2y$10$Vqj.yVvEMq.Zfp9YQwmuv..NAof2yWKWcK1YZMMLefZpqgTNB1VVy', '2025-09-23 09:24:54');

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
  ADD UNIQUE KEY `unique_cart_item` (`user_id`,`item_id`),
  ADD UNIQUE KEY `unique_user_item_branch` (`user_id`,`item_id`,`branch_location`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `menuitems`
--
ALTER TABLE `menuitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
