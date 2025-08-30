<?php

/**
 * Admin Login Form Handler
 * 
 * This file processes the admin login form submission,
 * validates credentials, and manages authentication.
 */

declare(strict_types=1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"] ?? '';
  $login_pwd = $_POST["password"] ?? '';

  try {
    require_once "../../api/dbh.inc.php";
    require_once "model.inc.php";
    require_once "view.inc.php";
    require_once "contr.inc.php";

    $errors = [];

    // Validate input fields
    if (is_input_empty($email, $login_pwd)) {
      $errors["empty_input"] = "Fill in all fields";
    }

    if (is_email_invalid($email)) {
      $errors["invalid_email"] = "Invalid email used";
    }

    // Get admin from database
    $result = get_admin($pdo, $email);

    if (is_email_wrong($result)) {
      $errors["login_incorrect"] = "Incorrect login info";
    }

    if (!is_email_wrong($result) && is_password_wrong($login_pwd, $result["pwd"])) {
      $errors["login_incorrect"] = "Incorrect login info";
    }

    require_once "../../api/config_session.inc.php";

    if ($errors) {
      $_SESSION["errors_admin"] = $errors;
      header("Location: ../admin-login.php");
      die();
    }

    // Create secure session
    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $result["id"];
    session_id($sessionId);

    // Set admin session variables
    $_SESSION["admin_id"] = $result["id"];
    $_SESSION["admin_name"] = htmlspecialchars($result["name"]);
    $_SESSION["admin_email"] = htmlspecialchars($result["email"]);
    $_SESSION["admin_role"] = "admin"; // Default role since table doesn't have it
    $_SESSION["last_regeneration"] = time();

    // Clean up and redirect
    $pdo = null;
    $stmt = null;

    header("Location: ../admin-dashboard.php");
    die();
  } catch (PDOException $e) {
    error_log("Admin login query failed: " . $e->getMessage());
    die("Login failed. Please try again later.");
  }
} else {
  header("Location: ../admin-login.php");
  die();
}
