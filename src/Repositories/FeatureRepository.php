<?php

namespace src\Repositories;

use PDO;
use src\Database\Database;
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
}
