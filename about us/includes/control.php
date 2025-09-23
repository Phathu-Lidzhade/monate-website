<?php
require_once __DIR__ . '/model.php';

// start session (only once, controller handles it)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// prepare username variable for view

$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
