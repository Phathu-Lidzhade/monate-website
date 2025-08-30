<?php

/**
 * Password Update Handler
 * 
 * This file handles password updates for users who have
 * forgotten their passwords.
 */

declare(strict_types=1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"] ?? '';
  $email = $_POST["email"] ?? '';
  $phone_number = $_POST["phone_number"] ?? '';
  $pwd = $_POST["password"] ?? '';

  // Validate required fields
  if (empty($username) || empty($email) || empty($phone_number) || empty($pwd)) {
    header("Location: ../index.html?error=missing_fields");
    die();
  }

  try {
    require_once "../../api/dbh.inc.php";

    // First verify the user exists with the provided credentials
    $verifyQuery = "SELECT id FROM users WHERE username = :username AND email = :email AND phone_number = :phone_number;";
    $verifyStmt = $pdo->prepare($verifyQuery);
    $verifyStmt->bindParam(":username", $username);
    $verifyStmt->bindParam(":email", $email);
    $verifyStmt->bindParam(":phone_number", $phone_number);
    $verifyStmt->execute();

    if (!$verifyStmt->fetch()) {
      header("Location: ../index.html?error=invalid_credentials");
      die();
    }

    // Hash the new password
    $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);

    // Update the password
    $updateQuery = "UPDATE users SET pwd = :pwd WHERE username = :username AND email = :email AND phone_number = :phone_number;";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindParam(":pwd", $hashedPassword);
    $updateStmt->bindParam(":username", $username);
    $updateStmt->bindParam(":email", $email);
    $updateStmt->bindParam(":phone_number", $phone_number);
    $updateStmt->execute();

    $pdo = null;
    $verifyStmt = null;
    $updateStmt = null;

    header("Location: ../index.html?success=password_updated");
    die();
  } catch (PDOException $e) {
    error_log("Password update failed: " . $e->getMessage());
    header("Location: ../index.html?error=update_failed");
    die();
  }
} else {
  header("Location: ../index.html");
  die();
}
