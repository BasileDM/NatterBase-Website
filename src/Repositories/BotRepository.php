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
    // Check if there is already a feature with the same trigger for this bot
    $query = 'SELECT id_bot_feature FROM Relation_Bots_Features
              WHERE `trigger` = :trigger
              AND id_bot = :idBot';

    $stmt = $this->pdo->prepare($query);
    $stmt->execute([
      'trigger' => $feature->getTrigger(),
      'idBot' => $feature->getIdBot()
    ]);

    $existingFeatureId = $stmt->fetchColumn();

    // If there is an existing feature with the same trigger
    if ($existingFeatureId && $existingFeatureId != $feature->getIdBotFeature()) {
      return false;
    }

    // Now we can safely update or insert without duplicate issues
    $query = 'INSERT INTO Relation_Bots_Features (
                id_bot, id_bot_feature, is_admin_override, is_subscriber_override, `trigger`, max_openai_message_length, open_ai_pre_prompt, dice_sides_number
              ) VALUES (
                :idBot, :idBotFeature, :isAdminOverride, :isSubscriberOverride, :trigger, :maxOpenaiMessageLength, :openAiPrePrompt, :diceSidesNumber
              ) ON DUPLICATE KEY UPDATE
                is_admin_override = :isAdminOverride,
                is_subscriber_override = :isSubscriberOverride,
                max_openai_message_length = :maxOpenaiMessageLength,
                open_ai_pre_prompt = :openAiPrePrompt,
                dice_sides_number = :diceSidesNumber';

    $stmt = $this->pdo->prepare($query);
    $params = [
      'idBot' => $feature->getIdBot(),
      'idBotFeature' => $feature->getIdBotFeature(),
      'isAdminOverride' => $feature->isIsAdmin(),
      'isSubscriberOverride' => $feature->isIsSubscriber(),
      'trigger' => $feature->getTrigger(),
      'maxOpenaiMessageLength' => $feature->getMaxOpenaiMessageLength(),
      'openAiPrePrompt' => $feature->getOpenAiPrePrompt(),
      'diceSidesNumber' => $feature->getDiceSidesNumber()
    ];

    return $stmt->execute($params);
  }
}
