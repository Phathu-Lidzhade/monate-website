<?php


function createUser($conn, $username, $email, $mobile, $dob, $password) {
    // Hash password same as original
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, mobile, dob, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return $conn->error;
    }
    $stmt->bind_param("sssss", $username, $email, $mobile, $dob, $hashedPassword);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $err = $stmt->error;
        $stmt->close();
        return $err;
    }
}
