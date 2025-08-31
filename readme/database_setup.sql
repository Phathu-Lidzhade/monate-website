-- Food Ordering System Database Setup
-- Run this script in your MySQL database to create all necessary tables

-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS `food_ordering` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE `food_ordering`;

-- Create users table
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL UNIQUE,
  `email` varchar(255) NOT NULL UNIQUE,
  `phone_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_email` (`email`),
  INDEX `idx_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create admins table
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) DEFAULT 'admin',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user (password: admin123)
INSERT INTO `admins` (`name`, `email`, `password`, `role`) VALUES 
('Admin User', 'admin@restaurant.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin')
ON DUPLICATE KEY UPDATE `password` = VALUES(`password`);

-- Create sample user for testing (password: test123)
INSERT INTO `users` (`username`, `email`, `phone_number`, `password`, `name`) VALUES 
('testuser', 'test@example.com', '+1234567890', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Test User')
ON DUPLICATE KEY UPDATE `password` = VALUES(`password`);

-- Show table structure for verification
DESCRIBE `users`;
DESCRIBE `admins`;

-- Show sample data
SELECT `id`, `username`, `email`, `name` FROM `users` LIMIT 5;
SELECT `id`, `name`, `email`, `role` FROM `admins` LIMIT 5;
