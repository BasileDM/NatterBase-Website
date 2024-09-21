<?php

namespace src\Controllers\api;

use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\Response;
use src\Services\UserService;

final class UserController
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
    var_dump($this->userService->getAllCurrentUserData());
    exit;
    return $this->jsonResponse(200, ['userData' => $this->userService->getAllCurrentUserData()]);
  }
}