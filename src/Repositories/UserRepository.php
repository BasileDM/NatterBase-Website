<?php

namespace src\Repositories;

use PDO;
use src\Database\Database;
use src\Models\User;

final class UserRepository
{
  private PDO $pdo;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getDb();
  }

  public function getUserById(int $id): User|false
  {
    $query = 'SELECT Users.*, User_Roles.name AS role_name
              FROM Users
              LEFT JOIN User_Roles ON Users.id_role = User_Roles.id_role
              WHERE id_user = :id';
    $statement = $this->pdo->prepare($query);
    $statement->execute([':id' => $id]);
    $user = $statement->fetchObject(User::class);
    return $user;
  }

  public function getUserByMail(string $mail): User|false
  {
    $query = 'SELECT Users.*, User_Roles.name AS role_name
              FROM Users
              LEFT JOIN User_Roles ON Users.id_role = User_Roles.id_role
              WHERE mail = :mail';
    $statement = $this->pdo->prepare($query);
    $statement->execute([':mail' => $mail]);
    $user = $statement->fetchObject(User::class);
    return $user;
  }

  public function insertUser(User $user): User
  {
    $user->setIsActivated(0);
    $user->setGdpr(date('Y-m-d H:i:s'));
    $user->setRoleName('user');
    $roleId = $this->getRoleIdFromName($user->getRoleName());

    $query = 'INSERT INTO Users (mail, username, password_hash, is_activated, gdpr, id_role)
              VALUES (:mail, :username, :passwordHash, :isActivated, :gdpr, :id_role)';
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      ':mail' => $user->getMail(),
      ':username' => $user->getUsername(),
      ':password' => $user->getPasswordHash(),
      ':isActivated' => $user->isIsActivated(),
      ':gdpr' => $user->getGdpr(),
      ':id_role' => $roleId
    ]);
    $user->setIdUser($this->pdo->lastInsertId());
    return $user;
  }

  public function getRoleIdFromName(string $roleName): int
  {
    $query = 'SELECT id_role FROM User_Roles WHERE name = :roleName';
    $statement = $this->pdo->prepare($query);
    $statement->execute([':roleName' => $roleName]);
    return $statement->fetch();
  }
}
