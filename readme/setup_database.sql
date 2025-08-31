-- Database Setup Script for Food Ordering System
-- This script sets up the database structure and adds test data for login testing

-- Use the existing database
USE `food_ordering`;

-- Insert test admin user (password: admin123)
INSERT INTO `admin` (`name`, `email`, `pwd`) VALUES 
('Admin User', 'admin@restaurant.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE `pwd` = VALUES(`pwd`);

-- Insert test user (password: test123)
INSERT INTO `users` (`username`, `email`, `pwd`, `phone_number`) VALUES 
('testuser', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1234567890')
ON DUPLICATE KEY UPDATE `pwd` = VALUES(`pwd`);

-- Show the final table structure
DESCRIBE `users`;
DESCRIBE `admin`;

-- Show sample data
SELECT id, username, email, phone_number FROM `users` LIMIT 3;
SELECT id, name, email FROM `admin` LIMIT 3;
