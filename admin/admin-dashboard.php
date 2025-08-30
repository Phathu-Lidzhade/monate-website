<?php
require_once '../api/config_session.inc.php';

// Check if admin is logged in
if (!isset($_SESSION["admin_id"])) {
  header("Location: admin-login.php");
  die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="dashboard">
    <header class="dashboard-header">
      <img class="logo" src="img/Logo 1.png" alt="Logo">
      <div class="admin-info">
        <span>Welcome, <?php echo htmlspecialchars($_SESSION["admin_name"]); ?></span>
        <span class="admin-role"><?php echo htmlspecialchars($_SESSION["admin_role"]); ?></span>
      </div>
      <a href="includes/logout.inc.php" class="logout-btn">Logout</a>
    </header>

    <main class="dashboard-main">
      <h1>Admin Dashboard</h1>
      <div class="dashboard-content">
        <div class="dashboard-card">
          <h3>User Management</h3>
          <p>Manage user accounts and permissions</p>
        </div>
        <div class="dashboard-card">
          <h3>Order Management</h3>
          <p>View and manage food orders</p>
        </div>
        <div class="dashboard-card">
          <h3>Menu Management</h3>
          <p>Update food menu items</p>
        </div>
        <div class="dashboard-card">
          <h3>Analytics</h3>
          <p>View sales and user statistics</p>
        </div>
      </div>
    </main>
  </div>
</body>

</html>