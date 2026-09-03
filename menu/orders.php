<?php
session_start();
require_once "../API/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../Sign in/index.php");
    exit();
}

$userId = $_SESSION["user_id"];

// ✅ Fetch all orders for this user
$stmt = $conn->prepare("
    SELECT id, branch_location, order_type, total_amount, status, created_at
    FROM orders 
    WHERE user_id = ?
    ORDER BY created_at DESC
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    // ✅ Fetch items for each order
    $itemStmt = $conn->prepare("
        SELECT name, quantity, price, sauce, image 
        FROM order_items 
        WHERE order_id = ?
    ");
    $itemStmt->bind_param("i", $row["id"]);
    $itemStmt->execute();
    $itemsResult = $itemStmt->get_result();
    $row["items"] = $itemsResult->fetch_all(MYSQLI_ASSOC);
    $itemStmt->close();

    $orders[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Orders</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .orders-container {
      max-width: 1000px;
      margin: 2rem auto;
      padding: 1rem;
    }
    .order-card {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 10px;
      margin-bottom: 1.5rem;
      padding: 1rem 1.5rem;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .order-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 1rem;
    }
    .order-header strong { font-size: 1.1rem; }
    .status {
      font-weight: bold;
      padding: 0.2rem 0.5rem;
      border-radius: 6px;
    }
    .status.Pending { background: orange; color: white; }
    .status.Ready { background: blue; color: white; }
    .status.Delivered { background: green; color: white; }
    .items-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 0.5rem;
    }
    .items-table th, .items-table td {
      border-bottom: 1px solid #eee;
      padding: 0.6rem;
      text-align: left;
    }
    .items-table th { background: #f5f5f5; }
    .items-table img { height: 40px; border-radius: 5px; }
    .total {
      text-align: right;
      font-weight: bold;
      margin-top: 1rem;
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
      </a>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main class="orders-container">
    <h2>My Orders</h2>

    <?php if (empty($orders)): ?>
      <p>You have no orders yet.</p>
    <?php else: ?>
      <?php foreach ($orders as $order): ?>
        <div class="order-card">
          <div class="order-header">
            <strong>Order #<?= $order["id"]; ?> (<?= htmlspecialchars($order["branch_location"]); ?>)</strong>
            <span class="status <?= $order["status"]; ?>"><?= $order["status"]; ?></span>
          </div>
          <p><strong>Order Type:</strong> <?= ucfirst($order["order_type"]); ?> | 
             <strong>Date:</strong> <?= $order["created_at"]; ?></p>

          <table class="items-table">
            <tr>
              <th>Image</th>
              <th>Item</th>
              <th>Sauce</th>
              <th>Qty</th>
              <th>Price</th>
            </tr>
            <?php foreach ($order["items"] as $item): ?>
              <tr>
                <td><?php if ($item["image"]): ?><img src="../uploads/<?= $item["image"]; ?>" alt="Item"><?php endif; ?></td>
                <td><?= htmlspecialchars($item["name"]); ?></td>
                <td><?= htmlspecialchars($item["sauce"]); ?></td>
                <td><?= $item["quantity"]; ?></td>
                <td>R<?= number_format($item["price"] * $item["quantity"], 2); ?></td>
              </tr>
            <?php endforeach; ?>
          </table>

          <p class="total">Total: R<?= number_format($order["total_amount"], 2); ?></p>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </main>
</body>
</html>
