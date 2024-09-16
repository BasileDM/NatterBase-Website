<?php

namespace src\Controllers;

use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\Response;

final class PageController
{
  use Response;

  #[Route('GET', HOME_URL)]
  public function displayHomePage(): void
  {
    $this->render("home");
    exit;
  }

  #[Route('GET', HOME_URL . 'features')]
  public function displayAboutPage(): void
  {
    $this->render("features");
    exit;
  }

  #[Route('GET', HOME_URL . 'app')]
  #[Authorization(1)]
  public function displayAppPage(): void
  {
    $this->render("app");
    exit;
  }

  public function displayErrorPage(string $message): void
  {
    $this->render("Error", ["message" => $message]);
    exit;
  }
}
