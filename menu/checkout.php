<?php
session_start();
require_once "../API/db.php";

$userId = $_SESSION["user_id"] ?? null;
$totalItems = 0;
$totalAmount = 0;
$cartItems = [];
$branch = $_GET["branch"] ?? null; // ✅ branch passed in URL (e.g. checkout.php?branch=Thohoyandou)

if ($userId && $branch) {
    // ✅ Fetch items for this branch only
    $stmt = $conn->prepare("
        SELECT id, name, price, quantity, branch_location 
        FROM Cart 
        WHERE user_id = ? AND branch_location = ?
    ");
    $stmt->bind_param("is", $userId, $branch);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }
    $stmt->close();

    // ✅ Totals only for this branch
    $stmt = $conn->prepare("
        SELECT SUM(quantity) AS totalItems, SUM(price * quantity) AS totalAmount 
        FROM Cart 
        WHERE user_id = ? AND branch_location = ?
    ");
    $stmt->bind_param("is", $userId, $branch);
    $stmt->execute();
    $stmt->bind_result($totalItems, $totalAmount);
    $stmt->fetch();
    $stmt->close();
}

$deliveryCost = 20; // Default delivery cost
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
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

    /* LAYOUT */
    .checkout-wrapper {
      display: flex;
      justify-content: space-between;
      gap: 2rem;
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 1rem;
    }
    .checkout-container, .summary-container {
      flex: 1;
      background: #fff; /* ✅ White background only */
      padding: 2rem;
      border-radius: 10px;
    }
    .checkout-container h2, .summary-container h2 {
      margin-bottom: 1rem;
      text-align: center;
    }
    label {
      font-weight: bold;
      display: block;
      margin-top: 1rem;
    }
    input, select, textarea {
      width: 100%;
      padding: 0.7rem;
      margin-top: 0.5rem;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .btn {
      margin-top: 2rem;
      padding: 0.8rem;
      width: 100%;
      border: none;
      border-radius: 6px;
      background:rgb(179, 29, 29);
      color: #fff;
      font-size: 1rem;
      cursor: pointer;
    }
    .btn:hover {  background:rgb(117, 20, 20); }

    /* SUMMARY TABLE */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }
    table th, table td {
      border-bottom: 1px solid #ddd;
      padding: 0.7rem;
      text-align: left;
    }
    table th { background: #eee; }
    .total-box {
      margin-top: 1rem;
      font-size: 1.1rem;
      font-weight: bold;
      text-align: right;
    }
    .delivery-group {
      margin-left: 1.5rem;
      padding-left: 1rem;
      border-left: 3px solid #ddd;
    }
  </style>
</head>
<body>
  <!-- HEADER -->
  <header class="top-header">
    <div class="logo"><img src="img/logo 2.png" alt="Monate Logo"></div>
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
      <a href="cart.php" class="cart">
        <img src="img/shopping cart.png" alt="Cart">
        <?php if ($totalItems > 0): ?>
          <span class="cart-badge"><?= $totalItems ?></span>
        <?php endif; ?>
      </a>
    </div>
  </header>

  <!-- MAIN CHECKOUT CONTENT -->
  <main class="checkout-wrapper">
    <!-- LEFT: FORM -->
    <div class="checkout-container">
      <h2>Checkout</h2>
      <form action="process_order.php" method="POST" id="checkoutForm">
        
        <!-- ✅ FIXED Hidden Branch -->
        <input type="hidden" name="branch" value="<?= htmlspecialchars($branch) ?>">

        <!-- Order Type -->
        <label for="orderType">Order Type</label>
        <select name="orderType" id="orderType" required>
          <option value="pickup">Pickup</option>
          <option value="delivery">Delivery</option>
        </select>

        <!-- Delivery Address -->
        <div id="deliveryAddressField" style="display: none;" class="delivery-group">
          <label for="street">Street Address</label>
          <input type="text" name="street" id="street">
          <label for="building">Building / Complex (optional)</label>
          <input type="text" name="building" id="building">
          <label for="town">Town / City</label>
          <input type="text" name="town" id="town">
          <label for="suburb">Suburb / Village</label>
          <input type="text" name="suburb" id="suburb">
          <label for="postal">Postal Code</label>
          <input type="text" name="postal" id="postal">
          <label for="instructions">Special Instructions</label>
          <textarea name="instructions" id="instructions"></textarea>
        </div>

        <!-- Phone -->
        <label for="phone">Phone Number</label>
        <input type="tel" name="phone" id="phone" required>

        <!-- Driver Tip -->
        <label for="tip">Driver Tip (Optional)</label>
        <input type="number" name="tip" id="tip" min="0" value="0">

        <!-- Payment -->
        <label for="payment">Payment Method</label>
        <select name="payment" id="payment" required>
          <option value="cash">Cash on Delivery</option>
          <option value="card">Credit/Debit Card</option>
        </select>

        <!-- ✅ Pass Total -->
        <input type="hidden" name="baseTotal" value="<?= $totalAmount ?>">

        <button type="submit" class="btn">Place Order</button>
      </form>
    </div>

    <!-- RIGHT: SUMMARY -->
    <div class="summary-container">
      <h2>Order Summary</h2>
      <table>
        <tr><th>Item</th><th>Qty</th><th>Price</th></tr>
        <?php foreach ($cartItems as $item): ?>
          <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>R<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
          </tr>
        <?php endforeach; ?>
      </table>

      <div class="total-box">Subtotal: R<span id="subtotal"><?= number_format($totalAmount, 2) ?></span></div>
      <div class="total-box">Delivery: R<span id="deliveryCost">0.00</span></div>
      <div class="total-box">Tip: R<span id="tipAmount">0.00</span></div>
      <div class="total-box">Final Total: R<span id="finalTotal"><?= number_format($totalAmount, 2) ?></span></div>
    </div>
  </main>

<script>
  const orderType = document.getElementById("orderType");
  const addressField = document.getElementById("deliveryAddressField");
  const tipInput = document.getElementById("tip");
  const tipAmount = document.getElementById("tipAmount");
  const finalTotal = document.getElementById("finalTotal");
  const deliveryCostEl = document.getElementById("deliveryCost");

  const baseTotal = parseFloat(<?= $totalAmount ?>);
  const deliveryCost = parseFloat(<?= $deliveryCost ?>);

  let isDelivery = false;

  function updateTotal() {
    const tip = parseFloat(tipInput.value) || 0;
    tipAmount.textContent = tip.toFixed(2);
    deliveryCostEl.textContent = isDelivery ? deliveryCost.toFixed(2) : "0.00";
    finalTotal.textContent = (baseTotal + (isDelivery ? deliveryCost : 0) + tip).toFixed(2);
  }

  orderType.addEventListener("change", () => {
    isDelivery = orderType.value === "delivery";
    addressField.style.display = isDelivery ? "block" : "none";
    document.querySelectorAll("#deliveryAddressField input, #deliveryAddressField textarea").forEach(el => {
      el.required = isDelivery;
    });
    updateTotal();
  });

  tipInput.addEventListener("input", updateTotal);
  updateTotal();
</script>

</body>
</html>
