<?php

namespace src\Controllers;

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
    $userData = $_SESSION['userId'] ?? null;
    $this->render("app", ["section" => "app", "data" => $userData]);
    exit;
  }

  public function displayErrorPage(string $message): void
  {
    $this->render("error", ["section" => "error", "message" => $message]);
    exit;
  }
}
