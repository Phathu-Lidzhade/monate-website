<?php
// sign in/includes/control.php (controller for About page)
// Start session and prepare any variables that the view will display

// include model (kept for MVC structure, even if no DB logic needed here)
require_once __DIR__ . '/model.php';

// start session (only once, controller handles it)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// prepare username variable for view
// keeping same behavior as original: show username when set in session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
