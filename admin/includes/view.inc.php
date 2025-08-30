<?php

/**
 * Admin Authentication View Functions
 * 
 * This file contains functions for displaying admin authentication
 * interface elements and error messages.
 */

declare(strict_types=1);

/**
 * Display admin login errors if any exist
 */
function check_login_errors(): void
{
  if (isset($_SESSION["errors_admin"])) {
    $errors = $_SESSION["errors_admin"];

    echo "<br>";

    foreach ($errors as $error) {
      echo '<p class="form-error">' . htmlspecialchars($error) . '</p>';
    }

    unset($_SESSION["errors_admin"]);
  }
}
