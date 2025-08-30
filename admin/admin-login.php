<?php
require_once '../api/config_session.inc.php';
require_once 'includes/view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="desktop">

    <!-- Left Image Side -->
    <div class="image-side">
      <img class="bacc" src="img/Bacc 1.png" alt="Background Image">
    </div>

    <!-- Right Form Side -->
    <div class="container">
      <img class="logo" src="img/Logo 1.png" alt="Logo">

      <div class="form-section">
        <h1>Admin Access</h1>
        <p class="subtitle">Sign in with your admin credentials.</p>

        <form class="form" action="includes/formhandler.inc.php" method="POST">
          <input name="email" type="email" placeholder="Admin Email Address" required>
          <input name="password" type="password" placeholder="Admin Password" required>

          <div class="form-options">
            <label class="remember">
              <input type="checkbox"> Remember me
            </label>
          </div>

          <button type="submit" class="btn">Admin Sign In</button>
        </form>

        <?php
        check_login_errors();
        ?>

        <p class="signup-text">
          <a href="../index.html" class="signup-link">Back to Main Site</a>
        </p>
      </div>
    </div>
  </div>
</body>

</html>