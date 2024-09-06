<?php

session_start();

use src\Database\Database;
use src\Router\Router;

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . "/../config.local.php";

$db = new Database();

try {
  if ($db->init()) echo "Database tables created successfully!";
} catch (Exception $e) {
  error_log($e->getMessage());
}

$router = new Router();

$method = $_SERVER['REQUEST_METHOD'];
$route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->dispatch($method, $route);
