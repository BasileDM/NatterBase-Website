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
      echo '<pre>';
      print_r($bot);
      echo '</pre>';
      exit;

      foreach ($features as $feature) {
        $this->updateOrCreateFeature($feature);
        $this->updateOrCreateRelation($botId, $feature);
      }

      return true;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  private function updateOrCreateFeature(BotFeature $feature): void
  {
    $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM Bot_Features WHERE id_bot_feature = :idBotFeature');
    $stmt->execute(['idBotFeature' => $feature->getIdBotFeature()]);
    $exists = $stmt->fetchColumn() > 0;

    if ($exists) {
      $stmt = $this->pdo->prepare('UPDATE Bot_Features SET name = :name, is_admin = :isAdmin, is_subscriber = :isSubscriber, id_bot_feature_category = :idBotFeatureCategory
            WHERE id_bot_feature = :idBotFeature');
      $stmt->execute([
        'idBotFeature' => $feature->getIdBotFeature(),
        'name' => $feature->getName(),
        'isAdmin' => $feature->isIsAdmin(),
        'isSubscriber' => $feature->isIsSubscriber(),
        'idBotFeatureCategory' => $feature->getIdBotFeatureCategory(),
      ]);
    } else {
      $stmt = $this->pdo->prepare('INSERT INTO Bot_Features (id_bot_feature, name, is_admin, is_subscriber, id_bot_feature_category)
            VALUES (:idBotFeature, :name, :isAdmin, :isSubscriber, :idBotFeatureCategory)');
      $stmt->execute([
        'idBotFeature' => $feature->getIdBotFeature(),
        'name' => $feature->getName(),
        'isAdmin' => $feature->isIsAdmin(),
        'isSubscriber' => $feature->isIsSubscriber(),
        'idBotFeatureCategory' => $feature->getIdBotFeatureCategory(),
      ]);
    }
  }

  private function updateOrCreateRelation(int $botId, BotFeature $feature): void
  {
    // Check if the relation exists
    $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM Relation_Bots_Features WHERE id_bot = :idBot AND id_bot_feature = :idBotFeature');
    $stmt->execute([
      'idBot' => $botId,
      'idBotFeature' => $feature->getIdBotFeature(),
    ]);
    $exists = $stmt->fetchColumn() > 0;

    if ($exists) {
      // Update the existing relation
      $stmt = $this->pdo->prepare('UPDATE Relation_Bots_Features SET
            is_admin_override = :isAdminOverride,
            is_subscriber_override = :isSubscriberOverride,
            trigger = :trigger,
            dice_sides_number = :diceSidesNumber
            WHERE id_bot = :idBot AND id_bot_feature = :idBotFeature');

      $stmt->execute([
        'isAdminOverride' => $feature->getIsAdminOverride(),
        'isSubscriberOverride' => $feature->getIsSubscriberOverride(),
        'trigger' => $feature->getTrigger(),
        'diceSidesNumber' => $feature->getDiceSidesNumber(),
        'idBot' => $botId,
        'idBotFeature' => $feature->getIdBotFeature(),
      ]);
    } else {
      // Insert a new relation
      $stmt = $this->pdo->prepare('INSERT INTO Relation_Bots_Features (id_bot, id_bot_feature, is_admin_override, is_subscriber_override, trigger, dice_sides_number)
            VALUES (:idBot, :idBotFeature, :isAdminOverride, :isSubscriberOverride, :trigger, :diceSidesNumber)');

      $stmt->execute([
        'idBot' => $botId,
        'idBotFeature' => $feature->getIdBotFeature(),
        'isAdminOverride' => $feature->getIsAdminOverride(),
        'isSubscriberOverride' => $feature->getIsSubscriberOverride(),
        'trigger' => $feature->getTrigger(),
        'diceSidesNumber' => $feature->getDiceSidesNumber(),
      ]);
    }
  }
}
