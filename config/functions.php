<?php

function verifPassword($password, $c_password)
{
  if (!empty($password) && !empty($c_password)) {
    if($password === $c_password) {
      return true;
    } else {
      return false;
    }
  }
}