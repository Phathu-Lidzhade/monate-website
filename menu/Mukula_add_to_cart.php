<?php
session_start();
require_once "../API/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ✅ Get logged-in user ID from session
    $userId = $_SESSION["user_id"] ?? null;

    if (!$userId) {
        // User not logged in → redirect to sign in
        header("Location: ../Sign in/index.php");
        exit;
    }

    // ✅ Get item data from POST
    $itemId    = $_POST["id"];
    $itemName  = $_POST["name"];
    $itemPrice = $_POST["price"];
    $itemQty   = $_POST["qty"];
    $itemSauce = $_POST["sauce"];
    $itemImg   = $_POST["img"];

    // ✅ Force branch to Mukula
    $branchLocation = "Mukula";

    // ✅ Insert into Cart (use user_id + branch_location)
    $stmt = $conn->prepare("
    INSERT INTO Cart (user_id, branch_location, item_id, name, price, quantity, sauce, image) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)
");


    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Types: i=int, s=string, d=double
    $stmt->bind_param("isisdiss",
        $userId,
        $branchLocation,
        $itemId,
        $itemName,
        $itemPrice,
        $itemQty,
        $itemSauce,
        $itemImg
    );

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    // ✅ Redirect back to Mukula menu
    header("Location: Mukula.php?id=" . urlencode($itemId));
    exit;
}
?>
