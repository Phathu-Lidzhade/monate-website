<?php
session_start();
require_once "../API/db.php";

// Ensure user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../Sign in/index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cart_id"])) {
    $cartId = intval($_POST["cart_id"]);
    $userId = $_SESSION["user_id"];

    // Delete only if the item belongs to this user
    $stmt = $conn->prepare("DELETE FROM Cart WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cartId, $userId);

    if ($stmt->execute()) {
        // Success: redirect back to cart
        header("Location: cart.php");
        exit;
    } else {
        echo "Error removing item from cart.";
    }
} else {
    // Invalid access: redirect
    header("Location: cart.php");
    exit;
}
