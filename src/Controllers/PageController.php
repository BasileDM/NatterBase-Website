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
    $this->render("home");
    exit;
  }

  #[Route('GET', '/features')]
  public function displayAboutPage(): void
  {
    $this->render("features");
    exit;
  }

  #[Route('GET', '/app')]
  #[Authorization(1)]
  public function displayAppPage(): void
  {
    $this->render("app");
    exit;
  }

  public function displayErrorPage(string $message): void
  {
    $this->render("error", ["message" => $message]);
    exit;
  }
}
