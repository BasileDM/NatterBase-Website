<?php

namespace src\Repositories;

use Exception;
use PDO;
use src\Database\Database;
use src\Models\Bot;
use src\Models\BotFeature;

final class FeatureRepository
{
  private PDO $pdo;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getDb();
  }

  public function getAll(): array
  {
    $query = 'SELECT Bot_Features.*, Bot_Feature_Categories.name AS categoryName 
              FROM Bot_Features
              LEFT JOIN Bot_Feature_Categories
              ON Bot_Features.id_bot_feature_category = Bot_Feature_Categories.id_bot_feature_category';
    $statement = $this->pdo->prepare($query);
    $statement->execute();
    $features = $statement->fetchAll(PDO::FETCH_CLASS, BotFeature::class);
    return $features;
  }

  public function getByBotId(int $botId): array
  {
    $query = 'SELECT * 
              FROM Relation_Bots_Features 
              LEFT JOIN Bot_Features 
              ON Relation_Bots_Features.id_bot_feature = Bot_Features.id_bot_feature 
              LEFT JOIN Bot_Feature_Categories
              ON Bot_Features.id_bot_feature_category = Bot_Feature_Categories.id_bot_feature_category
              WHERE id_bot = :botId';
    $statement = $this->pdo->prepare($query);
    $statement->execute([':botId' => $botId]);
    return $statement->fetchAll(PDO::FETCH_CLASS, BotFeature::class);
  }

  public function getFeatureById(int $id): BotFeature|false
  {
    $query = 'SELECT Bot_Features.*, Bot_Feature_Categories.name AS categoryName 
              FROM Bot_Features
              LEFT JOIN Bot_Feature_Categories
              ON Bot_Features.id_bot_feature_category = Bot_Feature_Categories.id_bot_feature_category
              WHERE Bot_Features.id_bot_feature = :id';
    $statement = $this->pdo->prepare($query);
    $statement->execute([':id' => $id]);
    $feature = $statement->fetchObject(BotFeature::class);
    return $feature;
  }

  public function delete(int $featureId, int $botId, string $trigger): bool
  {
    $query = 'DELETE FROM Relation_Bots_Features 
              WHERE id_bot_feature = :featureId 
              AND id_bot = :botId
              AND `trigger` = :trigger';
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      ':featureId' => $featureId, 
      ':botId' => $botId,
      ':trigger' => $trigger
    ]);
    return $statement->rowCount() > 0;
  }public function updateBotFeatures(Bot $bot): bool
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
    $query = 'INSERT INTO Relation_Bots_Features (
                id_bot, id_bot_feature, is_admin_override, is_subscriber_override, `trigger`, max_openai_message_length, open_ai_pre_prompt, dice_sides_number
              ) VALUES (
                :idBot, :idBotFeature, :isAdminOverride, :isSubscriberOverride, :trigger, :maxOpenaiMessageLength, :openAiPrePrompt, :diceSidesNumber
              ) ON DUPLICATE KEY UPDATE
                id_bot_feature = :idBotFeature,
                is_admin_override = :isAdminOverride,
                is_subscriber_override = :isSubscriberOverride,
                max_openai_message_length = :maxOpenaiMessageLength,
                open_ai_pre_prompt = :openAiPrePrompt,
                dice_sides_number = :diceSidesNumber;
              ';

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
