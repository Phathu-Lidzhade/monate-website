<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

  $username = $_POST["username"];
  $email = $_POST["email"];
  $phoneNumber = $_POST["phoneNumber"];
  $pwd = $_POST["password"];

  try {
    require_once "../../api/dbh.inc.php";

    $query = "INSERT INTO users (username, email, phoneNumber, pwd) VALUES (:username, :email, :phoneNumber, :pwd);";
    
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phoneNumber", $phoneNumber);
    $stmt->bindParam(":pwd", $pwd);

    $stmt->execute();

    $pdo = null;
    $stmt = null;

    header("Location: ../index.html");
    die();

  } catch (PDOException $e) {
    die("query failed: " . $e->getMessage());
  }

} else{
  header("Location: ../index.html");
}
