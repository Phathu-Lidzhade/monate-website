<?php
// admin/api/menuitems.php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../API/db.php';
require_once __DIR__ . '/../includes/model.php';

$branchLocation = $_SESSION['branch_location'] ?? null;

if (!$branchLocation) {
    http_response_code(400);
    echo json_encode(["error" => "No branch set for admin"]);
    exit();
}

$result = getMenuItemsForBranch($conn, $branchLocation);

if ($result === false) {
    http_response_code(500);
    echo json_encode(["error" => $conn->error]);
    exit();
}

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

header('Content-Type: application/json');
echo json_encode($items);
$conn->close();
