<?php

namespace src\Services;

use src\Models\User;
use src\Repositories\UserRepository;

final class Authenticator
{
  public static function authenticate(string $mail, string $password): bool|User
  {
    $userRepository = new UserRepository();
    $user = $userRepository->getUserByMail($mail);
    
    if (!$user) {
      return false;
    }

    if (!password_verify($password, $user->getPasswordHash())) {
      return false;
    }

    return $user;
  }
}
