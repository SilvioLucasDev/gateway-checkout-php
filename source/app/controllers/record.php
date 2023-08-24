<?php
require_once './app/http/request.php';
require_once './app/repository/record.php';
require_once './app/models/record.php';

class RecordController
{

  public static function index(Request $request)
  {
    $queryParams = $request->getQueryParams();
    $repository = new RecordRepository();
    return $repository->getAll($queryParams);
  }

  public static function show(int $id)
  {
    $repository = new RecordRepository();
    return $repository->get($id);
  }

  public static function store(Request $request)
  {
    $repository = new RecordRepository();
    $lastId = $repository->lastId();
    $data = $request->getPostVars();

    $record = Record::create(
      $lastId['id'],
      $data['type'],
      $data['message'],
      $data['is_identified'],
      $data['whistleblower_name'],
      $data['whistleblower_birth']
    );

    $result =  $repository->save($record);

    if(!$result) {
      throw new Exception("Erro ao cadastrar registro", 500);
    }
    return "Registro cadastrado com sucesso!";
  }

  public static function destroy(int $id)
  {
    $repository = new RecordRepository();
    $result =  $repository->delete($id);

    if(!$result) {
      throw new Exception("Erro ao deletar registro", 500);
    }
    return "Registro deletado com sucesso!";
  }
}
