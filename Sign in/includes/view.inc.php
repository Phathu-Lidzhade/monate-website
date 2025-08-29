<?php

declare(strict_types=1);

function check_login_errors() {
  if (isset($_SESSION["errors_signin"])) {
    $errors = $_SESSION["errors_signin"];

    echo "<br>";

    foreach ($errors as $error) {
      echo '<p class="form-error">' . $error . '</p>';
    }

    unset($_SESSION["errors_signin"]);
  }
}