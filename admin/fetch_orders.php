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

// Check if "status" column exists
$hasStatus = false;
$resCheck = $conn->query("SHOW COLUMNS FROM `orders` LIKE 'status'");
if ($resCheck && $resCheck->num_rows > 0) {
    $hasStatus = true;
}

// Detect branch column on orders or users
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

// Build SELECT
$selectStatus = $hasStatus ? "o.status," : "";
$sql = "
SELECT
  o.id,
  o.user_id,
  COALESCE(u.username, CONCAT('User #', o.user_id)) AS customer,
  COALESCE(GROUP_CONCAT(CONCAT(oi.name,' x',oi.quantity) SEPARATOR ', '), '') AS items,
  COALESCE(o.total_amount, 0) AS total,
  {$selectStatus}
  o.created_at,
  CONCAT_WS(', ',
      NULLIF(o.street, ''),
      NULLIF(o.building, ''),
      NULLIF(o.town, ''),
      NULLIF(o.suburb, ''),
      NULLIF(o.postal, '')
  ) AS full_address,
  o.instructions
FROM orders o
LEFT JOIN users u ON u.id = o.user_id
LEFT JOIN order_items oi ON oi.order_id = o.id
";

// Apply branch filter if possible
$filters = [];
if ($adminBranch) {
    $branchEsc = $conn->real_escape_string($adminBranch);
    if ($branchColumnOrders) {
        // orders table has branch column -> filter directly on orders
        $filters[] = "o.`{$branchColumnOrders}` = '{$branchEsc}'";
    } elseif ($branchColumnUsers) {
        // filter by users.branch if orders doesn't have branch column
        $filters[] = "u.`{$branchColumnUsers}` = '{$branchEsc}'";
    } else {
        // no branch column found on orders or users - leaving unfiltered.
        // You may want to fail here if you always require branch isolation.
    }
}

if (count($filters) > 0) {
    $sql .= " WHERE " . implode(" AND ", $filters) . " ";
}

$sql .= " GROUP BY o.id ORDER BY o.id DESC ";

$result = $conn->query($sql);
if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => $conn->error]);
    exit;
}

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = [
        "id" => (int)$row["id"],
        "user_id" => isset($row["user_id"]) ? (int)$row["user_id"] : null,
        "customer" => $row["customer"] ?? ("User #" . ($row["user_id"] ?? "")),
        "items" => $row["items"] ?? "",
        "total" => number_format($row["total"] ?? 0, 2),
        "status" => $hasStatus ? ($row["status"] ?? "Pending") : null,
        "created_at" => $row["created_at"] ?? null,
        "address" => $row["full_address"] ?? "",
        "instructions" => $row["instructions"] ?? ""
    ];
}

header('Content-Type: application/json');
echo json_encode($orders);

$conn->close();
?>