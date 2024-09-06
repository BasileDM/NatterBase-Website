<?php

session_start();

use src\Controllers\PageController;
use src\Router\Router;

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . "/../config.local.php";

// if (DB_INITIALIZED == FALSE)
// {
//   $db = new src\Models\Database();
//   echo $db->dbInit();
// }

$router = new Router();

$router->loadRoutesFromControllers([PageController::class]);

$route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($method, $route);
