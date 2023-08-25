<?php

namespace App\Infra\Exceptions;

use Exception;

class RecordNotFoundException extends Exception
{
  protected $code = 200;
  protected $message = 'Record not found!';
}
