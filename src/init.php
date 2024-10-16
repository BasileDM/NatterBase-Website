<?php
session_start();

use src\Database\Database;
use src\Router\Router;

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . "/../config.local.php";

$db = new Database();

try {
  if ($db->init()) {
    header("Location: ./?notice=dbCreated");
    die();
  }
} catch (RuntimeException $e) {
  echo $e->getMessage();
}

$router = new Router();
$requestMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->handleRequest($requestMethod, $uri);
