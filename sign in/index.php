<?php
// run controller first so it can set $message, sessions, redirects, etc.
require_once __DIR__ . '/includes/control.php';
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

                <!-- View: displays messages (view.php) -->
                <?php require_once __DIR__ . '/includes/view.php'; ?>

                <form class="form" method="POST" action="">
                    <input type="email" name="email" placeholder="Email Address" required>
                    <input type="password" name="password" placeholder="Password" required>

                    <div class="form-options">
                        <label class="remember">
                            <input type="checkbox"> Remember me
                        </label>
                        <a href="../forgot password/index.php" class="forgot-link">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn">Sign In</button>
                </form>

                <p class="signup-text">
                    Don’t have an account? <a href="../create Account/index.php" class="signup-link">Sign up</a>
                </p>
                <p class="signup-text"><a class="signup-link" href="../home/index.php">HOME</a></p>
            </div>
        </div>
    </div>
</body>
</html>
