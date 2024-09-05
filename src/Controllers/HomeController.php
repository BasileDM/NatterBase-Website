<?php

namespace src\controllers;

use src\Services\Response;

class HomeController
{
  use Response;

  public function displayHomePage()
  {
    $this->render("home");
    exit;
  }
}
