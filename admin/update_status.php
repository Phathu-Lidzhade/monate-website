<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden"]);
    exit();
}

require_once "../API/db.php"; // adjust if needed

$adminBranch = $_SESSION['branch_location'] ?? null;

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit();
}

$id = intval($_POST['id'] ?? 0);
$status = $_POST['status'] ?? '';

$allowed = ["Pending","Ready","Delivered"];
if (!$id || !in_array($status, $allowed)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit();
}

// Detect branch column on orders
$branchColumnOrders = null;
$candidates = ['branch_location','branch','store','branch_name','location'];
foreach ($candidates as $c) {
    $r = $conn->query("SHOW COLUMNS FROM `orders` LIKE '$c'");
    if ($r && $r->num_rows > 0) {
        $branchColumnOrders = $c;
        break;
    }
}

if ($branchColumnOrders && $adminBranch) {
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ? AND `{$branchColumnOrders}` = ?");
    $stmt->bind_param("sis", $status, $id, $adminBranch);
} else {
    // If no branch column exists, update normally (but ideally you should have branch isolation)
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
}

if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => $conn->error]);
    exit;
}

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true]);
    } else {
        // either order doesn't exist or doesn't belong to this admin's branch
        http_response_code(403);
        echo json_encode(["error" => "No permission to update this order or order not found"]);
    }
} else {
    http_response_code(500);
    echo json_encode(["error" => $stmt->error]);
}

$stmt->close();
$conn->close();
