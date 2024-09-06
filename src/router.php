<?php

use src\Controllers\HomeController;
$route = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$homeController = new HomeController();

switch ($route)
{
  case HOME_URL:
    header('location: ' . HOME_URL . 'home');
    break;

  case HOME_URL . 'home':
    $homeController->displayHomePage();
    break;

  default:
    echo '404 not found.';
    break;
}
