<?php
session_start();
require_once "../API/db.php";

// ✅ User info for dropdown
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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monate Chicken N Steak - About Us</title>
  <link rel="stylesheet" href="style.css">
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
  </style>
</head>
<body>

  <!-- HEADER -->
  <header class="top-header">
    <div class="logo">
      <img src="img/logo 2.png" alt="Monate Logo">
    </div>
    <nav class="nav-links">
      <a href="../HOME/index.php">HOME</a>
      <a href="index.php">ABOUT US</a>
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

  <!-- Story -->
  <section class="story">
    <h2>Our Story</h2>

    <div class="story-text">
      <p><strong>Monate Chicken N Steak</strong> is a thriving business that originated in 2011 as a small venture selling chips, pap, and meat from a tent at the local market. Starting with just two tables in the cramped kitchen of a modest shack in Lufule II, situated alongside the Punda Maria Road outside Thohoyandou, our business relied on the hard work of our two dedicated employees. Over time, through our commitment and perseverance, we have experienced significant growth and expansion.</p>

      <p><strong>Our Vision</strong> statement is to expand our presence throughout Limpopo and beyond. We aim to establish multiple branches to cater to our valued customers in Lufule II, Malamulele, Mukula, and Thohoyandou Central Business District, ensuring convenient access to our offerings.</p>

      <p><strong>What sets us apart</strong> is our reputation for serving delicious chicken and steak meals. If you're in search of a hot and spicy sauce to complement your dish, you need not look any further than us.</p>

      <p><strong>Local is Lekker</strong>, we take pride in our commitment to supporting the local community. Through our business growth, we have created over 60 employment opportunities for previously unemployed individuals, enabling them to provide for their families. Moreover, we actively contribute to the prosperity of local small-scale farmers around Thohoyandou and Malamulele. By sourcing fresh vegetables from these suppliers on a regular basis, we help bolster their businesses while ensuring the quality and freshness of our ingredients for our eateries.</p>
    </div>

    <div class="images">
      <img src="img/22 1.png" alt="Food 1">
      <img src="img/23 1.png" alt="Food 2">
    </div>

    <p class="founder"><strong>Lufuno, Rendani Makhale</strong><br>Founder</p>
  </section>

  <!-- Sauces -->
  <section class="sources">
    <h2>Try Our Sauces</h2>
    <p>
      Everyone has a secret. You know our secret sauce, Monate chicken sauce comes in all flavours you can think of: Mild, Hot, Extra hot for the brave. Specially mixed by the CEO since inception, look no further to spice your own home cooked or braai meat.
    </p>
    <a href="https://wa.me/0764097332?text=I%27m%20interested%20in%20your%20monater%20source" class="btn">Contact Us</a>
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
        <p><img src="img/location.png" alt=""> Stand 40035 Mavhunda Village Thohoyandou, Limpopo</p>
        <p><img src="img/phone.png" alt=""> Thohoyandou 063 378 4584 | Mukula 067 615 8958<br>LUFULE 066 184 4870 / 073 2453 284</p>
        <p><img src="img/email.png" alt=""> info@monatechicken.co.za</p>
      </div>
    </div>
  </footer>

  <script>
  // Account dropdown toggle
  const accountContainer = document.querySelector('.account-container');
  const accountDropdown = document.querySelector('.account-dropdown');
  if(accountContainer && accountDropdown){
    accountContainer.addEventListener('click', () => {
      accountDropdown.style.display =
        accountDropdown.style.display === 'block' ? 'none' : 'block';
    });
  }
</script>

</body>
</html>
