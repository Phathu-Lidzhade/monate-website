<?php
session_start();
require_once "../API/db.php";

// Get selected food ID from URL
if (!isset($_GET["id"])) {
    die("Invalid request. No item selected.");
}
$itemId = intval($_GET["id"]);

// Fetch menu item from DB
$stmt = $conn->prepare("SELECT id, name, price, description, category, image, branch_location 
                        FROM MenuItems 
                        WHERE id = ?");
$stmt->bind_param("i", $itemId);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    die("Food item not found.");
}

// Count items in the cart
$userId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
$sessionId = session_id();

if ($userId) {
    $cartStmt = $conn->prepare("SELECT SUM(quantity) as total FROM Cart WHERE user_id = ?");
    $cartStmt->bind_param("i", $userId);
} else {
    $cartStmt = $conn->prepare("SELECT SUM(quantity) as total FROM Cart WHERE session_id = ?");
    $cartStmt->bind_param("s", $sessionId);
}
$cartStmt->execute();
$cartResult = $cartStmt->get_result();
$cartCount = $cartResult->fetch_assoc()["total"] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($item['name']) ?> - Food Details</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Cart badge style */
    .cart {
      position: relative;
      display: inline-block;
    }
    .cart-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background: red;
      color: white;
      font-size: 12px;
      font-weight: bold;
      padding: 2px 6px;
      border-radius: 50%;
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
      <a href="../About Us/index.php">ABOUT US</a>
    </nav>
    <div class="account-cart">
      <!-- Account -->
      <a href="../Sign in/index.php" class="account">
        <img src="img/profile.png" alt="Account">
        <span>
          <?php if (isset($_SESSION["username"])): ?>
            Hi, <?= htmlspecialchars($_SESSION["username"]); ?>
          <?php else: ?>
            ACCOUNT
          <?php endif; ?>
        </span>
      </a>
      <div class="divider"></div>
      <!-- Cart -->
      <a href="cart.php" class="cart">
        <img src="img/shopping cart.png" alt="Cart">
        <?php if ($cartCount > 0): ?>
          <span class="cart-badge"><?= $cartCount ?></span>
        <?php endif; ?>
      </a>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main class="food-content">
    <!-- Back button to branch menu -->
    <a href="<?= htmlspecialchars($item['branch_location']) ?>.php" class="back-btn">⬅</a>

    <div class="food-detail">
      <!-- Food Image -->
      <div class="food-img">
        <img src="../admin/menu_item/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
      </div>

      <!-- Food Info -->
      <div class="food-info">
        <h2><?= htmlspecialchars($item['name']) ?></h2>
        <p class="food-price">R<?= number_format($item['price'], 2) ?></p>
        
        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($item['description'])) ?></p>

        <!-- Quantity -->
        <div class="quantity">
          <button class="qty-btn">-</button>
          <span id="qty">1</span>
          <button class="qty-btn">+</button>
        </div>

        <!-- Add to Cart -->
        <form method="POST" action="add_to_cart.php">
          <input type="hidden" name="id" value="<?= $item['id'] ?>">
          <input type="hidden" name="name" value="<?= htmlspecialchars($item['name']) ?>">
          <input type="hidden" name="price" value="<?= $item['price'] ?>">
          <input type="hidden" name="img" value="<?= htmlspecialchars($item['image']) ?>">
          <input type="hidden" name="qty" id="qtyInput" value="1">
          <button type="submit" class="add-cart">ADD TO CART</button>
        </form>
      </div>
    </div>
  </main>

  <script>
    // Handle quantity
    let qty = 1;
    const qtySpan = document.getElementById("qty");
    const qtyInput = document.getElementById("qtyInput");

    document.querySelectorAll(".qty-btn").forEach(btn => {
      btn.addEventListener("click", () => {
        if(btn.textContent === "+" && qty < 10) qty++;
        if(btn.textContent === "-" && qty > 1) qty--;
        qtySpan.textContent = qty;
        qtyInput.value = qty;
      });
    });
  </script>
</body>
</html>
