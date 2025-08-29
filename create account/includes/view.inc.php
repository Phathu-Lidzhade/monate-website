<?php

declare(strict_types=1);

function signup_inputs(){

  if(isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])){
    
  }
}

function check_signup_errors(){
  if (isset($_SESSION['errors_signup'])) {
    $errors = $_SESSION['errors_signup'];

    echo "<br>";

    foreach ($errors as $error){
      echo '<p class="form-error">' . $error . '</p>';
    }

    unset($_SESSION['errors_signup']);
  } else if(isset($_GET["signup"]) && $_GET["signup"] === "success"){
    echo '<br>';
    echo '<p class="form-error">Signup success</p>';
  }
}