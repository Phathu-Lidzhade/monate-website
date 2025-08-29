<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

  $username = $_POST["username"];
  $email = $_POST["email"];
  $phone_number = $_POST["phone_number"];
  $pwd = $_POST["password"];

  try {
    require_once "../../api/dbh.inc.php";

    $query = "UPDATE user SET pwd = :pwd WHERE ;";
    
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone_number", $phone_number);
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
