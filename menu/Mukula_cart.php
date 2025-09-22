<?php 
session_start();
require_once "../API/db.php";

// Force branch to Mukula
$branchLocation = "Mukula";

// Check user login (cart is tied to logged-in users)
if (!isset($_SESSION["user_id"])) {
    header("Location: ../Sign in/index.php");
    exit;
}

$userId = $_SESSION["user_id"];

// ✅ Fetch cart items for this user & this branch only
$stmt = $conn->prepare("
    SELECT C.id, C.item_id, C.name, C.price, C.quantity, C.sauce, C.image 
    FROM Cart C 
    WHERE C.user_id = ? AND C.branch_location = ?
");
$stmt->bind_param("is", $userId, $branchLocation);
$stmt->execute();
$result = $stmt->get_result();
$cartItems = $result->fetch_all(MYSQLI_ASSOC);

// Count total items & price
$totalItems = 0;
$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalItems += $item["quantity"];
    $totalPrice += $item["price"] * $item["quantity"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Cart - Mukula</title>
  <style>
    /* RESET */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, Helvetica, sans-serif; background: #fff; color: #000; }

    /* HEADER */
    .top-header {
      display: flex; align-items: center;
      padding: 0.5rem 2rem;
      background: #fff;
      border-bottom: 2px solid rgba(0,0,0,0.3);
      box-shadow: 0 4px 4px rgba(0,0,0,0.25);
      position: sticky; top: 0; z-index: 1000;
    }
    .logo img { height: 80px; }
    .nav-links { display: flex; gap: 2rem; margin-left: 2rem; }
    .nav-links a { color: black; text-decoration: none; font-size: 1rem; font-weight: 400; }
    .account-cart { display: flex; align-items: center; gap: 1rem; margin-left: auto; }
    .account, .cart { display: flex; align-items: center; gap: 0.3rem; text-decoration: none; color: black; font-size: 1rem; }
    .account img, .cart img { height: 30px; }
    .divider { width: 1px; height: 20px; background: black; }
    .cart { position: relative; }
    .cart-badge {
      position: absolute; top: -5px; right: -5px;
      background: red; color: white; font-size: 12px;
      font-weight: bold; padding: 2px 6px;
      border-radius: 50%;
    }

    /* MAIN CART */
    .cart-page { padding: 2rem; }
    .cart-page h1 { margin-bottom: 1rem; }
    .cart-table {
      width: 100%; border-collapse: collapse; margin-bottom: 2rem;
    }
    .cart-table th, .cart-table td {
      padding: 1rem; border-bottom: 1px solid #ccc; text-align: center;
    }
    .cart-table img {
      width: 60px; height: 60px; object-fit: cover; border-radius: 8px;
    }
    .remove-btn {
      background: #ed1b26; color: white; padding: 0.3rem 0.6rem;
      border: none; border-radius: 4px; cursor: pointer;
    }
    .remove-btn:hover { background: #c4161f; }

    /* SUMMARY */
    .summary {
      text-align: right;
      border-top: 2px solid #000;
      padding-top: 1rem;
    }
    .checkout-btn {
      margin-top: 1rem;
      background: #ed1b26; color: #fff;
      padding: 0.8rem 2rem; border: none;
      font-size: 1rem; border-radius: 25px; cursor: pointer;
    }
    .checkout-btn:hover { background: #c4161f; }

    /* RESPONSIVE */
    @media(max-width: 768px) {
      .cart-table th, .cart-table td { font-size: 0.9rem; padding: 0.5rem; }
      .cart-table img { width: 40px; height: 40px; }
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
      <a href="cart_mukula.php" class="cart">
        <img src="img/shopping cart.png" alt="Cart">
        <?php if ($totalItems > 0): ?>
          <span class="cart-badge"><?= $totalItems ?></span>
        <?php endif; ?>
      </a>
    </div>
  </header>

  <!-- MAIN CART CONTENT -->
  <main class="cart-page">
    <h1>Shopping Cart – Mukula</h1>

    <?php if (empty($cartItems)): ?>
      <p>Your cart for <strong>Mukula</strong> is empty. 
         <a href="Mukula.php">Continue Shopping</a></p>
    <?php else: ?> 
      <table class="cart-table">
        <tr>
          <th>Image</th>
          <th>Item</th>
          <th>Sauce</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
          <th>Action</th>
        </tr>
        <?php foreach ($cartItems as $item): ?>
          <tr>
            <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"></td>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= htmlspecialchars($item['sauce']) ?></td>
            <td>R<?= number_format($item['price'], 2) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>R<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
            <td>
              <form method="POST" action="remove_from_cart.php" style="display:inline;">
                <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                <button type="submit" class="remove-btn">Remove</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>

      <div class="summary">
        <p><strong>Total Items:</strong> <?= $totalItems ?></p>
        <p><strong>Total Price:</strong> R<?= number_format($totalPrice, 2) ?></p>
        <a href="checkout.php?branch=Mukula">
          <button class="checkout-btn">Proceed to Checkout</button>
        </a>
      </div>
    <?php endif; ?>
  </main>
</body>
</html>
