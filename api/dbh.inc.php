<?php

/**
 * Database Connection Handler
 * 
 * This file manages the database connection using PDO
 * with proper error handling and security measures.
 */

declare(strict_types=1);

// Database configuration
$dsn = "mysql:host=localhost;dbname=food_ordering;charset=utf8mb4";
$dbusername = "root";
$dbpassword = "";

try {
  $pdo = new PDO($dsn, $dbusername, $dbpassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
  // Log error (in production, don't expose database details)
  error_log("Database connection failed: " . $e->getMessage());

  // Show user-friendly error
  die("Database connection failed. Please try again later.");
}
