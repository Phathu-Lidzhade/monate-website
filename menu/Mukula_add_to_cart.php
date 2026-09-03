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
    $itemId    = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    $itemName  = trim($_POST["name"] ?? "");
    $itemPrice = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT);
    $itemQty   = max(1, min(10, (int) ($_POST["qty"] ?? 1)));
    $itemSauce = trim($_POST["sauce"] ?? "NO SAUCE");
    $itemImg   = trim($_POST["img"] ?? "");

    if (!$itemId || $itemPrice === false || $itemName === "") {
        die("Invalid cart item.");
    }

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
