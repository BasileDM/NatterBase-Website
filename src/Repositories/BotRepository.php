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
    $query = 'SELECT Bots.*, Bot_Language_Models.name AS model_name, Bot_Platforms.name AS platform_name
              FROM Bots
              LEFT JOIN Bot_Language_models ON Bots.id_model = Bot_Language_Models.id_model
              LEFT JOIN Bot_Platforms ON Bots.id_platform = Bot_Platforms.id_platform
              WHERE name = :name';
    $statement = $this->pdo->prepare($query);
    $statement->execute([':name' => $name]);
    $botProfile = $statement->fetchObject(Bot::class);
    return $botProfile;
  }

  public function getById(int $id): Bot|false
  {
    $query = 'SELECT Bots.*, Bot_Language_Models.name AS model_name, Bot_Platforms.name AS platform_name
              FROM Bots
              LEFT JOIN Bot_Language_models ON Bots.id_model = Bot_Language_Models.id_model
              LEFT JOIN Bot_Platforms ON Bots.id_platform = Bot_Platforms.id_platform
              WHERE id_bot = :id';
    $statement = $this->pdo->prepare($query);
    $statement->execute([':id' => $id]);
    $botProfile = $statement->fetchObject(Bot::class);
    return $botProfile;
  }

  public function getByUserId(int $userId): array|false
  {
    $query = 'SELECT Bots.*, Bot_Language_Models.name AS model_name, Bot_Platforms.name AS platform_name
              FROM Bots
              LEFT JOIN Bot_Language_models ON Bots.id_model = Bot_Language_Models.id_model
              LEFT JOIN Bot_Platforms ON Bots.id_platform = Bot_Platforms.id_platform
              WHERE id_user = :userId';
    $statement = $this->pdo->prepare($query);
    $statement->execute([':userId' => $userId]);
    $botProfiles = $statement->fetchAll(PDO::FETCH_CLASS, Bot::class);
    return $botProfiles;
  }

  public function update(Bot $botProfile): bool
  {
    $query = 'UPDATE Bots 
              SET name = :name, creation_date = :creationDate, cooldown_time = :cooldownTime, max_openai_message_length = :maxOpenaiMessageLength, id_model = :idModel, id_platform = :idPlatform, id_user = :idUser
              WHERE id_bot = :idBot';
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      ':name' => $botProfile->getName(),
      ':creationDate' => $botProfile->getCreationDate(),
      ':cooldownTime' => $botProfile->getCooldownTime(),
      ':maxOpenaiMessageLength' => $botProfile->getMaxOpenaiMessageLength(),
      ':idModel' => $botProfile->getIdModel(),
      ':idPlatform' => $botProfile->getIdPlatform(),
      ':idUser' => $botProfile->getIdUser(),
      ':idBot' => $botProfile->getIdBot()
    ]);
    return $statement->rowCount() > 0;
  }
}
