<?php

namespace src\Repositories;

use PDO;
use src\Database\Database;

final class CategoryRepository
{
  private PDO $pdo;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getDb();
  }

  public function getAll(): array
  {
    $query = 'SELECT * FROM Bot_Feature_Categories';
    $statement = $this->pdo->prepare($query);
    $statement->execute();
    $featureCategories = $statement->fetchAll(PDO::FETCH_CLASS, 'src\Models\BotFeatureCategory');
    return $featureCategories;
  }
}
