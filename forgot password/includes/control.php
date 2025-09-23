<?php
// sign in/includes/control.php (controller)

require_once __DIR__ . '/../../API/db.php';
require_once __DIR__ . '/model.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? "";
    $mobile = $_POST["mobile"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    // Check passwords
    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        // Check if user exists (model function)
        $result = findUserByEmailAndMobile($conn, $email, $mobile);

        if ($result && $result->num_rows === 1) {
            // Hash new password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Update password (model function)
            $updateResult = updateUserPassword($conn, $email, $mobile, $hashedPassword);

            if ($updateResult === true) {
                $message = "Password updated successfully!";
            } else {
                // preserve original behavior: generic error message
                $message = "Error updating password!";
            }
        } else {
            $message = "No account found with that email and mobile number!";
        }

    }
}
