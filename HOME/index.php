<?php
session_start();
require_once "../API/db.php";

// User info for dropdown
$userData = null;
if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];
    $userStmt = $conn->prepare("SELECT username, email, mobile FROM users WHERE id = ?");
    if ($userStmt) {
        $userStmt->bind_param("i", $userId);
        $userStmt->execute();
        $userData = $userStmt->get_result()->fetch_assoc();
        $userStmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Monate Chicken & Steak</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    /* Account dropdown */
    .account-dropdown {
      display: none;
      position: absolute;
      right: 0;
      background: #fff;
      box-shadow: 0 4px 6px rgba(0,0,0,0.2);
      padding: 10px;
      border-radius: 8px;
      z-index: 10;
      min-width: 180px;
    }
    .account-container {
      position: relative;
      display: inline-block;
      cursor: pointer;
    }
    .account-dropdown p {
      margin: 5px 0;
      font-size: 14px;
      color: #333;
    }
    .account-dropdown a {
      display: block;
      background: red;
      color: white;
      text-align: center;
      padding: 6px;
      text-decoration: none;
      border-radius: 4px;
      margin-top: 5px;
    }

    /* Branch dropdown (EAT NOW button) */
    .branch-container {
      position: relative;
      display: inline-block;
    }
    .branch-dropdown {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background: #fff;
      box-shadow: 0 4px 6px rgba(0,0,0,0.2);
      padding: 10px;
      border-radius: 8px;
      z-index: 10;
      min-width: 160px;
    }
    .branch-dropdown a {
      display: block;
      padding: 6px;
      color: #333;
      text-decoration: none;
    }
    .branch-dropdown a:hover {
      background: #f2f2f2;
    }
  </style>
</head>
<body>

  <header class="top-header">
    <div class="logo">
      <img src="img/logo 2.png" alt="Monate Logo">
    </div>
    <nav class="nav-links">
      <a href="index.php">HOME</a>
      <a href="../About Us/index.php">ABOUT US</a>
    </nav>
    <div class="account-cart">
      <!-- Account -->
      <div class="account-container">
        <?php if (isset($_SESSION["user_id"])): ?>
          <!-- User logged in: show dropdown toggle -->
          <a class="account" href="javascript:void(0);">
            <img src="img/profile.png" alt="Account">
            <span>
              Hi, <?= htmlspecialchars($_SESSION["username"]); ?>
            </span>
          </a>
          <div class="account-dropdown">
            <p><strong>Username:</strong> <?= htmlspecialchars($userData['username']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($userData['email']); ?></p>
            <p><strong>Mobile:</strong> <?= htmlspecialchars($userData['mobile']); ?></p>
            <a href="../Logout/logout.php">Logout</a>
          </div>
        <?php else: ?>
          <!-- User not logged in: simple link to sign in -->
          <a href="../Sign in/index.php" class="account">
            <img src="img/profile.png" alt="Account">
            <span>ACCOUNT</span>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <!-- 🔹 Hero Section -->
  <section class="hero">
    <img src="img/IMG_4745 1.png" alt="Hero Background" class="hero-bg"/>
    <div class="hero-content">
      <h1>MONATE CHICKEN & STEAK</h1>
      <div class="branch-container">
        <a class="btn">EAT NOW</a>
        <div class="branch-dropdown">
          <p class="dropdown-text">Pick a location</p>
          <a href="../menu/Thohoyandou.php">Thohoyandou</a>
          <a href="../menu/Mukula.php">Mukula</a>
          <a href="../menu/Lufule.php">Lufule</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="footer-content">
      <div class="left">
        <h3>Monate Chicken</h3>
        <p>Sharing our culture through good food.</p>
        <div class="social">
         <a href="https://www.facebook.com/monatechicken34"><img  src="img/facebook.png" alt="Facebook"></a> 
         <a href="https://www.instagram.com/monatechickenandsteak/#"> <img src="img/instagram.png" alt="Instagram"></a>
        </div>
      </div>
      <div class="right">
        <h3>Contact Us</h3>
        <p><img src="img/location 1.png" alt=""> Stand 40035 Mavhunda Village Thohoyandou, Limpopo</p>
        <p><img src="img/phone.png" alt=""> Thohoyandou 063 378 4584 | Mukula 067 615 8958<br>LUFULE 066 184 4870 / 073 2453 284</p>
        <p><img src="img/email.png" alt=""> info@monatechicken.co.za</p>
      </div>
    </div>
  </footer>

<script src="script.js"></script>

</body>
</html>
