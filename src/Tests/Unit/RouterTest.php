<?php

namespace src\Tests\Unit;

require_once __DIR__ . '/../Classes/TestHelper.php';

use PHPUnit\Framework\TestCase;
use src\Router\Router;
use src\Tests\Classes\MockController;

class RouterTest extends TestCase
{
  protected function setUp(): void
  {
    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
    }
  }

  protected function tearDown(): void
  {
    session_destroy();
    if (function_exists('header_remove')) {
      header_remove();
    }
  }

  public function testHandleRequestAuthorized(): void
  {
    $_SESSION['authLevel'] = 1;
    $router = new Router([MockController::class]);

    ob_start();
    $router->handleRequest('GET', '/auth1');
    $output = ob_get_clean();

    $this->assertEquals('test', $output);
    $this->assertEquals(200, http_response_code());
  }

  public function testHandleRequestUnauthorized(): void
  {
    $_SESSION['authLevel'] = 0;
    $GLOBALS['headers'] = [];

    $router = new Router([MockController::class]);
    $router->handleRequest('GET', '/auth1');

    $headers = $GLOBALS['headers'];
    $this->assertContains('Location: ./error?code=401', $headers);
  }
}
