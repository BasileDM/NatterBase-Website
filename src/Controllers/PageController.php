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
    $this->render("home", ["section" => "home"]);
  }

  #[Route('GET', '/home')]
  public function displayHomePage(): void
  {
    header("Location: ./");
  }

  #[Route('GET', '/docs')]
  public function displayAboutPage(): void
  {
    $this->render("docs", ["section" => "docs"]);
  }

  #[Route('GET', '/app')]
  #[Authorization(1)]
  public function displayAppPage(): void
  {
    $userData = $this->userService->getAllCurrentUserData();
    $this->render("app", ["section" => "app", "userData" => $userData]);
  }

  #[Route('GET', '/error')]
  public function displayErrorPage(): void
  {
    [$code, $message] = ErrorUtils::getErrorCodeAndMessage();
    http_response_code($code);
    $this->render("error", ["section" => "error", "message" => $message, "code" => $code]);
  }
}
