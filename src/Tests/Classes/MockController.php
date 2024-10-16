<?php

namespace src\Tests\Classes;

use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\Response;
use src\Utils\ErrorUtils;

class MockController
{
  use Response;

  #[Route('GET', '/auth1')]
  #[Authorization(1)]
  public function test(): void
  {
    $this->jsonResponse(200, ['message' => 'Authorized']);
  }

  #[Route('GET', '/public')]
  public function public(): void
  {
    $this->jsonResponse(200, ['message' => 'public']);
  }

  #[Route('GET', '/error')]
  public function error(): void
  {
    [$code, $message] = ErrorUtils::getErrorCodeAndMessage();
    http_response_code($code);
    echo $message;
  }
}