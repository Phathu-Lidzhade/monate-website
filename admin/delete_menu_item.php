<?php
session_start();
require_once "../API/db.php";

if (!isset($_GET["id"])) {
    echo "Invalid request";
    exit();
}

$id = intval($_GET["id"]);
$branchLocation = $_SESSION["branch_location"];


$stmt = $conn->prepare("DELETE FROM menuitems WHERE id = ? AND branch_location = ?");
$stmt->bind_param("is", $id, $branchLocation);

if ($stmt->execute()) {
    echo "Item deleted successfully.";
} else {
    echo "Error deleting item.";
}
?>