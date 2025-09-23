<?php
// admin/delete_item.php
session_start();
require_once __DIR__ . '/../../../API/db.php';
require_once __DIR__ . '/model.php';

// permission check
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../Sign in/index.php");
    exit();
}

if (!isset($_GET["id"])) {
    echo "Invalid request";
    exit();
}

$id = intval($_GET["id"]);
$branchLocation = $_SESSION["branch_location"] ?? "";

$deleteResult = deleteMenuItem($conn, $id, $branchLocation);

if ($deleteResult === true) {
    // Redirect back to admin index (or wherever you prefer)
    header("Location: ../index.php");
    exit();
} else {
    echo "Error deleting item: " . htmlspecialchars($deleteResult);
}
