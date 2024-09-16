<?php

namespace src\Controllers;

use src\Router\Attributes\Route;

final class AuthController
{

  #[Route('POST', '/login')]
  public function login(): void
  {
    $mail = $_POST['mail'];
    $password = $_POST['password'];
  }
}