<?php

namespace src\Router;

use src\Controllers\PageController;
use src\Router\Attributes\Authorization;
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
  }

  private function loadRoutesFromControllers(array $controllerClasses): void
  {
    foreach ($controllerClasses as $ctrlClass) {
      $ctrlInstance = new $ctrlClass();
      $ctrlMethods = ReflectionUtils::getPublicMethods($ctrlInstance);

      foreach ($ctrlMethods as $ctrlMethod) {
        $routeAttribute = $ctrlMethod->getAttributes(Route::class)[0] ?? [];
        if (!$routeAttribute) continue;

        $authAttribute = $ctrlMethod->getAttributes(Authorization::class)[0] ?? null;
        $authLevel = $authAttribute ? $authAttribute->newInstance()->authLevel : 0;

        $routeInstance = $routeAttribute->newInstance();
        $this->registerRoute(
          $routeInstance->method,
          $routeInstance->path,
          [$ctrlInstance, $ctrlMethod->getName()],
          $authLevel
        );
      }
    }
  }

  private function registerRoute(string $requestMethod, string $path, callable $callback, int $authLevel): void
  {
    $this->routes[$requestMethod][$path] = [
      'callback' => $callback,
      'authLevel' => $authLevel
    ];
  }

  public function handleRequest(): void
  {
    $pageController = new PageController();
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $route = $this->routes[$requestMethod][$path] ?? null;
    $userAuthLevel = $_SESSION['authLevel'] ?? 0;

    if (!$route) {
      http_response_code(404);
      $pageController->displayErrorPage('Page not found.');
      return;
    }

    if ($userAuthLevel < $route['authLevel']) {
      http_response_code(403);
      $pageController->displayErrorPage('Please log in or register to access this content.');
      return;
    }

    http_response_code(200);
    call_user_func($route['callback']);
  }
}
