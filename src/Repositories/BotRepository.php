<?php

namespace src\Repositories;

use PDO;
use src\Database\Database;
use src\Models\Bot;

final class BotRepository
{
  private PDO $pdo;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getDb();
  }

  public function insert(Bot $botProfile): Bot
  {
    $query = 'INSERT INTO Bots (name, creation_date, cooldown_time, max_openai_message_length, id_model, id_platform, id_user) 
              VALUES (:name, :creationDate, :cooldownTime, :maxOpenaiMessageLength, :idModel, :idPlatform, :idUser)';
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      ':name' => $botProfile->getName(),
      ':creationDate' => $botProfile->getCreationDate(),
      ':cooldownTime' => $botProfile->getCooldownTime(),
      ':maxOpenaiMessageLength' => $botProfile->getMaxOpenaiMessageLength(),
      ':idModel' => $botProfile->getIdModel(),
      ':idPlatform' => $botProfile->getIdPlatform(),
      ':idUser' => $botProfile->getIdUser()
    ]);
    $botProfile->setIdBot($this->pdo->lastInsertId());
    return $botProfile;
  }

  public function getByNameAndUserId(string $name, int $userId): Bot|false
  {
    $query = 'SELECT * FROM Bots WHERE name = :name AND id_user = :userId';
    $statement = $this->pdo->prepare($query);
    $statement->execute([':name' => $name, ':userId' => $userId]);
    $botProfile = $statement->fetchObject(Bot::class);
    return $botProfile;
  }

  public function getByName(string $name): Bot|false
  {
    $query = 'SELECT * FROM Bots WHERE name = :name';
    $statement = $this->pdo->prepare($query);
    $statement->execute([':name' => $name]);
    $botProfile = $statement->fetchObject(Bot::class);
    return $botProfile;
  }

  public function getById(int $id): Bot|false
  {
    $query = 'SELECT * FROM Bots WHERE id_bot = :id';
    $statement = $this->pdo->prepare($query);
    $statement->execute([':id' => $id]);
    $botProfile = $statement->fetchObject(Bot::class);
    return $botProfile;
  }

  public function getByUser(int $userId): array
  {
    $query = 'SELECT * FROM Bots WHERE id_user = :userId';
    $statement = $this->pdo->prepare($query);
    $statement->execute([':userId' => $userId]);
    $botProfiles = $statement->fetchAll(PDO::FETCH_CLASS, Bot::class);
    return $botProfiles;
  }
}
