<?php

/**
 * Admin Authentication Controller Functions
 * 
 * This file contains validation logic for admin authentication
 * including input validation and password verification.
 */

declare(strict_types=1);

/**
 * Check if any required input fields are empty
 */
function is_input_empty(string $email, string $login_pwd): bool
{
  return empty($email) || empty($login_pwd);
}

/**
 * Validate email format
 */
function is_email_invalid(string $email): bool
{
  return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Check if email exists in database
 */
function is_email_wrong(array|bool $result): bool
{
  return !$result;
}

/**
 * Verify password against stored value
 * Note: This handles plain text passwords (not hashed)
 */
function is_password_wrong(string $login_pwd, string $pwd): bool
{
  // Since passwords are stored as plain text, compare directly
  return $login_pwd !== $pwd;
}
