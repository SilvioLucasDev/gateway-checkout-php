<?php

namespace App\Infra\Repositories\SQLite\Helpers;

use App\Infra\Exceptions\ConnectionException;
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
      throw new ConnectionException($e->getMessage());
    }
  }

  public static function getInstance(): PDO
  {
    if (self::$instance === null) new Connection();
    return self::$instance;
  }
}
