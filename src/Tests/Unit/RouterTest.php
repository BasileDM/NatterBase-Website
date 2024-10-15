<?php

namespace src\Tests\Unit;

use PHPUnit\Framework\TestCase;
use src\Router\Router;

class RouterTest extends TestCase
{
  public function testHandleRequestValid()
  {
    $router = new Router();
    $requestMethod = 'GET';
    $requestUri = '/test';
    $router->handleRequest($requestMethod, $requestUri);
  }
}