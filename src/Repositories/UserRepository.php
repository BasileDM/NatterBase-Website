<?php

namespace src\Repositories;

use PDO;
use src\Models\User;

final class UserRepository
{
  private PDO $pdo;

  public function getUserById(int $id): User
  {
    $query = 'SELECT * FROM Users
              LEFT JOIN User_Roles ON Users.id_role = User_Roles.id_role
              WHERE id_user = :id';
    $statement = $this->pdo->prepare($query);
    $statement->execute([':id' => $id]);
    $user = $statement->fetchObject(User::class);
    return $user;
  }
}
