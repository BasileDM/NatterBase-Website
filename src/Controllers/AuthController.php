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
        'message' => 'Please fill out all the fields',
      ]);
      exit;
    }

    if (!Authenticator::authenticate($mail, $password)) {
      http_response_code(401);
      echo json_encode([
        'message' => 'Invalid credentials',
      ]);
      exit;
    }

    http_response_code(200);
    echo json_encode([
      'message' => 'Login successful',
    ]);
  }

  #[Route('GET', '/logout')]
  public function logout(): void
  {
    http_response_code(200);
    session_destroy();
    echo json_encode([
      'success' => true,
      'message' => 'Logout successful',
    ]);
    header('Location: /');
  }
}