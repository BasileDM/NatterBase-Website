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

        $authAttribute = $ctrlMethod->getAttributes(Authorization::class)[0] ?? null;
        $authLevel = $authAttribute ? $authAttribute->newInstance()->authLevel : 0;

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

  private function handleRequest(): void
  {
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $route = $this->routes[$requestMethod][$path];
    $userAuthLevel = isset($_SESSION['authLevel']) ? $_SESSION['authLevel'] : 0;

    if (isset($route) && $userAuthLevel >= $route['authLevel']) {
      call_user_func($route['callback']);
    } else {
      http_response_code(404);
      $pageController = new PageController();
      $pageController->displayNotFoundPage();
    }
  }
}
