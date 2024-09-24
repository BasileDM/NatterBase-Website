<?php

namespace src\Controllers\api;

use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\Response;
use src\Services\UserService;
use src\Utils\Validator;

final class ApiUserController
{
  private UserService $userService;

  public function __construct()
  {
    $this->userService = new UserService();
  }

  use Response;

  #[Route('GET', '/api/userData')]
  #[Authorization(1)]
  public function getUserData()
  {
    $currentUserData = $this->userService->getAllCurrentUserData();
    return $this->jsonResponse(200, $currentUserData);
  }

  #[Route('POST', '/api/updateUserData')]
  #[Authorization(1)]
  public function updateUserData()
  {
    $validation = Validator::validateInputs();
    if (isset($validation['errors'])) {
      $this->formErrorsResponse(400, $validation['errors']);
      exit;
    }
    $result = $this->userService->updateUserData($validation['sanitized']);
    if (!$result) {
      $this->jsonResponse(400, ['message' => 'Could not update user data']);
      exit;
    }
    $this->jsonResponse(200, ['message' => 'User data updated successfully']);
  }
}