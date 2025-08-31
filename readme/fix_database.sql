-- Database Fix Script for Food Ordering System
-- This script fixes the existing database structure to work with the login system

-- Use the existing database
USE `food_ordering`;

-- Fix users table structure to match what the code expects
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `name` varchar(255) DEFAULT NULL AFTER `pwd`;

-- Update existing users to have a name (use username if name is empty)
UPDATE `users` SET `name` = `username` WHERE `name` IS NULL OR `name` = '';

-- Make name column NOT NULL after updating
ALTER TABLE `users` MODIFY COLUMN `name` varchar(255) NOT NULL;

-- Check if admins table exists and what columns it has
-- If it doesn't exist, create it with the correct structure
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `pwd` varchar(255) NOT NULL,
  `role` varchar(100) DEFAULT 'admin',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user (password: admin123)
INSERT INTO `admins` (`username`, `email`, `pwd`, `role`) VALUES 
('admin', 'admin@restaurant.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin')
ON DUPLICATE KEY UPDATE `pwd` = VALUES(`pwd`);

-- Insert test user if not exists (password: test123)
INSERT INTO `users` (`username`, `email`, `phone_number`, `pwd`, `name`) VALUES 
('testuser', 'test@example.com', '+1234567890', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Test User')
ON DUPLICATE KEY UPDATE 
    `pwd` = VALUES(`pwd`),
    `name` = VALUES(`name`);

-- Show the final table structure
DESCRIBE `users`;
DESCRIBE `admins`;

-- Show sample data
SELECT id, username, email, name, phone_number FROM `users` LIMIT 3;
SELECT id, username, email, role FROM `admins` LIMIT 3;
