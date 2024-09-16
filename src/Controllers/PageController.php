<?php

namespace src\Controllers;

use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\Response;

class PageController
{
  use Response;

  #[Route('GET', HOME_URL)]
  public function displayHomePage(): void
  {
    $this->render("home");
    exit;
  }

  #[Route('GET', HOME_URL . 'about')]
  public function displayAboutPage(): void
  {
    $this->render("about");
    exit;
  }

  public function displayErrorPage(string $message): void
  {
    $this->render("Error", ["message" => $message]);
    exit;
  }
}
