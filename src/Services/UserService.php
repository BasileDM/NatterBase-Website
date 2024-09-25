<?php

namespace src\Services;

use ArrayAccess;
use src\Models\User;
use src\Repositories\UserRepository;

final class UserService
{
  private UserRepository $userRepository;
  private BotService $botService;

  public function __construct()
  {
    $this->userRepository = new UserRepository();
    $this->botService = new BotService();
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

  private function getSafeArray(int $userId): array
  {
    $user = $this->userRepository->getUserById($userId);
    return $user->toSafeInfoArray();
  }

  public function getAllCurrentUserData(): array
  {
    $userId = $_SESSION['userId'];
    $userData = [
      "user" => $this->getSafeArray($userId),
      "botProfiles" => $this->botService->getUserBotsArray($userId),
    ];

    return $userData;
  }

  public function updateUserData(array $inputs): bool
  {
    $userId = $_SESSION['userId'];
    $user = $this->userRepository->getUserById($userId);
    $user->hydrateFromInputs($inputs);
    return $this->userRepository->update($user);
  }

  public function deleteUser(): bool
  {
    if (!isset($_SESSION['userId'])) {
      return false;
    }
    return $this->userRepository->delete($_SESSION['userId']);
  }
}
