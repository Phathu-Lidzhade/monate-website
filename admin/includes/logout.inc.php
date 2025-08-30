<?php

/**
 * Admin Logout Handler
 * 
 * This file handles admin logout by destroying the session
 * and redirecting to the admin login page.
 */

require_once "../../api/config_session.inc.php";

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to admin login page
header("Location: ../admin-login.php");
die();
