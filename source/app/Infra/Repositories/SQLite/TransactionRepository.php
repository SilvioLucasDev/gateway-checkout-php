<?php

namespace App\Infra\Repositories\SQLite;

use App\Infra\Exceptions\OperationException;
use App\Infra\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Infra\Repositories\SQLite\Helpers\Connection;
use App\Domain\Models\Transaction;
use DateTime;
use PDO;

class TransactionRepository implements TransactionRepositoryInterface
{
  private PDO    $db;
  private ?array $bindings;
  private ?array $clauses;
  private ?array $columns;
  private ?array $values;

  public function __construct()
  {
    $this->db = Connection::getInstance();
  }

  //TALVEZ N VAI USAR ISSO AQUI
  //TALVEZ SÓ IREI GRAVAR NA BASE QUANDO O PAGAMENTO FOR CONCLUÍDO AIN VOU PRECISA DO UPDATE TBM
  public function findById(int $id): array|string
  {
    $sql = 'SELECT * FROM transactions WHERE id = :id';
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function save(Transaction $transaction): string
  {
    foreach ($transaction as $param => $value) {
      if (isset($value)) {
        if ($value instanceof DateTime) {
          $this->bindings[":$param"] = $value->format('Y-m-d H:i:s');
        } else {
          $this->bindings[":$param"] = $value;
        }
        $this->columns[] = $param;
        $this->values[] = ":$param";
      }
    }
    $sql = 'INSERT INTO transactions (' . implode(', ', $this->columns) . ') VALUES (' . implode(', ', $this->values) . ')';
    $stmt = $this->db->prepare($sql);
    foreach ($this->bindings as $param => &$value) {
      $stmt->bindValue($param, $value);
    }
    if (!$stmt->execute()) throw new OperationException('Transaction creation!');
    return 'Transaction successfully created!';
  }

  public function update(Transaction $transaction): string
  {
    foreach ($transaction as $param => $value) {
      if (isset($value)) {
        $this->bindings[":$param"] = $value;
        $this->clauses[] = "$param = :$param";
      }
    }
    $sql = 'UPDATE transactions SET ';
    $sql .= implode(', ', $this->clauses) . ' WHERE id = :id';
    $stmt = $this->db->prepare($sql);
    foreach ($this->bindings as $param => &$value) {
      $stmt->bindValue($param, $value);
    }
    if (!$stmt->execute()) throw new OperationException('Transaction update!');
    return 'Transaction successfully updated!';
  }
}
