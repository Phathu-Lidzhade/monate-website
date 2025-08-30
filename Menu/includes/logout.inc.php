<?php

/**
 * User Logout Handler
 * 
 * This file handles user logout by destroying the session
 * and redirecting to the sign-in page.
 */

require_once "../../api/config_session.inc.php";

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to sign-in page
header("Location: ../../sign in/signin.php");
die();
