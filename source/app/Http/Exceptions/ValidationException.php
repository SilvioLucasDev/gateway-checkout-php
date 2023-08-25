<?php

namespace App\Http\Exceptions;

use Exception;

class ValidationException extends Exception
{
  protected $code = 400;
  protected $message = 'Validation error: Invalid field(s)!';

  public function __construct(string $message)
  {
    if ($message) $this->message = 'Validation error: ' . $message;
  }
}
