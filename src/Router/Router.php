<?php

namespace src\Router;

use src\Controllers\PageController;
use src\Router\Attributes\Route;
use src\Utils\ReflectionUtils;

class Router
{
  private array $routes = [];
  private array $controllers;

  public function __construct()
  {
    $this->controllers = [
      PageController::class
    ];
    $this->loadRoutesFromControllers($this->controllers);
    $this->handleRequest();
  }

  private function loadRoutesFromControllers(array $controllerClasses): void
  {
    foreach ($controllerClasses as $ctrlClass) {
      $ctrlInstance = new $ctrlClass();
      $ctrlMethods = ReflectionUtils::getPublicMethods($ctrlInstance);

      foreach ($ctrlMethods as $ctrlMethod) {
        $routeAttribute = $ctrlMethod->getAttributes(Route::class)[0] ?? [];
        if (!$routeAttribute) continue;

        $routeInstance = $routeAttribute->newInstance();
        $this->registerRoute(
          $routeInstance->method,
          $routeInstance->path,
          [$ctrlInstance, $ctrlMethod->getName()]
        );
      }
    }
  }

  private function registerRoute(string $requestMethod, string $path, callable $function): void
  {
    $this->routes[$requestMethod][$path] = $function;
  }

  public function handleRequest(): void
  {
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    if (isset($this->routes[$requestMethod][$path])) {
      call_user_func($this->routes[$requestMethod][$path]);
    } else {
      http_response_code(404);
      $pageController = new PageController();
      $pageController->displayNotFoundPage();
    }
  }
}
