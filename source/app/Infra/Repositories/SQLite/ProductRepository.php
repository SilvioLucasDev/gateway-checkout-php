<?php

namespace App\Infra\Repositories\SQLite;

use App\Infra\Repositories\Interfaces\ProductRepositoryInterface;
use App\Infra\Repositories\SQLite\Helpers\Connection;
use PDO;

class ProductRepository implements ProductRepositoryInterface
{
  private PDO    $db;

  public function __construct()
  {
    $this->db = Connection::getInstance();
  }

  public function findById(int $id): array|string
  {
    $sql = 'SELECT * FROM products WHERE id = :id';
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
