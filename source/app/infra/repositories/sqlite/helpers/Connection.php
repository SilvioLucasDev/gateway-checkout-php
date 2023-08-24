<?php

namespace App\infra\repositories\sqlite\helpers;

use Exception;
use PDO;
use PDOException;

class Connection
{
  private string $dsn = DSN;
  private string $username = USERNAME;
  private string $password = PASSWORD;
  private static ?PDO $instance = null;

  private function __construct()
  {
    try {
      self::$instance = new PDO(
        $this->dsn,
        $this->username,
        $this->password,
        [
          \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ]
      );
    } catch (PDOException $e) {
      throw new Exception('Erro na conexão com o banco de dados: ' . $e->getMessage());
    }
  }

  public static function getInstance(): PDO
  {
    if (self::$instance === null) {
      new Connection();
    }
    return self::$instance;
  }
}
