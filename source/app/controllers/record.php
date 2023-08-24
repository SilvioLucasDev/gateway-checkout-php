<?php
require_once './app/http/request.php';
require_once './app/repository/record.php';

class RecordController
{

  public static function index(Request $request)
  {
    $queryParams = $request->getQueryParams();
    $repository = new RecordRepository();
    return $repository->getAll($queryParams);
  }

  public static function show($id)
  {
    $repository = new RecordRepository();
    return $repository->get($id);
  }
}
