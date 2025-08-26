<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once "../../api/dbh.inc.php"; // adjust path if needed

    $username = $_POST["username"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phoneNumber"];
    $pwd = $_POST["password"];
    $confirmPwd = $_POST["confirm_password"];

    // Check password confirmation
    if ($pwd !== $confirmPwd) {
        die("Passwords do not match!");
    }

    try {
        $query = "INSERT INTO users (username, email, phoneNumber, pwd) 
                  VALUES (:username, :email, :phoneNumber, :pwd)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phoneNumber", $phoneNumber);
        $stmt->bindParam(":pwd", $pwd);
        $stmt->execute();

        $stmt = null;
        $pdo = null;

        header("Location: ../index.html");
        exit();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../index.html");
    exit();
}
