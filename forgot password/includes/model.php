<?php
// sign in/includes/model.php

function findUserByEmailAndMobile($conn, $email, $mobile) {
    $sql = "SELECT * FROM users WHERE email = ? AND mobile = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param("ss", $email, $mobile);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function updateUserPassword($conn, $email, $mobile, $hashedPassword) {
    $updateSql = "UPDATE users SET password = ? WHERE email = ? AND mobile = ?";
    $updateStmt = $conn->prepare($updateSql);
    if ($updateStmt === false) {
        return $conn->error;
    }
    $updateStmt->bind_param("sss", $hashedPassword, $email, $mobile);
    if ($updateStmt->execute()) {
        $updateStmt->close();
        return true;
    } else {
        $err = $updateStmt->error;
        $updateStmt->close();
        return $err;
    }
}
