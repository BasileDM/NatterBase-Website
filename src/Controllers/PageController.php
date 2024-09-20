<?php

namespace src\Controllers;

use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\BotService;
use src\Services\Response;
use src\Services\UserService;
use src\Utils\ErrorUtils;

final class PageController
{
  private $botService;
  private $userService;

  public function __construct()
  {
    $this->botService = new BotService();
    $this->userService = new UserService();
  }

  use Response;

  #[Route('GET', '/')]
  public function redirectToHomePage(): void
  {
    header("Location: /home");
    exit;
  }

  #[Route('GET', '/home')]
  public function displayHomePage(): void
  {
    $this->render("home", ["section" => "home"]);
    exit;
  }

  #[Route('GET', '/features')]
  public function displayAboutPage(): void
  {
    $this->render("features", ["section" => "features"]);
    exit;
  }

  #[Route('GET', '/app')]
  #[Authorization(1)]
  public function displayAppPage(): void
  {
    $userData = $this->userService->getAllCurrentUserData();
    $this->render("app", ["section" => "app", "userData" => $userData]);
    exit;
  }

  #[Route('GET', '/error')]
  public function displayErrorPage(): void
  {
    [$code, $message] = ErrorUtils::getErrorCodeAndMessage();
    $this->render("error", ["section" => "error", "message" => $message, "code" => $code]);
    exit;
  }
}
