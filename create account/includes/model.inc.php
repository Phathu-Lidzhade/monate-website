<?php

/**
 * User Model Functions
 * 
 * This file contains database operations for user management
 * including username/email checks and user creation.
 */

declare(strict_types=1);

/**
 * Check if username already exists in database
 */
function get_username(object $pdo, string $username): array|false
{
  $query = "SELECT username FROM users WHERE username = :username;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":username", $username);
  $stmt->execute();

  return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Check if email already exists in database
 */
function get_email(object $pdo, string $email): array|false
{
  $query = "SELECT email FROM users WHERE email = :email;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":email", $email);
  $stmt->execute();

  return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Create a new user in the database
 */
function set_user(object $pdo, string $username, string $email, string $phone_number, string $pwd): void
{
  $query = "INSERT INTO users (username, email, phone_number, pwd) VALUES (:username, :email, :phone_number, :pwd);";

  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":username", $username);
  $stmt->bindParam(":email", $email);
  $stmt->bindParam(":phone_number", $phone_number);
  $stmt->bindParam(":pwd", $pwd);

  $stmt->execute();
}
