<?php

/**
 * User View Functions
 * 
 * This file contains functions for displaying user interface
 * elements and error messages.
 */

declare(strict_types=1);

/**
 * Display signup errors if any exist
 */
function check_signup_errors(): void
{
  if (isset($_SESSION["errors_signup"])) {
    $errors = $_SESSION["errors_signup"];

    echo "<br>";

    foreach ($errors as $error) {
      echo '<p class="form-error">' . htmlspecialchars($error) . '</p>';
    }

    unset($_SESSION["errors_signup"]);
  }
}

/**
 * Display signup success message if signup was successful
 */
function check_signup_success(): void
{
  if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
    echo '<p class="form-success">Signup successful!</p>';
  }
}
