<?php

namespace App\Infra\Repositories\Interfaces;
use App\Domain\Models\Transaction;

interface TransactionRepositoryInterface
{
  public function findById(int $id): array|string;
  public function save(Transaction $transaction): string;
  public function update(Transaction $transaction): string;
}
