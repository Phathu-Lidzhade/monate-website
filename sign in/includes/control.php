<?php
// sign in/includes/control.php
// controller: run before any HTML output (index.php requires this)
session_start();

// require DB (adjusted reliably relative to this file)
require_once __DIR__ . '/../../API/db.php';

// require model functions
require_once __DIR__ . '/model.php';

// initialize message for the view
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    // Check users
    $result = findUserByEmail($conn, $email);
    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["role"] = "user";
            header("Location: ../HOME/index.php");
            exit();
        } else {
            $message = "Invalid password!";
        }
    } else {
        // Check admins
        $result = findAdminByEmail($conn, $email);
        if ($result && $result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            // preserved your original admin password check (plain-text as in original)
            if ($password === $admin["password"]) {
                $_SESSION["admin_id"] = $admin["id"];
                $_SESSION["email"] = $admin["email"];
                $_SESSION["branch_location"] = $admin["branch_location"];
                $_SESSION["role"] = "admin";
                header("Location: ../admin/index.php");
                exit();
            } else {
                $message = "Invalid password!";
            }
        } else {
            $message = "Email not found!";
        }
    }
}

// At this point $message is available to index.php and view.php because this file was required first.
