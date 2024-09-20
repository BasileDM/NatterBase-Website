<?php

namespace src\Services;

use src\Models\User;
use src\Repositories\UserRepository;

final class UserService 
{
  private UserRepository $userRepository;

  public function __construct()
  {
    $this->userRepository = new UserRepository();
  }

  public function create(array $inputs): User|false
  {
    $user = new User();
    $user->hydrateFromInputs($inputs);
    $existingUser = $this->userRepository->getUserByMail($user->getMail());

    if ($existingUser)
      return false;
    else {
      $user->setIsActivated(false);
      $user->setGdpr(gmdate('Y-m-d H:i:s'));
      $user->setRoleName('user');
      return $this->userRepository->insert($user);
    }
  }
}
