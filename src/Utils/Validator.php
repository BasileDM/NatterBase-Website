<?php

namespace src\Utils;

final class Validator
{
  public static function validateEmail(string $email): bool
  {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }
}