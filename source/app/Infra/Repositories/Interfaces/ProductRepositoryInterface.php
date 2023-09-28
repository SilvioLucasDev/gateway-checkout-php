<?php

namespace App\Infra\Repositories\Interfaces;

interface ProductRepositoryInterface
{
  public function findById(int $id): array|string;
}
