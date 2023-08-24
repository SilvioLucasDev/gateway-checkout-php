<?php

namespace App\factories;

use App\http\controllers\RecordController;
use App\infra\repositories\sqlite\RecordRepository;

class RecordControllerFactory
{
  public static function create(): RecordController
  {
    $repository = new RecordRepository();
    return new RecordController($repository);
  }
}
