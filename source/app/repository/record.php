<?php
require_once './app/models/record.php';

class RecordRepository
{

  public function getAll(array $params)
  {
    $conditions = [];
    $bindings = [];

    if (isset($params['deleted']) && $params['deleted'] !== '') {
      $conditions[] = 'deleted = :deleted';
      $bindings[':deleted'] = $params['deleted'];
    }

    if (isset($params['type']) && $params['type'] !== '') {
      $conditions[] = 'type = :type';
      $bindings[':type'] = $params['type'];
    }

    $sql = 'SELECT * FROM registros';
    if (!empty($conditions)) {
      $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }

    if (isset($params['order_by']) && $params['order_by'] !== '') {
      $sql .= ' ORDER BY ' . $params['order_by'];
    }

    if (isset($params['limit']) && is_numeric($params['limit'])) {
      $sql .= ' LIMIT ' . (int)$params['limit'];
      if (isset($params['offset']) && is_numeric($params['offset'])) {
        $sql .= ' OFFSET ' . (int)$params['offset'];
      }
    }

    $db = Database::connect();
    $stmt = $db->prepare($sql);

    foreach ($bindings as $param => &$value) {
      $stmt->bindParam($param, $value);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function get(int $id)
  {
    $sql = 'SELECT * FROM registros WHERE id = :id';

    $db = Database::connect();
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':id', $id);

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function save(Record $record)
  {
    $sql = 'INSERT INTO registros (id, type, message, is_identified, whistleblower_name, whistleblower_birth, created_at, deleted)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

    $db = Database::connect();
    $stmt = $db->prepare($sql);

    $stmt->bindValue(1, $record->id);
    $stmt->bindValue(2, $record->type);
    $stmt->bindValue(3, $record->message);
    $stmt->bindValue(4, $record->is_identified, PDO::PARAM_INT);
    $stmt->bindValue(5, $record->whistleblower_name);
    $stmt->bindValue(6, $record->whistleblower_birth);
    $stmt->bindValue(7, $record->created_at);
    $stmt->bindValue(8, $record->deleted, PDO::PARAM_INT);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function lastId()
  {
    $sql = 'SELECT max(id) as id FROM registros';

    $db = Database::connect();
    $stmt = $db->prepare($sql);

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
