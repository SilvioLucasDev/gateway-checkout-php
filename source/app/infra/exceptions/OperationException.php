<?php

namespace App\Infra\Exceptions;

use Exception;

class OperationException extends Exception
{
  protected $code = 500;
  protected $message = 'Database operation error!';

  public function __construct(string $message, int $code = null)
  {
    if ($message) {
      $this->message = 'Database operation: ' . $message;
    }
    if ($code) {
      $this->code = $code;
    }
  }
}
