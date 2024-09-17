<?php

namespace src\Controllers;

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
    } else {
      // Authenticator::register($validationResult['sanitized']);
      $this->jsonResponse(200, 'Registration successful!');
      exit;
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
