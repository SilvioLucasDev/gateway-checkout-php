<?php

namespace App\http\controllers;

use App\http\config\Request;
use App\infra\repositories\sqlite\RecordRepository;
use App\models\Record;
use Exception;

class RecordController
{

  public static function index(Request $request): array
  {
    $queryParams = $request->getQueryParams();
    $repository = new RecordRepository();
    return $repository->get($queryParams);
  }

  public static function show(int $id): array
  {
    $repository = new RecordRepository();
    return $repository->findById($id);
  }

  public static function store(Request $request): string
  {
    $repository = new RecordRepository();
    $lastId = $repository->getLastInsertedId();
    $data = $request->getPostVars();
    self::validate($data, ['type', 'message', 'is_identified']);
    $record = Record::create(
      $lastId['id'],
      $data['type'],
      $data['message'],
      $data['is_identified'],
      $data['whistleblower_name'] ?? null,
      $data['whistleblower_birth'] ?? null
    );
    $result =  $repository->save($record);
    if (!$result) {
      throw new Exception("Erro ao cadastrar registro", 500);
    }
    return "Registro cadastrado com sucesso!";
  }

  public static function destroy(int $id): string
  {
    $repository = new RecordRepository();
    $result =  $repository->delete($id);
    if (!$result) {
      throw new Exception("Erro ao deletar registro", 500);
    }
    return "Registro deletado com sucesso!";
  }

  public static function update(int $id, Request $request): string
  {
    $data = $request->getPostVars();

    self::validate($data, ['type', 'message', 'is_identified', 'whistleblower_name', 'whistleblower_birth', 'deleted']);
    $record = Record::update(
      $id,
      $data['type'],
      $data['message'],
      $data['is_identified'],
      $data['whistleblower_name'],
      $data['whistleblower_birth'],
      $data['deleted']
    );

    $repository = new RecordRepository();
    $result =  $repository->update($record);
    if (!$result) {
      throw new Exception("Erro ao atualizar o registro", 500);
    }
    return "Registro atualizado com sucesso!";
  }

  private static function validate(array $data, array $requiredFields): void
  {
    foreach ($requiredFields as $field) {
      if (!isset($data[$field])) {
        throw new Exception("Campo '$field' é obrigatório", 400);
      }
    }
  }
}
