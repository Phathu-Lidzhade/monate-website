<?php
require_once '../api/config_session.inc.php';
require_once 'includes/view.inc.php';

// Check if admin is logged in
if (!isset($_SESSION["admin_id"])) {
  header("Location: admin-login.php");
  die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Restaurant Admin Dashboard</title>
    <link rel="stylesheet" href="style-dash.css"/>
</head>
<body>
    <!-- Loader -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="app">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand">
                <img src="img/Logo 1.png" alt="Restaurant Logo" class="logo-img">
            </div>
            <nav class="nav">
                <a href="#" data-page="dashboard" class="active">Dashboard</a>
                <a href="#" data-page="orders">Orders</a>
                <div class="menu-parent">
                    <a href="#" class="menu-main" id="menuManagementBtn">Menu Management ▾</a>
                    <div class="submenu" id="menuSubmenu">
                        <a href="#" data-subpage="currentMenu" class="submenu-item active">Current Menu Items</a>
                        <a href="#" data-subpage="addMenu">Add Menu Item</a>
                    </div>
                </div>
                <a href="#" data-page="customers">Customers</a>
                <a href="#" data-page="reports">Reports</a>
                <a href="#" data-page="settings">Settings</a>
            </nav>
            <div class="spacer"></div>
        </aside>

        <!-- Main content -->
        <div class="content">
            <!-- Top bar -->
            <header class="topbar">
                <div class="search">
                    <input type="text" placeholder="Search...">
                </div>
                <div class="top-controls">
                    <div class="icon-btn">
                        <img src="img/Alarm.png" alt="Notifications" class="icon-img">
                    </div>
                    <div class="avatar" id="accountBtn">
                        <img src="img/Account.png" alt="User Profile" class="avatar-img">
                        <!-- Dropdown -->
                        <div class="dropdown" id="accountDropdown">
                            <br>
                            <a href="includes/logout.inc.php" class="logout-btn">Logout</a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main area -->
            <main id="main-content" class="main">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION["admin_username"]); ?></h2>
                <p>Email: <?php echo htmlspecialchars($_SESSION["admin_email"]); ?></p>
                <p>Branch: </p>
                <p>Select a menu item to view its content here.</p>
            </main>
        </div>
    </div>

    <script>
    const adminData = {
        email: "<?php echo htmlspecialchars($adminEmail); ?>",
        branch: "<?php echo htmlspecialchars($branchLocation); ?>"
    };
    </script>
    <script src="script.js"></script>
</body>
</html>