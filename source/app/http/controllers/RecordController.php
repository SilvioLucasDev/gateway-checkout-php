<?php

namespace App\Http\controllers;

use App\Http\Config\Request;
use App\Http\Exceptions\RecordNotFoundException;
use App\Http\Validations\FieldValidation;
use App\Infra\Repositories\Interfaces\RecordRepositoryInterface;
use App\Domain\Models\Record;

class RecordController
{
  public function __construct(private readonly RecordRepositoryInterface $repository)
  {
  }

  public function index(Request $request): array
  {
    $queryParams = $request->getQueryParams();
    return $this->repository->get($queryParams);
  }

  public function show(int|string $id): array|string
  {
    FieldValidation::isNumber(['id' => $id], ['id']);
    $record = $this->repository->findById($id);
    return $record ? $record : 'Record not found!';
  }

  public function store(Request $request): string
  {
    $lastId = $this->repository->getLastInsertedId();
    $body = $request->getPostVars();
    FieldValidation::isBool($body, ['is_identified']);
    FieldValidation::isRequired($body, ['type', 'message', 'is_identified']);
    $record = Record::create(
      $lastId['id'],
      $body['type'],
      $body['message'],
      $body['is_identified'],
      $body['whistleblower_name'] ?? null,
      $body['whistleblower_birth'] ?? null
    );
    return $this->repository->save($record);
  }

  public function destroy(int|string $id): string
  {
    FieldValidation::isNumber(['id' => $id], ['id']);
    $record = $this->repository->findById($id);
    if (!$record) throw new RecordNotFoundException();
    return $this->repository->delete($id);
  }

  public function update(int|string $id, Request $request): string
  {
    FieldValidation::isNumber(['id' => $id], ['id']);
    $record = $this->repository->findById($id);
    if (!$record) throw new RecordNotFoundException();
    $body = $request->getPostVars();
    $method = $request->getHttpMethod();
    FieldValidation::isBool($body, ['is_identified']);
    if ($method === 'PUT') FieldValidation::isRequired($body, ['type', 'message', 'is_identified']);
    $record = Record::update(
      $id,
      $body['type'] ?? null,
      $body['message'] ?? null,
      $body['is_identified'] ?? null,
      $body['whistleblower_name'] ?? null,
      $body['whistleblower_birth'] ?? null,
    );
    return $this->repository->update($record);
  }
}
