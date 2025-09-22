<?php
// admin/includes/control.php
// Controller for admin add-item behaviour, safe includes and session checks

if (session_status() === PHP_SESSION_NONE) session_start();

// require DB, adjust path so this file is robust when included from index.php
require_once __DIR__ . '/../../../API/db.php';
require_once __DIR__ . '/model.php';

// Check if admin is logged in 
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../Sign in/index.php");
    exit();
}

$message = "";
$adminEmail = $_SESSION["email"] ?? null;
$branchLocation = $_SESSION["branch_location"] ?? null;

// Handle add menu item POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_menu_item'])) {
    $name = $_POST["name"] ?? "";
    $price = $_POST["price"] ?? "";
    $description = $_POST["description"] ?? "";
    $category = $_POST["category"] ?? "";

    // Handle image upload, same behaviour as your original code
    $imageName = null;
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $imageName = uniqid("menu_", true) . "." . $ext;

        $targetDir = __DIR__ . "/../../menu_item/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetPath = $targetDir . $imageName;
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {
            $message = "Failed to move uploaded file.";
            // continue, but $imageName may be null and DB will get null
        }
    }

    // Call model to insert
    $insertResult = insertMenuItem($conn, $name, $price, $description, $category, $imageName, $branchLocation);

    if ($insertResult === true) {
        // success, redirect back to admin index
        header("Location: ../index.php");
        exit();
    } else {
        // model returns error string on failure
        $message = "Error: " . $insertResult;
    }
}

// Expose $message and other variables to the view
// index.php should include this controller first, then include view.php or render the HTML
