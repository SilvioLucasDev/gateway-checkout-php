<?php

namespace App\Http\Exceptions;

use Exception;

class RequestException extends Exception
{
  protected $code = 500;
  protected $message = 'Request error!';

  public function __construct(string $message, int $code = null)
  {
    if ($message) $this->message = 'Request error: ' . $message;
    if ($code) $this->code = $code;
  }
}
