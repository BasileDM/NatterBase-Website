<?php

namespace src\Database;

use PDO;
use PDOException;
use RuntimeException;

final class Database
{
  private PDO $db;
  private string $config;

  public function __construct()
  {
    $this->config = __DIR__ . '/../../config.local.php';
    require_once $this->config;
    $this->db = $this->connect();
  }

  public function getDb(): PDO {
    return $this->db;
  }

  private function connect(): PDO|string
  {
    try {
      $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
      return new PDO($dsn, DB_USER, DB_PWD);
    } catch (PDOException $e) {
      echo "Connexion to DB failed: " . $e->getMessage();
      exit;
    }
  }

  public function init(): bool
  {
    if (!AUTO_MIGRATION) {
      return false;
    }
    if ($this->doesUsersTableExists()) {
      return false;
    } else {
      try {
        $sql = file_get_contents(__DIR__ . "/Migrations/create_tables.SQL");
        $this->db->query($sql);
        return true;
      } catch (PDOException $error) {
        throw new RuntimeException("Database initialization failed: " . $error->getMessage());
      }
    }
  }

  public function doesUsersTableExists(): bool
  {
    $sql = "SHOW TABLES FROM " . DB_NAME . " LIKE 'Users';";
    $result = $this->db->query($sql)->fetch();
    return $result !== false;
  }
}
