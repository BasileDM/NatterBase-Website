<?php

namespace src\Controllers\api;

use Exception;
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
    try {
      $currentUserData = $this->userService->getAllCurrentUserData();
      return $this->jsonResponse(200, $currentUserData);
    } catch (Exception $e) {
      $this->jsonResponse(500, ['message' => "Backend error"]);
    }
  }

  #[Route('POST', '/api/updateUserData')]
  #[Authorization(1)]
  public function updateUserData()
  {
    try {
      $request = json_decode(file_get_contents('php://input'), true);
      $validation = Validator::validateInputs($request);

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
    } catch (Exception $e) {
      $this->jsonResponse(500, ['message' => "Backend error"]);
    }
  }

  #[Route('DELETE', '/api/deleteUser')]
  #[Authorization(1)]
  public function deleteUser()
  {
    try {
      $result = $this->userService->deleteUser();
      if (!$result) {
        $this->jsonResponse(400, ['message' => 'Could not delete user']);
        exit;
      }
      $this->jsonResponse(200, ['message' => 'User deleted successfully']);
    } catch (Exception $e) {
      $this->jsonResponse(500, ['message' => "Backend error"]);
    }
  }
}
