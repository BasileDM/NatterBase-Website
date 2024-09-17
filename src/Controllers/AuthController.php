<?php

namespace src\Controllers;

use src\Router\Attributes\Route;
use src\Services\Authenticator;
use src\Services\Response;

final class AuthController
{
  use Response;

  #[Route('POST', '/login')]
  public function login(): void
  {
    $request = json_decode(file_get_contents('php://input'), true);
    $mail = $request['mail'] ?? null;
    $password = $request['password'] ?? null;

    $responseCode = match (true) {
      !$mail || !$password => 400,
      !Authenticator::authenticate($mail, $password) => 401,
      default => 200,
    };

    $message = match ($responseCode) {
      400 => 'Please fill out all the fields',
      401 => 'Invalid credentials',
      200 => 'Login successful',
    };

    $this->jsonResponse($message, $responseCode);
  }

  #[Route('GET', '/logout')]
  public function logout(): void
  {
    session_destroy();
    $this->jsonResponse('Logout successful', 200, HOME_URL);
  }
}
