<?php
session_start();
require_once "../API/db.php";

$branchLocation = $_SESSION["branch_location"];

// Fetch menu items
$stmt = $conn->prepare("SELECT id, name, price, description, category, image FROM menuitems WHERE branch_location = ?");
$stmt->bind_param("s", $branchLocation);
$stmt->execute();
$result = $stmt->get_result();

$menuItems = [];
while ($row = $result->fetch_assoc()) {
    $menuItems[] = $row;
}

echo json_encode($menuItems);
?>