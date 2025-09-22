<?php
require_once(__DIR__ . '/../../API/db.php'); 

function findUserByEmail($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result();
}

function findAdminByEmail($conn, $email) {
    $sql = "SELECT * FROM Admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result();
}
