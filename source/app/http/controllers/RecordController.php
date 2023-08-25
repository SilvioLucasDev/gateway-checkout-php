<?php

namespace App\Http\controllers;

use App\Http\Config\Request;
use App\Http\Validations\RequiredNumberValidation;
use App\Http\Validations\RequiredValidation;
use App\Infra\Repositories\Interfaces\RecordRepositoryInterface;
use App\Models\Record;

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
    RequiredNumberValidation::validate(['id' => $id], ['id']);
    return $this->repository->findById($id);
  }

  public function store(Request $request): string
  {
    $lastId = $this->repository->getLastInsertedId();
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
    return $this->repository->save($record);
  }

  public function destroy(int $id): string
  {
    return $this->repository->delete($id);
  }

  public function update(int $id, Request $request): string
  {
    $data = $request->getPostVars();
    $method = $request->getHttpMethod();
    if ($method === 'PUT') {
      RequiredValidation::validate($data, ['type', 'message', 'is_identified', 'deleted']);
    }
    $record = Record::update(
      $id,
      $data['type'] ?? null,
      $data['message'] ?? null,
      $data['is_identified'] ?? null,
      $data['whistleblower_name'] ?? null,
      $data['whistleblower_birth'] ?? null,
      $data['deleted'] ?? null
    );
    return $this->repository->update($record);
  }
}
