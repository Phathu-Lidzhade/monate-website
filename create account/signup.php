<?php
require_once '../api/config_session.inc.php';
require_once 'includes/view.inc.php';
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

            <form class="form" action="includes/formhandler.inc.php" method="post">
                <input type="text" name="username" placeholder="Username">
                <input type="email" name="email" placeholder="Email Address">
                <input type="tel" name="phone_number" placeholder="Mobile Number">
                
                <label class="dob-label">Date of Birth</label>
                <div class="dob">
                    <input type="number" name="day" placeholder="Day" min="1" max="31">
                    <input type="number" name="month" placeholder="Month" min="1" max="12">
                    <input type="number" name="year" placeholder="Year" min="1900" max="2100">
                </div>

                <input type="password" name="password" placeholder="Password">
                <input type="password" name="confirm_password" placeholder="Confirm Password">

                <label class="terms">
                    <input type="checkbox" required>
                    By creating an account, You agree to the 
                    <a href="#">Terms of use</a>
                </label>

                <button type="submit" class="btn">Create Account</button>
            </form>

            <p class="signin-text">
                Already have an account?
                <a href="../sign in/signin.php" class="signin-link">Sign in</a>
            </p>

            <?php
            check_signup_errors();
            ?>

        </div>
    </div>
</body>
</html>
