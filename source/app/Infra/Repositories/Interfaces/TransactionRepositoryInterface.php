<?php

namespace App\Infra\Repositories\Interfaces;

interface TransactionRepositoryInterface
{
  public function findById(int $id): array|string;
  public function save(array $array): string;
  public function update(array $transaction): string;
}
