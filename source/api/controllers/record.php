<?php
 class RecordController {

  public static function index() {
    $db = Database::connect();
    $stmt = $db->prepare('SELECT * FROM registros');
    $stmt->execute();
    $obj = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $obj;
  }

}?>
