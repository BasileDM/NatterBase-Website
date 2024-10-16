<?php

namespace src\Router;

use src\Controllers\api\ApiBotController;
use src\Controllers\api\ApiUserController;
use src\Controllers\AuthController;
use src\Controllers\PageController;
use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Utils\ReflectionUtils;

class Router
{
  private array $routes = [];
  private array $controllers;

  public function __construct(array $controllerClasses = [])
  {
    $this->controllers = $controllerClasses ?: [
      PageController::class,
      AuthController::class,
      ApiBotController::class,
      ApiUserController::class
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

  public function handleRequest(string $requestMethod, string $requestUri): void
  {
    // Get URI without parameters
    $uri = parse_url($requestUri, PHP_URL_PATH);
    // Remove the subdirectory from the URI
    $subDirectory = dirname($_SERVER['SCRIPT_NAME']);
    $path = str_replace($subDirectory, '', $uri);
    
    $route = $this->routes[$requestMethod][$path] ?? null;
    $userAuthLevel = $_SESSION['authLevel'] ?? 0;

    if (!$route) {
      http_response_code(404);
      call_user_func($this->routes['GET']['/error']['callback']);
      return;
    }

    if ($userAuthLevel < $route['authLevel']) {
      http_response_code(401);
      call_user_func($this->routes['GET']['/error']['callback']);
      return;
    }

    call_user_func($route['callback']);
  }
}
