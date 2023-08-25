<?php

namespace App\Factories;

use App\Http\Controllers\RecordController;
use App\Infra\Repositories\SQLite\RecordRepository;

class RecordControllerFactory
{
  public static function create(): RecordController
  {
    $repository = new RecordRepository();
    return new RecordController($repository);
  }
}
