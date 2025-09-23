<?php
// admin/api/customers.php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../../API/db.php';
require_once __DIR__ . '/../includes/model.php';

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden"]);
    exit();
}

$adminBranch = $_SESSION['branch_location'] ?? null;

$result = getCustomersForBranch($conn, $adminBranch);
if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => $conn->error]);
    exit();
}

$customers = [];
while ($row = $result->fetch_assoc()) {
    $customers[] = [
        "id" => (int)$row["id"],
        "username" => $row["username"] ?? "N/A",
        "email" => $row["email"] ?? "N/A",
        "mobile" => $row["mobile"] ?? "N/A",
        "orders_made" => (int)$row["orders_made"],
        "total_spent" => number_format($row["total_spent"], 2)
    ];
}

header("Content-Type: application/json");
echo json_encode($customers);
$conn->close();
