<?php

/**
 * Admin Model Functions
 * 
 * This file contains database operations for admin authentication
 * including admin lookup by email.
 */

declare(strict_types=1);

/**
 * Get admin information by email address
 */
function get_admin(object $pdo, string $email): array|false
{
  $query = "SELECT * FROM admins WHERE email = :email;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":email", $email);
  $stmt->execute();

  return $stmt->fetch(PDO::FETCH_ASSOC);
}
