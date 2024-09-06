<?php

namespace src\Controllers;

use src\Router\Route;
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
}
