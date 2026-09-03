<?php
session_start();
require_once "../API/db.php";

if (!isset($_SESSION["user_id"])) {
    die("User not logged in");
}

$userId = $_SESSION["user_id"];

// ✅ Branch from POST or GET
$branch = $_POST["branch"] ?? ($_GET["branch"] ?? null);
if (!$branch) {
    die("No branch specified");
}

// Get form values
$orderType    = $_POST["orderType"];
$street       = $_POST["street"] ?? null;
$building     = $_POST["building"] ?? null;
$town         = $_POST["town"] ?? null;
$suburb       = $_POST["suburb"] ?? null;
$postal       = $_POST["postal"] ?? null;
$instructions = $_POST["instructions"] ?? null;
$phone        = $_POST["phone"];
$tip          = $_POST["tip"] ?? 0;
$payment      = $_POST["payment"];
$baseTotal    = $_POST["baseTotal"] ?? 0;
$deliveryCost = ($orderType === "delivery") ? 20 : 0;
$totalAmount  = $baseTotal + $deliveryCost + $tip;

// ✅ Insert into orders
$stmt = $conn->prepare("
    INSERT INTO orders (
        user_id, branch_location, order_type, street, building, town, suburb, postal, 
        instructions, phone, tip, delivery_cost, payment_method, total_amount, status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')
");
$stmt->bind_param(
    "issssssssssdds",
    $userId, $branch, $orderType, $street, $building, $town, $suburb, $postal,
    $instructions, $phone, $tip, $deliveryCost, $payment, $totalAmount
);
$stmt->execute();
$orderId = $stmt->insert_id;
$stmt->close();

// ✅ Fetch cart items for this user & branch
$stmt = $conn->prepare("
    SELECT item_id, name, price, quantity, sauce, image
    FROM Cart 
    WHERE user_id = ? AND branch_location = ?
");
$stmt->bind_param("is", $userId, $branch);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $itemStmt = $conn->prepare("
        INSERT INTO order_items (order_id, item_id, name, price, quantity, sauce, image)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $itemStmt->bind_param(
        "iisdiis",
        $orderId, $row["item_id"], $row["name"], $row["price"], $row["quantity"], $row["sauce"], $row["image"]
    );
    $itemStmt->execute();
    $itemStmt->close();
}
$stmt->close();

// ✅ Clear cart
$deleteStmt = $conn->prepare("DELETE FROM Cart WHERE user_id = ? AND branch_location = ?");
$deleteStmt->bind_param("is", $userId, $branch);
$deleteStmt->execute();
$deleteStmt->close();

// Redirect
header("Location: order_success.php?order_id=" . $orderId);
exit;
