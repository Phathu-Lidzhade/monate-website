<?php

/**
 * Database Test Script
 * 
 * This script helps verify database connectivity and table structure.
 * Run this in your browser to check if everything is working.
 */

// Include database connection
require_once 'api/dbh.inc.php';

echo "<h1>Database Connection Test</h1>";

try {
  // Test basic connection
  echo "<h2>✅ Database Connection: SUCCESS</h2>";

  // Check if tables exist
  $tables = ['users', 'admins'];

  foreach ($tables as $table) {
    $query = "SHOW TABLES LIKE :table";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":table", $table);
    $stmt->execute();

    if ($stmt->fetch()) {
      echo "<h3>✅ Table '$table' exists</h3>";

      // Show table structure
      $structureQuery = "DESCRIBE `$table`";
      $structureStmt = $pdo->query($structureQuery);
      $columns = $structureStmt->fetchAll(PDO::FETCH_ASSOC);

      echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
      echo "<tr><th>Column</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";

      foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>{$column['Field']}</td>";
        echo "<td>{$column['Type']}</td>";
        echo "<td>{$column['Null']}</td>";
        echo "<td>{$column['Key']}</td>";
        echo "<td>{$column['Default']}</td>";
        echo "</tr>";
      }
      echo "</table>";

      // Show sample data
      $dataQuery = "SELECT * FROM `$table` LIMIT 3";
      $dataStmt = $pdo->query($dataQuery);
      $data = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

      if ($data) {
        echo "<h4>Sample data from '$table':</h4>";
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";

        // Headers
        echo "<tr>";
        foreach (array_keys($data[0]) as $header) {
          if ($header !== 'password') { // Don't show passwords
            echo "<th>$header</th>";
          }
        }
        echo "</tr>";

        // Data rows
        foreach ($data as $row) {
          echo "<tr>";
          foreach ($row as $key => $value) {
            if ($key !== 'password') { // Don't show passwords
              echo "<td>" . htmlspecialchars($value) . "</td>";
            }
          }
          echo "</tr>";
        }
        echo "</table>";
      } else {
        echo "<p>No data found in table '$table'</p>";
      }
    } else {
      echo "<h3>❌ Table '$table' does not exist</h3>";
    }
  }

  // Test user authentication
  echo "<h2>Testing User Authentication</h2>";

  // Check if we can find a test user
  $testQuery = "SELECT id, username, email, name FROM users WHERE email = 'test@example.com'";
  $testStmt = $pdo->query($testQuery);
  $testUser = $testStmt->fetch(PDO::FETCH_ASSOC);

  if ($testUser) {
    echo "<p>✅ Test user found: {$testUser['username']} ({$testUser['email']})</p>";
  } else {
    echo "<p>❌ Test user not found. You may need to run the database setup script.</p>";
  }

  // Test admin authentication
  echo "<h2>Testing Admin Authentication</h2>";

  $adminQuery = "SELECT id, name, email, role FROM admins WHERE email = 'admin@restaurant.com'";
  $adminStmt = $pdo->query($adminQuery);
  $adminUser = $adminStmt->fetch(PDO::FETCH_ASSOC);

  if ($adminUser) {
    echo "<p>✅ Admin user found: {$adminUser['name']} ({$adminUser['email']}) - Role: {$adminUser['role']}</p>";
  } else {
    echo "<p>❌ Admin user not found. You may need to run the database setup script.</p>";
  }
} catch (PDOException $e) {
  echo "<h2>❌ Database Error</h2>";
  echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
} catch (Exception $e) {
  echo "<h2>❌ General Error</h2>";
  echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<h2>Next Steps</h2>";
echo "<ol>";
echo "<li>If you see any ❌ errors above, run the database setup script first</li>";
echo "<li>Make sure your database credentials in api/dbh.inc.php are correct</li>";
echo "<li>Verify that the 'food_ordering' database exists</li>";
echo "<li>Check that all tables have the correct structure</li>";
echo "</ol>";

echo "<h3>Database Setup Commands:</h3>";
echo "<p>1. Create database: <code>CREATE DATABASE food_ordering;</code></p>";
echo "<p>2. Run setup script: <code>source database_setup.sql;</code></p>";
echo "<p>3. Or run individual table scripts from admin/setup_admin_table.sql</p>";
