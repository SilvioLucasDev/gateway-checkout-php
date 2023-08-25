<?php

namespace App\Http\Controllers;

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
    $body = $request->getPostVars();
    FieldValidation::isBoolean($body, ['is_identified']);
    FieldValidation::isRequired($body, ['type', 'message', 'is_identified']);
    $lastId = $this->repository->getLastInsertedId();
    $record = Record::create(
      $lastId,
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
    $body = $request->getPostVars();
    $method = $request->getHttpMethod();
    if ($method === 'PUT') FieldValidation::isRequired($body, ['type', 'message', 'is_identified']);
    FieldValidation::isBoolean($body, ['is_identified']);
    FieldValidation::isNumber(['id' => $id], ['id']);
    $record = $this->repository->findById($id);
    if (!$record) throw new RecordNotFoundException();
    $record = Record::update(
      $id,
      $body['type'] ?? $record['type'],
      $body['message'] ?? $record['message'],
      $body['is_identified'] ?? $record['is_identified'],
      $body['whistleblower_name'] ?? $record['whistleblower_name'],
      $body['whistleblower_birth'] ?? $record['whistleblower_birth'],
    );
    return $this->repository->update($record);
  }
}
