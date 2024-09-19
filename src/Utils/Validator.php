<?php

namespace src\Utils;

final class Validator
{
  public static function validateInputs(array $request): array
  {
    $inputs = [
      'mail' => $request['mail'] ?? null,
      'username' => $request['username'] ?? null,
      'password' => $request['password'] ?? null,
      'confirmPassword' => $request['confirmPassword'] ?? null,
      'gdpr' => $request['gdpr'] ?? null,
      'name' => $request['name'] ?? null,
    ];

    $errors = [];
    $sanitizedInputs = [];

    if (isset($inputs['name'])) {
      $result = self::validateBotProfileName($inputs['name']);
      if (isset($result['error'])) {
        $errors['name'] = $result['error'];
      } else {
        $sanitizedInputs['name'] = $result['sanitized'];
      }
    }

    if (isset($inputs['mail'])) {
      $result = self::validateMail($inputs['mail']);
      if (isset($result['error'])) {
        $errors['mail'] = $result['error'];
      } else {
        $sanitizedInputs['mail'] = $result['sanitized'];
      }
    }

    if (isset($inputs['username'])) {
      $result = self::validateUsername($inputs['username']);
      if (isset($result['error'])) {
        $errors['username'] = $result['error'];
      } else {
        $sanitizedInputs['username'] = $result['sanitized'];
      }
    }

    if (isset($inputs['password'])) {
      $result = self::validatePassword($inputs['password']);
      if (isset($result['error'])) {
        $errors['password'] = $result['error'];
      } else {
        $sanitizedInputs['passwordHash'] = $result['sanitized'];
      }
    }

    if (isset($inputs['confirmPassword'])) {
      if (!isset($inputs['password']) || $inputs['confirmPassword'] !== $inputs['password']) {
        $errors['password'] = 'Passwords do not match';
      }
    }

    if (isset($inputs['gdpr'])) {
      if ($inputs['gdpr'] !== true) {
        $errors['gdpr'] = 'You must accept the GDPR';
      }
    }

    if (!empty($errors)) {
      return ['errors' => $errors];
    }
    return ['sanitized' => $sanitizedInputs];
  }

  private static function validateBotProfileName(string $name): array
  {
    $cleanName = self::sanitizeString($name);
    if ($cleanName !== $name) {
      return ['error' => 'Name can\'t contain special characters'];
    }
    if (strlen($name) < 3 || strlen($name) > 50) {
      return ['error' => 'Name must be between 3 and 50 characters'];
    }

    return ['sanitized' => $cleanName];
  }

  private static function validateMail(string $email): array
  {
    $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

    if ($sanitizedEmail !== $email || !filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)) {
      return ['error' => 'Invalid email address'];
    }

    if (strlen($sanitizedEmail) < 3 || strlen($sanitizedEmail) > 80) {
      return ['error' => 'Email must be between 3 and 80 characters'];
    }

    return ['sanitized' => $sanitizedEmail];
  }

  private static function validatePassword(string $password): array
  {
    if (strlen($password) < 8) {
      return ['error' => 'Password must be at least 8 characters long'];
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    return ['sanitized' => $hashedPassword];
  }

  private static function validateUsername(string $username): array
  {
    $cleanUsername = self::sanitizeString($username);

    if ($cleanUsername !== $username) {
      return ['error' => 'Username can\'t contain special characters'];
    }

    if (strlen($username) < 3 || strlen($username) > 80) {
      return ['error' => 'Username must be between 3 and 80 characters'];
    }
    return ['sanitized' => $cleanUsername];
  }

  private static function sanitizeString(string $string): string
  {
    $string = trim($string);
    $string = strip_tags($string);
    $string = htmlspecialchars($string);
    return $string;
  }
}
