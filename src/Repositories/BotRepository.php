<?php

namespace src\Repositories;

use Exception;
use PDO;
use src\Database\Database;
use src\Models\Bot;
use src\Models\BotFeature;

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
    try {
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
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function getByNameAndUserId(string $name, int $userId): Bot|false
  {
    try {
      $query = 'SELECT * FROM Bots WHERE name = :name AND id_user = :userId';
      $statement = $this->pdo->prepare($query);
      $statement->execute([':name' => $name, ':userId' => $userId]);
      $botProfile = $statement->fetchObject(Bot::class);
      return $botProfile;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function getByName(string $name): Bot|false
  {
    try {

      $query = 'SELECT Bots.*, Bot_Language_Models.name AS model_name, Bot_Platforms.name AS platform_name
                FROM Bots
                LEFT JOIN Bot_Language_models ON Bots.id_model = Bot_Language_Models.id_model
                LEFT JOIN Bot_Platforms ON Bots.id_platform = Bot_Platforms.id_platform
    WHERE name = :name';
      $statement = $this->pdo->prepare($query);
      $statement->execute([':name' => $name]);
      $botProfile = $statement->fetchObject(Bot::class);
      return $botProfile;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function getById(int $id): Bot|false
  {
    try {
      $query = 'SELECT Bots.*, Bot_Language_Models.name AS model_name, Bot_Platforms.name AS platform_name
                FROM Bots
                LEFT JOIN Bot_Language_models ON Bots.id_model = Bot_Language_Models.id_model
                LEFT JOIN Bot_Platforms ON Bots.id_platform = Bot_Platforms.id_platform
                WHERE id_bot = :id';
      $statement = $this->pdo->prepare($query);
      $statement->execute([':id' => $id]);
      $botProfile = $statement->fetchObject(Bot::class);
      return $botProfile;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function getByUserId(int $userId): array|false
  {
    try {
      $query = 'SELECT Bots.*, Bot_Language_Models.name AS model_name, Bot_Platforms.name AS platform_name
                FROM Bots
                LEFT JOIN Bot_Language_models ON Bots.id_model = Bot_Language_Models.id_model
                LEFT JOIN Bot_Platforms ON Bots.id_platform = Bot_Platforms.id_platform
                WHERE id_user = :userId';
      $statement = $this->pdo->prepare($query);
      $statement->execute([':userId' => $userId]);
      $botProfiles = $statement->fetchAll(PDO::FETCH_CLASS, Bot::class);
      return $botProfiles;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function update(Bot $botProfile): bool
  {
    try {
      $query = 'UPDATE Bots 
                SET name = :name, 
                    creation_date = :creationDate, 
                    cooldown_time = :cooldownTime, 
                    max_openai_message_length = :maxOpenaiMessageLength, 
                    id_model = :idModel, 
                    open_ai_pre_prompt = :openAiPrePrompt,
                    twitch_join_channel = :twitchJoinChannel,
                    id_platform = :idPlatform 
                WHERE id_bot = :idBot';

      $statement = $this->pdo->prepare($query);
      $statement->execute([
        ':name' => $botProfile->getName(),
        ':creationDate' => $botProfile->getCreationDate(),
        ':cooldownTime' => $botProfile->getCooldownTime(),
        ':maxOpenaiMessageLength' => $botProfile->getMaxOpenaiMessageLength(),
        ':idModel' => $botProfile->getIdModel(),
        ':openAiPrePrompt' => $botProfile->getOpenAiPrePrompt(),
        ':twitchJoinChannel' => $botProfile->getTwitchJoinChannel(),
        ':idPlatform' => $botProfile->getIdPlatform(),
        ':idBot' => $botProfile->getIdBot()
      ]);
      return $statement->rowCount() > 0;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function delete(int $botId, int $userId): bool
  {
    try {
      $query = 'DELETE FROM Bots WHERE id_bot = :idBot AND id_user = :idUser';
      $statement = $this->pdo->prepare($query);
      $statement->execute([':idBot' => $botId, ':idUser' => $userId]);
      return $statement->rowCount() > 0;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function updateBotFeatures(Bot $bot): bool
  {
    try {
      $botId = $bot->getIdBot();
      $features = $bot->getBotFeatures();

      foreach ($features as $feature) {
        $this->updateOrCreateFeature($feature);
      }

      return true;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  private function updateOrCreateFeature(BotFeature $feature): bool
  {
    echo '<pre>';
    print_r($feature);
    echo '</pre>';
    exit;
    $query = 'SELECT id_bot_feature FROM Relation_Bots_Features
              WHERE id_bot_feature = :idBotFeature
              AND id_bot = :idBot';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([
      'idBotFeature' => $feature->getIdBotFeature(),
      'idBot' => $feature->getIdBot(),
    ]);
    $exists = $stmt->fetchColumn() > 0;

    // If the relation exists, update it
    if ($exists) {
      $query = 'UPDATE Relation_Bots_Features
                SET id_bot = :idBot,
                    id_bot_feature = :idBotFeature,
                    is_admin_override = :isAdminOverride,
                    is_subscriber_override = :isSubscriberOverride 
                WHERE id_bot_feature = :idBotFeature
                AND id_bot = :idBot';
      $stmt = $this->pdo->prepare($query);

      // If admin or subscriber override exists, it is the value we want to use
      if ($feature->getIsAdminOverride() !== null || !empty($feature->getIsAdminOverride())) {
        $feature->setIsAdmin($feature->getIsAdminOverride());
      }
      
      if ($feature->getIsSubscriberOverride() !== null || !empty($feature->getIsSubscriberOverride())) {
        $feature->setIsSubscriber($feature->getIsSubscriberOverride());
      }

      $stmt->execute([
        'idBot' => $feature->getIdBot(),
        'idBotFeature' => $feature->getIdBotFeature(),
        'isAdminOverride' => $feature->isIsAdmin(),
        'isSubscriberOverride' => $feature->isIsSubscriber()
      ]);

    // If the relation doesn't exist, insert it
    } else {
      $query = 'INSERT INTO Relation_Bots_Features
                (id_bot, id_bot_feature, is_admin_override, is_subscriber_override)
                VALUES
                (:idBot, :idBotFeature, :isAdminOverride, :isSubscriberOverride)';
      $stmt = $this->pdo->prepare($query);
      $stmt->execute([
        'idBot' => $feature->getIdBot(),
        'idBotFeature' => $feature->getIdBotFeature(),
        'isAdminOverride' => $feature->isIsAdmin(),
        'isSubscriberOverride' => $feature->isIsSubscriber()
      ]);
    }
    return $stmt->rowCount() > 0;
  }
}
