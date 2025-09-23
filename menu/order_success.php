<?php
session_start();
require_once "../API/db.php";

$orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : null;
$orderDetails = [];
$errorMessage = null;

if (!$orderId || !isset($_SESSION['user_id'])) {
    $errorMessage = "Order ID not found or user not logged in.";
} else {
    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("
        SELECT 
            o.id AS order_id, o.total_amount, o.created_at, o.branch_location,
            o.delivery_cost, o.tip, o.payment_method, o.order_type,
            oi.name, oi.quantity, oi.price
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        WHERE o.id = ? AND o.user_id = ?
    ");
    $stmt->bind_param("ii", $orderId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orderDetails[] = $row;
            $totalAmount   = $row['total_amount'];
            $branchLocation= $row['branch_location'];
            $createdAt     = $row['created_at'];
            $deliveryCost  = $row['delivery_cost'];
            $tip           = $row['tip'];
            
            $orderType     = $row['order_type'];
        }
    } else {
        $errorMessage = "We couldn't find any details for this order.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Success</title>
  <style>
    body { font-family: Arial, sans-serif; background: #fff; margin: 0; padding: 0; }
    .top-header { display: flex; align-items: center; padding: 0.5rem 2rem; background: #fff;
        border-bottom: 2px solid rgba(0,0,0,0.3); box-shadow: 0 4px 4px rgba(0,0,0,0.25); position: sticky; top: 0; z-index: 1000; }
    .logo img { height: 80px; }
    .nav-links { display: flex; gap: 2rem; margin-left: 2rem; }
    .nav-links a { color: black; text-decoration: none; font-size: 1rem; }
    .account-cart { display: flex; align-items: center; gap: 1rem; margin-left: auto; }
    .account img, .cart img { height: 30px; }
    .divider { width: 1px; height: 20px; background: black; }

    .success-container { max-width: 800px; margin: 3rem auto; background: #fff;
        padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; }
    .success-container h1 { color: green; margin-bottom: 1rem; }
    .success-container p { font-size: 1.1rem; margin-bottom: 1.5rem; }
    table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
    table th, table td { border: 1px solid #ddd; padding: 0.7rem; text-align: left; }
    table th { background: #eee; }
    .total-box { margin-top: 1rem; font-weight: bold; text-align: right; }
    .btn-home { display: inline-block; margin-top: 2rem; padding: 0.8rem 1.5rem; background: rgb(179, 29, 29);
        color: #fff; text-decoration: none; border-radius: 6px; }
    .btn-home:hover { background: rgb(117, 20, 20); }
</style>
</head>
<body>
<header class="top-header">
  <div class="logo"><img src="img/logo 2.png" alt="Monate Logo"></div>
  <nav class="nav-links">
    <a href="../HOME/index.php">HOME</a>
    <a href="../About Us/index.php">ABOUT US</a>
  </nav>
</header>

<main class="success-container">
  <h1>Thank you for your order!</h1>

  <?php if (!empty($orderDetails)): ?>
    <p>Your order number is <strong>#<?= htmlspecialchars($orderId) ?></strong>.</p>
    <p>Branch: <strong><?= htmlspecialchars($branchLocation) ?></strong></p>
    <p>Order Date: <strong><?= htmlspecialchars($createdAt) ?></strong></p>
    <p>Order Type: <strong><?= htmlspecialchars(ucfirst($orderType)) ?></strong></p>
 

    <h2>Order Summary</h2>
    <table>
      <tr><th>Item</th><th>Qty</th><th>Price</th></tr>
      <?php foreach ($orderDetails as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item['name']) ?></td>
          <td><?= $item['quantity'] ?></td>
          <td>R<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
        </tr>
      <?php endforeach; ?>
    </table>

    <div class="total-box">Delivery: R<?= number_format($deliveryCost, 2) ?></div>
    <div class="total-box">Tip: R<?= number_format($tip, 2) ?></div>
    <div class="total-box">Total Paid: R<?= number_format($totalAmount, 2) ?></div>

  <?php else: ?>
    <p><?= $errorMessage ?? "Order ID not found." ?></p>
  <?php endif; ?>

  <a href="../HOME/index.php" class="btn-home">Go back to Home</a>
</main>
</body>
</html>