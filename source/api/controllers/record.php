<?php
  require_once './api/http/request.php';
 class RecordController {

  public static function index(Request $request) {

    // echo '<pre>';
    // print_r($request->getQueryParams());
    // echo '</pre>';
    // exit;

    $db = Database::connect();
    $stmt = $db->prepare('SELECT * FROM registros');
    $stmt->execute();
    $obj = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $obj;
  }

}?>
