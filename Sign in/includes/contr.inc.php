<?php

declare(strict_types=1);

function is_input_empty(string $email,string $login_pwd){

  if (empty($email) || empty($login_pwd)) {
    return true;
  }
  else {
    return false;
  }
}

function is_email_invalid(string $email){
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return true;
  }
  else {
    return false;
  }
}

function is_email_wrong(array|bool $result){
  if (!$result) {
    return true;
  }
  else {
    return false;
  }
}

function is_password_wrong(string $login_pwd, string $pwd){
  if (!password_verify($login_pwd, $pwd)) {
    return true;
  }
  else {
    return false;
  }
}