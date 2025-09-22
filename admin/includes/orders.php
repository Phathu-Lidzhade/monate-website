<?php
// admin/api/orders.php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../../API/db.php';
require_once __DIR__ . '/model.php';

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden"]);
    exit();
}

$adminBranch = $_SESSION['branch_location'] ?? null;

$result = getOrdersForBranch($conn, $adminBranch);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => $conn->error]);
    exit();
}

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = [
        "id" => (int)$row["id"],
        "user_id" => isset($row["user_id"]) ? (int)$row["user_id"] : null,
        "customer" => $row["customer"] ?? ("User #" . ($row["user_id"] ?? "")),
        "items" => $row["items"] ?? "",
        "total" => number_format($row["total"] ?? 0, 2),
        "status" => isset($row["status"]) ? $row["status"] : null,
        "created_at" => $row["created_at"] ?? null,
        "address" => $row["full_address"] ?? "",
        "instructions" => $row["instructions"] ?? ""
    ];
}

header('Content-Type: application/json');
echo json_encode($orders);
$conn->close();
