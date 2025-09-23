<?php
// admin/includes/model.php
// Model: database functions used by admin controllers and API endpoints

/**
 * Insert a new menu item.
 * Returns true on success, or an error string on failure.
 */
function insertMenuItem($conn, $name, $price, $description, $category, $imageName, $branchLocation) {
    $stmt = $conn->prepare("INSERT INTO MenuItems (name, price, description, category, image, branch_location) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        return $conn->error;
    }

    // Bind types: s = string, d = double (price), s = string...
    $stmt->bind_param("sdssss", $name, $price, $description, $category, $imageName, $branchLocation);

    $ok = $stmt->execute();
    if ($ok) {
        $stmt->close();
        return true;
    } else {
        $err = $stmt->error;
        $stmt->close();
        return $err;
    }
}

/**
 * Delete a menu item by id and branch location.
 * Returns true on success, or an error string.
 */
function deleteMenuItem($conn, $id, $branchLocation) {
    $stmt = $conn->prepare("DELETE FROM MenuItems WHERE id = ? AND branch_location = ?");
    if ($stmt === false) {
        return $conn->error;
    }
    $stmt->bind_param("is", $id, $branchLocation);
    $ok = $stmt->execute();
    if ($ok) {
        $affected = $stmt->affected_rows;
        $stmt->close();
        if ($affected > 0) return true;
        return "No item deleted, check id/branch.";
    } else {
        $err = $stmt->error;
        $stmt->close();
        return $err;
    }
}

/**
 * Detect a branch column in a table from a set of candidate names.
 * Returns the column name string or null.
 */
function detectBranchColumn($conn, $table, $candidates = ['branch_location','branch','store','branch_name','location']) {
    foreach ($candidates as $c) {
        $res = $conn->query("SHOW COLUMNS FROM `{$table}` LIKE '{$c}'");
        if ($res && $res->num_rows > 0) {
            return $c;
        }
    }
    return null;
}

/**
 * Get customers for admin branch, returns mysqli_result or false on error.
 * The caller can convert to array or JSON.
 */
function getCustomersForBranch($conn, $adminBranch) {
    // Use same detection + SQL logic you had originally
    $branchColumnOrders = detectBranchColumn($conn, 'orders');
    $branchColumnUsers  = null;
    if (!$branchColumnOrders) {
        $branchColumnUsers = detectBranchColumn($conn, 'users');
    }

    $branchEsc = $adminBranch ? $conn->real_escape_string($adminBranch) : null;

    if ($adminBranch && $branchColumnOrders) {
        $sql = "
        SELECT 
            u.id,
            u.username,
            u.email,
            u.mobile,
            COUNT(o.id) AS orders_made,
            COALESCE(SUM(o.total_amount), 0) AS total_spent
        FROM users u
        JOIN orders o ON o.user_id = u.id AND o.`{$branchColumnOrders}` = '{$branchEsc}'
        GROUP BY u.id, u.username, u.email, u.mobile
        ORDER BY total_spent DESC
        ";
    } elseif ($adminBranch && $branchColumnUsers) {
        $sql = "
        SELECT 
            u.id,
            u.username,
            u.email,
            u.mobile,
            COUNT(o.id) AS orders_made,
            COALESCE(SUM(o.total_amount), 0) AS total_spent
        FROM users u
        JOIN orders o ON o.user_id = u.id
        WHERE u.`{$branchColumnUsers}` = '{$branchEsc}'
        GROUP BY u.id, u.username, u.email, u.mobile
        ORDER BY total_spent DESC
        ";
    } else {
        $sql = "
        SELECT 
            u.id,
            u.username,
            u.email,
            u.mobile,
            COUNT(o.id) AS orders_made,
            COALESCE(SUM(o.total_amount), 0) AS total_spent
        FROM users u
        JOIN orders o ON o.user_id = u.id
        GROUP BY u.id, u.username, u.email, u.mobile
        ORDER BY total_spent DESC
        ";
    }

    $result = $conn->query($sql);
    return $result;
}

/**
 * Get menu items for a branch, returns mysqli_result or false.
 */
function getMenuItemsForBranch($conn, $branchLocation) {
    $stmt = $conn->prepare("SELECT id, name, price, description, category, image FROM MenuItems WHERE branch_location = ?");
    if ($stmt === false) return false;
    $stmt->bind_param("s", $branchLocation);
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * Get orders for branch, returns mysqli_result or false.
 * Mirrors your original logic including optional status column detection.
 */
function getOrdersForBranch($conn, $adminBranch) {
    // Check if "status" exists in orders
    $hasStatus = false;
    $resCheck = $conn->query("SHOW COLUMNS FROM `orders` LIKE 'status'");
    if ($resCheck && $resCheck->num_rows > 0) {
        $hasStatus = true;
    }

    $branchColumnOrders = detectBranchColumn($conn, 'orders');
    $branchColumnUsers  = null;
    if (!$branchColumnOrders) {
        $branchColumnUsers = detectBranchColumn($conn, 'users');
    }

    $selectStatus = $hasStatus ? "o.status," : "";

    $sql = "
    SELECT
      o.id,
      o.user_id,
      COALESCE(u.username, CONCAT('User #', o.user_id)) AS customer,
      COALESCE(GROUP_CONCAT(CONCAT(oi.name,' x',oi.quantity) SEPARATOR ', '), '') AS items,
      COALESCE(o.total_amount, 0) AS total,
      {$selectStatus}
      o.created_at,
      CONCAT_WS(', ',
          NULLIF(o.street, ''),
          NULLIF(o.building, ''),
          NULLIF(o.town, ''),
          NULLIF(o.suburb, ''),
          NULLIF(o.postal, '')
      ) AS full_address,
      o.instructions
    FROM orders o
    LEFT JOIN users u ON u.id = o.user_id
    LEFT JOIN order_items oi ON oi.order_id = o.id
    ";

    $filters = [];
    if ($adminBranch) {
        $branchEsc = $conn->real_escape_string($adminBranch);
        if ($branchColumnOrders) {
            $filters[] = "o.`{$branchColumnOrders}` = '{$branchEsc}'";
        } elseif ($branchColumnUsers) {
            $filters[] = "u.`{$branchColumnUsers}` = '{$branchEsc}'";
        }
    }

    if (count($filters) > 0) {
        $sql .= " WHERE " . implode(" AND ", $filters) . " ";
    }

    $sql .= " GROUP BY o.id ORDER BY o.id DESC ";

    $result = $conn->query($sql);
    return $result;
}
