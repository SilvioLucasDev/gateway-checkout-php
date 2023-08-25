<?php

namespace App\Http\Exceptions;

use Exception;

class RecordNotFoundException extends Exception
{
  protected $code = 400;
  protected $message = 'Record not found!';
}
