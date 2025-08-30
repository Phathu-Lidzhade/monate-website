<?php

/**
 * Session Configuration and Management
 * 
 * This file handles secure session configuration and regeneration
 * for both logged-in and anonymous users.
 */

declare(strict_types=1);

// Secure session configuration
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_samesite', 'Strict');

// Set secure session cookie parameters
session_set_cookie_params([
  'lifetime' => 1800, // 30 minutes
  'domain' => 'localhost',
  'path' => '/',
  'secure' => true,
  'httponly' => true,
  'samesite' => 'Strict'
]);

// Start session
session_start();

// Session regeneration logic
if (isset($_SESSION["user_id"]) || isset($_SESSION["admin_id"])) {
  if (!isset($_SESSION["last_regeneration"])) {
    regenerate_session_id_loggedin();
  } else {
    $interval = 60 * 30; // 30 minutes

    if (time() - $_SESSION["last_regeneration"] >= $interval) {
      regenerate_session_id_loggedin();
    }
  }
} else {
  if (!isset($_SESSION["last_regeneration"])) {
    regenerate_session_id();
  } else {
    $interval = 60 * 30; // 30 minutes

    if (time() - $_SESSION["last_regeneration"] >= $interval) {
      regenerate_session_id();
    }
  }
}

/**
 * Regenerate session ID for logged-in users
 */
function regenerate_session_id_loggedin(): void
{
  session_regenerate_id(true);

  $userId = $_SESSION["user_id"] ?? $_SESSION["admin_id"] ?? null;

  if ($userId) {
    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $userId;
    session_id($sessionId);
  }

  $_SESSION["last_regeneration"] = time();
}

/**
 * Regenerate session ID for anonymous users
 */
function regenerate_session_id(): void
{
  session_regenerate_id(true);
  $_SESSION["last_regeneration"] = time();
}
