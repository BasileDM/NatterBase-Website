<?php

namespace src\Controllers;

use src\Models\User;
use src\Router\Attributes\Route;
use src\Services\Authenticator;
use src\Services\Response;
use src\Utils\Validator;

final class AuthController
{
  use Response;

  #[Route('POST', '/register')]
  public function register(): void
  {
    $request = json_decode(file_get_contents('php://input'), true);
    $validationResult = Validator::validateInputs($request);

    if (isset($validationResult['errors'])) {
      $this->formErrorsResponse(400, $validationResult['errors']);
      exit;
    }

    $user = new User();
    $result = $user->create($validationResult['sanitized']);
    if (!$result) {
      $this->jsonResponse(400, 'User already exists');
    } else {
      $this->jsonResponse(200, 'Registration successful');
    }
  }

  #[Route('POST', '/login')]
  public function login(): void
  {
    $request = json_decode(file_get_contents('php://input'), true);
    $mail = $request['mail'] ?? null;
    $password = $request['password'] ?? null;

    $statusCode = match (true) {
      !$mail || !$password => 400,
      !Authenticator::authenticate($mail, $password) => 401,
      default => 200,
    };

    $message = match ($statusCode) {
      400 => 'Please fill out all the fields',
      401 => 'Invalid credentials',
      200 => 'Login successful',
    };

    $this->jsonResponse($statusCode, $message);
  }

  #[Route('GET', '/logout')]
  public function logout(): void
  {
    session_destroy();
    $this->jsonResponse(200, 'Logout successful', '/');
  }
}
