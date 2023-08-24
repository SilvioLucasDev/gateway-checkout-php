<?php

namespace App\http\controllers;

use App\http\config\Request;
use App\http\validations\RequiredNumberValidation;
use App\http\validations\RequiredValidation;
use App\infra\repositories\sqlite\RecordRepository;
use App\models\Record;

class RecordController
{
  public static function index(Request $request): array
  {
    $queryParams = $request->getQueryParams();
    $repository = new RecordRepository();
    return $repository->get($queryParams);
  }

  public static function show(int|string $id): array|string
  {
    RequiredNumberValidation::validate(['id' => $id], ['id']);
    $repository = new RecordRepository();
    return $repository->findById($id);
  }

  public static function store(Request $request): string
  {
    $repository = new RecordRepository();
    $lastId = $repository->getLastInsertedId();
    $data = $request->getPostVars();
    RequiredValidation::validate($data, ['type', 'message', 'is_identified']);
    $record = Record::create(
      $lastId['id'],
      $data['type'],
      $data['message'],
      $data['is_identified'],
      $data['whistleblower_name'] ?? null,
      $data['whistleblower_birth'] ?? null
    );
    return $repository->save($record);
  }

  public static function destroy(int $id): string
  {
    $repository = new RecordRepository();
    return $repository->delete($id);
  }

  public static function update(int $id, Request $request): string
  {
    $data = $request->getPostVars();
    RequiredValidation::validate($data, ['type', 'message', 'is_identified', 'deleted']);
    $record = Record::update(
      $id,
      $data['type'],
      $data['message'],
      $data['is_identified'],
      $data['whistleblower_name'] ?? null,
      $data['whistleblower_birth'] ?? null,
      $data['deleted']
    );

    $repository = new RecordRepository();
    return $repository->update($record);
  }
}
