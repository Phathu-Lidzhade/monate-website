<?php

/**
 * User Authentication Model Functions
 * 
 * This file contains database operations for user authentication
 * including user lookup by email.
 */

declare(strict_types=1);

/**
 * Get user information by email address
 */
function get_user(object $pdo, string $email): array|false
{
  $query = "SELECT * FROM users WHERE email = :email;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":email", $email);
  $stmt->execute();

  return $stmt->fetch(PDO::FETCH_ASSOC);
}
