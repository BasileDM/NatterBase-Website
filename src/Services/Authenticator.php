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

    $_SESSION['isAuth'] = true;
    $_SESSION['userId'] = $user->getIdUser();
    $_SESSION['username'] = $user->getUsername();
    $_SESSION['mail'] = $user->getMail();
    $_SESSION['authLevel'] = self::getAuthLevelFromRole($user->getRoleName());

    return $user;
  }

  private static function getAuthLevelFromRole(string $roleName): int
  {
    switch ($roleName) {
      case 'admin':
        return 2;
      case 'user':
        return 1;
      default:
        return 0;
    }
  }
}
