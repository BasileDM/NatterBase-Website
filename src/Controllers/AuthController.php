<?php

namespace src\Controllers;

use src\Router\Attributes\Route;
use src\Services\Authenticator;

final class AuthController
{

  #[Route('POST', '/login')]
  public function login(): void
  {
    $request = json_decode(file_get_contents('php://input'), true);
    $mail = $request['mail'] ?? null;
    $password = $request['password'] ?? null;

    if(!$mail || !$password) {
      http_response_code(400);
      echo json_encode([
        'success' => false,
        'message' => 'Missing parameters',
      ]);
      exit;
    }

    if (!Authenticator::authenticate($mail, $password)) {
      http_response_code(401);
      echo json_encode([
        'success' => false,
        'message' => 'Invalid credentials',
      ]);
      exit;
    }

    http_response_code(200);
    echo json_encode([
      'success' => true,
      'message' => 'Login successful',
    ]);
  }
}