<?php
require_once '../api/config_session.inc.php';
require_once 'includes/view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Login</title>
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
                <h1>Welcome</h1>
                <p class="subtitle">Sign in with your email address and password.</p>

                <form class="form" action="includes/formhandler.inc.php" method="POST">
                    <input name="email" type="email" placeholder="Email Address" required>
                    <input name="password" type="password" placeholder="Password" required>

                    <div class="form-options">
                        <label class="remember">
                            <input type="checkbox"> Remember me
                        </label>

                        <a href="../forgot password/index.html" class="forgot-link">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn">Sign In</button>
                </form>

                <?php
                check_login_errors();
                ?>

                <p class="signup-text">
                    Don’t have an account? <a href="../create account/signup.php" class="signup-link">Sign up</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
