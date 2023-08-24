<?php

class RecordRepository
{

  public function get(array $params)
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
}
