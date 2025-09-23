<?php
session_start();

// Require admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden"]);
    exit();
}

require_once "../API/db.php"; // adjust if needed

$adminBranch = $_SESSION['branch_location'] ?? null;

// Detect branch columns
$branchColumnOrders = null;
$branchColumnUsers = null;
$candidates = ['branch_location','branch','store','branch_name','location'];

foreach ($candidates as $c) {
    $r = $conn->query("SHOW COLUMNS FROM `orders` LIKE '$c'");
    if ($r && $r->num_rows > 0) {
        $branchColumnOrders = $c;
        break;
    }
}
if (!$branchColumnOrders) {
    foreach ($candidates as $c) {
        $r = $conn->query("SHOW COLUMNS FROM `users` LIKE '$c'");
        if ($r && $r->num_rows > 0) {
            $branchColumnUsers = $c;
            break;
        }
    }
}

$branchEsc = $adminBranch ? $conn->real_escape_string($adminBranch) : null;

if ($adminBranch && $branchColumnOrders) {
    // Filter by orders.branch
    $sql = "
    SELECT 
        u.id,
        u.username,
        u.email,
        u.mobile,
        COUNT(o.id) AS orders_made,
        COALESCE(SUM(o.total_amount), 0) AS total_spent
    FROM users u
    JOIN orders o ON o.user_id = u.id AND o.`{$branchColumnOrders}` = '{$branchEsc}'
    GROUP BY u.id, u.username, u.email, u.mobile
    ORDER BY total_spent DESC
    ";
} elseif ($adminBranch && $branchColumnUsers) {
    // Filter by users.branch (useful if orders don't carry branch but users do)
    $sql = "
    SELECT 
        u.id,
        u.username,
        u.email,
        u.mobile,
        COUNT(o.id) AS orders_made,
        COALESCE(SUM(o.total_amount), 0) AS total_spent
    FROM users u
    JOIN orders o ON o.user_id = u.id
    WHERE u.`{$branchColumnUsers}` = '{$branchEsc}'
    GROUP BY u.id, u.username, u.email, u.mobile
    ORDER BY total_spent DESC
    ";
} else {
    // No branch info found - return all users with at least one order (no branch filtering).
    $sql = "
    SELECT 
        u.id,
        u.username,
        u.email,
        u.mobile,
        COUNT(o.id) AS orders_made,
        COALESCE(SUM(o.total_amount), 0) AS total_spent
    FROM users u
    JOIN orders o ON o.user_id = u.id
    GROUP BY u.id, u.username, u.email, u.mobile
    ORDER BY total_spent DESC
    ";
}

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => $conn->error]);
    exit;
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
?>