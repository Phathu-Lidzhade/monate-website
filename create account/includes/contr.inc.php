<?php

/**
 * User Controller Functions
 * 
 * This file contains validation logic for user input
 * and business logic for user management.
 */

declare(strict_types=1);

/**
 * Check if any required input fields are empty
 */
function is_input_empty(string $username, string $email, string $phone_number, string $pwd): bool
{
  return empty($username) || empty($email) || empty($phone_number) || empty($pwd);
}

/**
 * Validate email format
 */
function is_email_invalid(string $email): bool
{
  return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Check if username is already taken
 */
function is_username_take(object $pdo, string $username): bool
{
  return (bool) get_username($pdo, $username);
}

/**
 * Check if email is already registered
 */
function is_email_registered(object $pdo, string $email): bool
{
  return (bool) get_email($pdo, $email);
}

/**
 * Create a new user account
 */
function create_user(object $pdo, string $username, string $email, string $phone_number, string $pwd): void
{
  set_user($pdo, $username, $email, $phone_number, $pwd);
}
