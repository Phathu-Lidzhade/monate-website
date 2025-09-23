<?php
// controller: handles POST, uses model, sets $message for the view

// require DB connection (adjusted relative to this file)
require_once __DIR__ . '/../../API/db.php';

// require model functions
require_once __DIR__ . '/model.php';

// initialize message (available to view because this file is required first)
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect input exactly like original
    $username = $_POST["username"] ?? "";
    $email = $_POST["email"] ?? "";
    $mobile = $_POST["mobile"] ?? "";
    $day = $_POST["day"] ?? "";
    $month = $_POST["month"] ?? "";
    $year = $_POST["year"] ?? "";
    $dob = "$year-$month-$day"; // format YYYY-MM-DD
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    // Password check (same logic as original)
    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        // call model to insert user (model preserves your prepared-statement logic)
        $result = createUser($conn, $username, $email, $mobile, $dob, $password);

        if ($result === true) {
            $message = "Account created successfully!";
        } else {
            // model returns error string on failure (keeps original behavior)
            $message = "Error: " . $result;
        }
    }
}
