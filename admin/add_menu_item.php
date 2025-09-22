<?php 
session_start();
require_once "../API/db.php";

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login/index.php"); 
    exit();
}

// Get admin info
$adminEmail = $_SESSION["email"];
$branchLocation = $_SESSION["branch_location"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $category = $_POST["category"];


    // Handle image upload
    $imageName = null;
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $imageName = uniqid("menu_", true) . "." . $ext;

        $targetDir = __DIR__ . "/menu_item/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetPath = $targetDir . $imageName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath);
    }

    // Save to DB
    $stmt = $conn->prepare("INSERT INTO MenuItems (name, price, description, category, image, branch_location) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdssss", $name, $price, $description, $category, $imageName, $branchLocation);


    if ($stmt->execute()) {
        header("Location: index.php"); // back to admin dashboard
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>