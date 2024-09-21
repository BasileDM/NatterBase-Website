<?php
session_start();

use src\Database\Database;
use src\Router\Router;

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . "/../config.local.php";

$db = new Database();

try {
  if ($db->init()) {
    header("Location: /home?notice=dbCreated");
    die();
  }
} catch (RuntimeException $e) {
  echo $e->getMessage();
}
$router = new Router();
$router->handleRequest();
