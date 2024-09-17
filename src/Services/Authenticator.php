<?php

namespace src\Services;

use src\Models\User;
use src\Repositories\UserRepository;

use function PHPSTORM_META\type;

final class Authenticator
{
  public static function register(array $inputs): void
  {
    $userRepository = new UserRepository();
    $user = new User($inputs['mail'], $inputs['username'], $inputs['password'], 'user');
    $userRepository->insertUser($user);
  }

  public static function authenticate(string $mail, string $password): User|false
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
    $_SESSION['authLevel'] = $user->getAuthLevelFromRole();

    return $user;
  }
}
