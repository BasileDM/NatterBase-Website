<?php

namespace src\Controllers;

use src\Models\Bot;
use src\Repositories\BotRepository;
use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\Response;

final class PageController
{
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
    $botRepository = new BotRepository();
    $bots = $botRepository->getByUserId($_SESSION['userId']);
    $botsArray = array_map(fn (Bot $bot) => $bot->toArray(), $bots);
    $userData = [
      "botProfiles" => $botsArray,
    ];
    $this->render("app", ["section" => "app", "data" => $userData]);
    exit;
  }

  #[Route('GET', '/error')]
  public function displayErrorPage(): void
  {
    $code = $_GET['code'] ?? null;
    if (!$code) $code = 404;
    $message = match ((int)$code) {
      400 => 'Bad Request',
      401 => 'Please login or register to access the app',
      403 => 'Forbidden',
      404 => 'Page Not Found',
      500 => 'Internal Server Error',
      503 => 'Service Unavailable',
      504 => 'Gateway Timeout',
      429 => 'Too Many Requests',
      default => 'Error',
    };
    $this->render("error", ["section" => "error", "message" => $message, "code" => $code]);
    exit;
  }
}
