<?php
// run controller first so it can set $message
require_once __DIR__ . '/includes/control.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="desktop">
        
        <!-- Left Image Side -->
        <div class="image-side">
            <img class="bacc" src="img/bacc 1.png" alt="Background Image">
        </div>

        <!-- Right Form Side -->
        <div class="container">
            <img class="logo" src="img/logo 1.png" alt="Logo">

            <div class="form-section">
                <h1>Forgot Password</h1>
                <p class="subtitle">Enter your details to reset your password.</p>

                <!-- Show message (view) -->
                <?php require_once __DIR__ . '/includes/view.php'; ?>

                <form class="form" method="POST" action="">
                    <input type="email" name="email" placeholder="Email Address" required>
                    <input type="tel" name="mobile" placeholder="Mobile Number" required>
                    <input type="password" name="password" placeholder="New Password" required>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>

                    <button type="submit" class="btn">Change Password</button>
                </form>
                <a href="../sign in/index.php" class="signin-link">Back to Sign in</a>
            </div>
        </div>
    </div>
</body>
</html>
