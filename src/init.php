<?php

use src\Controllers\HomeController;
use src\Router\Router;

require_once __DIR__ . '/autoload.php';

session_start();

require_once __DIR__ . "/../config.local.php";

// if (DB_INITIALIZED == FALSE)
// {
//   $db = new src\Models\Database();
//   echo $db->dbInit();
// }

// require_once __DIR__ . "/router.php";

$router = new Router();

$router->loadRoutesFromControllers([HomeController::class]);

$route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($method, $route);
