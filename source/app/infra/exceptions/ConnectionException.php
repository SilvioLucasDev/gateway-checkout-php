<?php

namespace App\Infra\Exceptions;

use Exception;

class ConnectionException extends Exception
{
  protected $code = 500;
  protected $message = 'Database connection error!';

  public function __construct(string $message)
  {
    if ($message) $this->message = 'Database connection error: ' . $message;
  }
}
