<?php

namespace src\Controllers;

use Exception;
use src\Repositories\UserRepository;
use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\Authenticator;
use src\Services\MailService;
use src\Services\Response;
use src\Services\UserService;
use src\Utils\Validator;

final class AuthController
{
  private UserService $userService;

  public function __construct()
  {
    $this->userService = new UserService();
  }

  use Response;

  #[Route('POST', '/register')]
  public function register(): void
  {
    try {

      $validationResult = Validator::validateInputs();

      if (isset($validationResult['errors'])) {
        $this->formErrorsResponse(400, $validationResult['errors']);
        exit;
      }

      $user = $this->userService->create($validationResult['sanitized']);

      if (!$user) {
        $this->jsonResponse(400, ['message' => 'User already exists']);
      } else {
        MailService::sendActivationMail($user);
        $this->jsonResponse(200, ['message' => 'Registration successful']);
      }
    } catch (Exception $e) {
      $this->jsonResponse(500, ['message' => 'Internal server error']);
    }
  }

  #[Route('GET', '/activate')]
  public function activateUser(): void
  {
    try {
      $token = $_GET['token'] ?? '';
      $result = $this->userService->activateUser($token);

      $notices = [
        'Invalid or expired activation link' => 'expired',
        'User not found' => 'invalid',
        'Account already activated' => 'already',
      ];

      if ($result['status'] === 'error') {
        $notice = $notices[$result['message']] ?? 'error';
        $this->jsonResponse(400, ['message' => $result['message']], './?notice=' . $notice);
      } else {
        $this->jsonResponse(200, ['message' => 'Account activated'], './?notice=activated');
      }
    } catch (Exception $e) {
      $this->jsonResponse(500, ['message' => 'Internal server error']);
    }
  }

  #[Route('POST', '/login')]
  public function login(): void
  {
    try {
      $request = json_decode(file_get_contents('php://input'), true);
      $mail = $request['mail'] ?? null;
      $password = $request['password'] ?? null;
      $user = Authenticator::authenticate($mail, $password);

      $statusCode = match (true) {
        !$mail || !$password => 400,
        !$user => 401,
        !$user->isIsActivated() => 403,
        default => 200,
      };

      $message = match ($statusCode) {
        400 => 'Please fill out all the fields',
        401 => 'Invalid credentials',
        403 => 'Check your mails and activate your account first!',
        200 => 'Login successful',
      };

      $this->jsonResponse($statusCode, ['message' => $message]);
    } catch (Exception $e) {
      $this->jsonResponse(500, ['message' => 'Internal server error']);
    }
  }

  #[Route('GET', '/logout')]
  public function logout(): void
  {
    session_destroy();
    $this->jsonResponse(200, ['message' => 'Logout successful'], './');
  }

  #[Route('GET', '/dropt')]
  #[Authorization(2)]
  public function dropTables()
  {
    $userRepo = new UserRepository();
    $userRepo->dropTables();
    echo 'Tables dropped';
    exit;
  }
}
