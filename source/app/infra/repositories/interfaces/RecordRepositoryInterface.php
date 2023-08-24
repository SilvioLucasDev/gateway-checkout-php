<?php

namespace App\infra\repositories\interfaces;

use App\models\Record;

interface RecordRepositoryInterface
{
  public function get(array $params): array;
  public function findById(int $id): array|string;
  public function save(Record $record): string;
  public function delete(int $id): string;
  public function update(Record $record): string;
  public function getLastInsertedId(): array;
}
