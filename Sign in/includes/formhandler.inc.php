<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

  $email = $_POST["email"];
  $login_pwd = $_POST["password"];

  try {
    require_once "../../api/dbh.inc.php";
    require_once "model.inc.php";
    require_once "view.inc.php";
    require_once "contr.inc.php";
    

    $errors = [];

    if (is_input_empty($email, $login_pwd)) {
      $errors["empty_imput"] = "Fill in all fields";
    }
    if (is_email_invalid($email)) {
      $errors["invalid_email"] = "Invalid email used";
    }

    $result = get_user($pdo, $email);

    if (is_email_wrong($result)) {
      $errors["login_incorrect"] = "Incorrect login info";
    }
    if (!is_email_wrong($result) && is_password_wrong($login_pwd, $result["pwd"])) {
      $errors["login_incorrect"] = "Incorrect login info";
    }


    require_once "../../api/config_session.inc.php";

    if ($errors) {
      $_SESSION["errors_signin"] = $errors;

      header("Location: ../../../signin.php");
      die();
    }

    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $result["id"];
    session_id($sessionId);

    $_SESSION["user_id"] = $result["id"];
    $_SESSION["user_name"] = htmlspecialchars($result["name"]);
    $_SESSION["last_regeneration"] = time();

    header("Location: ../../../../menu/Thohoyandou.html");
    #?signin=success

    $pdo = null;
    $stmt = null;

    die();

  } catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
  }

} else{
  header("Location: ../../../signin.php");
  die();
}
