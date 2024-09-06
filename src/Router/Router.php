<?php

namespace src\Router;

use ReflectionClass;
use ReflectionMethod;
use src\Router\Route;

class Router
{
  private array $routes = [];

  public function registerRoute(string $method, string $path, callable $callback): void
  {
    $this->routes[$method][$path] = $callback;
  }

  public function dispatch(string $method, string $path): void
  {
    if (isset($this->routes[$method][$path])) {
      call_user_func($this->routes[$method][$path]);
    } else {
      http_response_code(404);
      echo "404 Not Found.";
    }
  }

  public function loadRoutesFromControllers(array $controllers): void
  {
    foreach ($controllers as $controller) {
      $controller = new $controller();
      $reflector = new ReflectionClass($controller);

      foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
        $attributes = $method->getAttributes(Route::class);

        foreach ($attributes as $attribute) {
          $route = $attribute->newInstance();
          $this->registerRoute($route->method, $route->path, [$controller, $method->getName()]);
        }
      }
    }
  }
}
