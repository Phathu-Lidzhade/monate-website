<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

  $username = $_POST["username"];
  $email = $_POST["email"];
  $phone_number = $_POST["phone_number"];
  $pwd = $_POST["password"];

  try {
    require_once "../../api/dbh.inc.php";
    require_once "model.inc.php";
    require_once "view.inc.php";
    require_once "contr.inc.php";
    

    $errors = [];

    if (is_input_empty($username, $email, $phone_number, $pwd)) {
      $errors["empty_imput"] = "Fill in all fields";
    }
    if (is_email_invalid($email)) {
      $errors["invalid_email"] = "Invalid email used";
    }
    if (is_username_take($pdo, $username)) {
      $errors["username_taken"] = "Username already taken";
    }
    if (is_email_registered($pdo, $email)) {
      $errors["email_used"] = "Email alreadt registered";
    }

    require_once "../../api/config_session.inc.php";

    if ($errors) {
      $_SESSION["errors_signup"] = $errors;

      $signupData = [
        "username" => $username,
        "email" => $email,
        "phone_number" => $phone_number
      ];
      $_SESSION["signup_data"] = $signupData;

      header("Location: ../signup.php");
      die();
    }

    create_user($pdo, $username, $email, $phone_number, $pwd);

    header("Location: ../signup.php?signup=success");

    $pdo = null;
    $stmt = null;

    die();

  } catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
  }

} else{
  header("Location: ../signup.php");
  die();
}
