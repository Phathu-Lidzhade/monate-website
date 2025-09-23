<?php
// run controller first so it can set $message
require_once __DIR__ . '/includes/control.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="desktop">
        
        <div class="image-side">
            <img class="bacc" src="img/bacc 1.png" alt="Background Image">
        </div>

        <div class="container">
            <img class="logo" src="img/logo 1.png" alt="Logo">

            <h1>Create Account</h1>

            <!-- Show message (view) -->
            <?php require_once __DIR__ . '/includes/view.php'; ?>

            <form class="form" method="POST" action="">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="tel" name="mobile" placeholder="Mobile Number" required>
                
                <label class="dob-label">Date of Birth</label>
                <div class="dob">
                    <input type="number" name="day" placeholder="Day" min="1" max="31" required>
                    <input type="number" name="month" placeholder="Month" min="1" max="12" required>
                    <input type="number" name="year" placeholder="Year" min="1900" max="2100" required>
                </div>

                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>

                <label class="terms">
                    <input type="checkbox" required>
                    By creating an account, I agree to the 
                    <a href="#">Terms of use</a> and understand that my information will be used as described on this page.
                </label>

                <button type="submit" class="btn">Create Account</button>
            </form>

            <p class="signin-text">
                Already have an account?
                <a href="../sign in/index.php" class="signin-link">Sign in</a>
            </p>
        </div>
    </div>
</body>
</html>
