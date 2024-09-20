<?php

namespace src\Controllers;

use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\BotService;
use src\Services\Response;
use src\Utils\ErrorUtils;

final class PageController
{
  private $botService;

  public function __construct()
  {
    $this->botService = new BotService();
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
    $userData = [
      "botProfiles" => $this->botService->getUserBotsArray($_SESSION['userId']),
    ];
    $this->render("app", ["section" => "app", "data" => $userData]);
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
