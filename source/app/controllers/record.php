<?php
  require_once './app/http/request.php';
  class RecordController {

    public static function index(Request $request) {
      $queryParams = $request->getQueryParams();
      $deleted = isset($queryParams['deleted']) && $queryParams['deleted'] !== '' ? $queryParams['deleted'] : '';
      $type = isset($queryParams['type']) && $queryParams['type'] !== '' ? $queryParams['type'] : '';

      if($deleted !== '') { $conditions[] = 'deleted = :deleted'; }
      if($type !== '') { $conditions[] = 'type = :type'; }

      $sql = 'SELECT * FROM registros';
      if (!empty($conditions)) { $sql .= ' WHERE ' . implode(' AND ', $conditions); }

      $db = Database::connect();
      $stmt = $db->prepare($sql);

      if($deleted !== '') { $stmt->bindParam(':deleted', $deleted); }
      if($type !== '') { $stmt->bindParam(':type', $type); }

      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }
