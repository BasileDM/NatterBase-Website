<?php

namespace src\Repositories;

use PDO;
use src\Database\Database;
use src\Models\BotCommand;

final class CommandRepository
{
  private PDO $pdo;

  public function __construct()
  {
    $db = new Database();
    $this->pdo = $db->getDb();
  }

  public function getByBotId(int $botId): array
  {
    $query = 'SELECT * FROM Bot_Commands WHERE id_bot = :botId';
    $statement = $this->pdo->prepare($query);
    $statement->execute([':botId' => $botId]);
    return $statement->fetchAll(PDO::FETCH_CLASS, BotCommand::class);
  }
}
