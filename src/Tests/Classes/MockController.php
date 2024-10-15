<?php

namespace src\Tests\Classes;

use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;

class MockController
{
  #[Route('GET', '/test')]
  #[Authorization(1)]
  public function test(): void
  {
    echo 'test';
  }

  #[Route('GET', '/public')]
  public function public(): void
  {
    echo 'public';
  }
}