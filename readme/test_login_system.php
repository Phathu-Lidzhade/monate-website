<?php

/**
 * Comprehensive Login System Test
 * This script tests the entire login system to ensure everything works
 */

session_start();

echo "<h1>🔐 Login System Test</h1>";

try {
  // Test database connection
  require_once "api/dbh.inc.php";
  echo "<h2>✅ Database Connection: SUCCESS</h2>";

  // Test users table structure
  echo "<h3>📊 Users Table Structure:</h3>";
  $stmt = $pdo->query("DESCRIBE users");
  $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
  echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
  foreach ($columns as $column) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($column['Field']) . "</td>";
    echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
    echo "<td>" . htmlspecialchars($column['Null']) . "</td>";
    echo "<td>" . htmlspecialchars($column['Key']) . "</td>";
    echo "<td>" . htmlspecialchars($column['Default']) . "</td>";
    echo "<td>" . htmlspecialchars($column['Extra']) . "</td>";
    echo "</tr>";
  }
  echo "</table>";

  // Test admin table structure
  echo "<h3>👑 Admin Table Structure:</h3>";
  $stmt = $pdo->query("DESCRIBE admin");
  $adminColumns = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
  echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
  foreach ($adminColumns as $column) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($column['Field']) . "</td>";
    echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
    echo "<td>" . htmlspecialchars($column['Null']) . "</td>";
    echo "<td>" . htmlspecialchars($column['Key']) . "</td>";
    echo "<td>" . htmlspecialchars($column['Default']) . "</td>";
    echo "<td>" . htmlspecialchars($column['Extra']) . "</td>";
    echo "</tr>";
  }
  echo "</table>";

  // Test user data
  echo "<h3>👤 Test User Data:</h3>";
  $stmt = $pdo->query("SELECT id, username, email, phone_number FROM users WHERE email = 'test@example.com'");
  $testUser = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($testUser) {
    echo "<p>✅ Test user found:</p>";
    echo "<ul>";
    echo "<li><strong>ID:</strong> " . htmlspecialchars($testUser['id']) . "</li>";
    echo "<li><strong>Username:</strong> " . htmlspecialchars($testUser['username']) . "</li>";
    echo "<li><strong>Email:</strong> " . htmlspecialchars($testUser['email']) . "</li>";
    echo "<li><strong>Phone:</strong> " . htmlspecialchars($testUser['phone_number']) . "</li>";
    echo "</ul>";
  } else {
    echo "<p>❌ Test user not found</p>";
  }

  // Test admin data
  echo "<h3>👑 Test Admin Data:</h3>";
  $stmt = $pdo->query("SELECT id, name, email FROM admin WHERE email = 'admin@restaurant.com'");
  $testAdmin = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($testAdmin) {
    echo "<p>✅ Test admin found:</p>";
    echo "<ul>";
    echo "<li><strong>ID:</strong> " . htmlspecialchars($testAdmin['id']) . "</li>";
    echo "<li><strong>Name:</strong> " . htmlspecialchars($testAdmin['name']) . "</li>";
    echo "<li><strong>Email:</strong> " . htmlspecialchars($testAdmin['email']) . "</li>";
    echo "</ul>";
  } else {
    echo "<p>❌ Test admin not found</p>";
  }

  // Test the get_user function
  echo "<h3>🔍 Testing get_user Function:</h3>";
  require_once "sign in/includes/model.inc.php";

  if ($testUser) {
    $result = get_user($pdo, $testUser['email']);

    if ($result) {
      echo "<p>✅ get_user function works! Available keys:</p>";
      echo "<ul>";
      foreach (array_keys($result) as $key) {
        if ($key !== 'pwd') {
          echo "<li><strong>$key</strong>: " . htmlspecialchars($result[$key]) . "</li>";
        } else {
          echo "<li><strong>$key</strong>: [HIDDEN] - Length: " . strlen($result[$key]) . "</li>";
        }
      }
      echo "</ul>";

      // Check if password column exists
      if (isset($result['pwd'])) {
        echo "<p>✅ Password column found: 'pwd'</p>";
      } else {
        echo "<p>❌ Password column 'pwd' not found!</p>";
        echo "<p>Available columns: " . implode(', ', array_keys($result)) . "</p>";
      }
    } else {
      echo "<p>❌ get_user function failed</p>";
    }
  }

  // Test the get_admin function
  echo "<h3>🔍 Testing get_admin Function:</h3>";
  require_once "admin/includes/model.inc.php";

  if ($testAdmin) {
    $result = get_admin($pdo, $testAdmin['email']);

    if ($result) {
      echo "<p>✅ get_admin function works! Available keys:</p>";
      echo "<ul>";
      foreach (array_keys($result) as $key) {
        if ($key !== 'pwd') {
          echo "<li><strong>$key</strong>: " . htmlspecialchars($result[$key]) . "</li>";
        } else {
          echo "<li><strong>$key</strong>: [HIDDEN] - Length: " . strlen($result[$key]) . "</li>";
        }
      }
      echo "</ul>";

      // Check if password column exists
      if (isset($result['pwd'])) {
        echo "<p>✅ Password column found: 'pwd'</p>";
      } else {
        echo "<p>❌ Password column 'pwd' not found!</p>";
        echo "<p>Available columns: " . implode(', ', array_keys($result)) . "</p>";
      }
    } else {
      echo "<p>❌ get_admin function failed</p>";
    }
  }
} catch (PDOException $e) {
  echo "<h2>❌ Database Error:</h2>";
  echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
} catch (Exception $e) {
  echo "<h2>❌ General Error:</h2>";
  echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}

// Show any session errors
if (isset($_SESSION["errors_signin"])) {
  echo "<h3>⚠️ Login Errors:</h3>";
  echo "<pre>";
  print_r($_SESSION["errors_signin"]);
  echo "</pre>";
  unset($_SESSION["errors_signin"]);
}

if (isset($_SESSION["errors_admin"])) {
  echo "<h3>⚠️ Admin Login Errors:</h3>";
  echo "<pre>";
  print_r($_SESSION["errors_admin"]);
  echo "</pre>";
  unset($_SESSION["errors_admin"]);
}
?>

<h2>🧪 Test Login Forms:</h2>

<h3>User Login Test:</h3>
<form method="POST" action="sign in/includes/formhandler.inc.php">
  <p>
    <label>Email: <input type="email" name="email" value="test@example.com" required></label>
  </p>
  <p>
    <label>Password: <input type="password" name="password" value="test123" required></label>
  </p>
  <p>
    <button type="submit">Test User Login</button>
  </p>
</form>

<h3>Admin Login Test:</h3>
<form method="POST" action="admin/includes/formhandler.inc.php">
  <p>
    <label>Email: <input type="email" name="email" value="admin@restaurant.com" required></label>
  </p>
  <p>
    <label>Password: <input type="password" name="password" value="admin123" required></label>
  </p>
  <p>
    <button type="submit">Test Admin Login</button>
  </p>
</form>

<h3>📋 Test Credentials:</h3>
<ul>
  <li><strong>User Login:</strong> test@example.com / test123</li>
  <li><strong>Admin Login:</strong> admin@restaurant.com / admin123</li>
</ul>