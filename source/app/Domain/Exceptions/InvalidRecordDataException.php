<?php

namespace App\Domain\Exceptions;

use Exception;

class InvalidRecordDataException extends Exception
{
  protected $code = 400;
  protected $message = 'Invalid record data!';

  public function __construct(string $message, int $code = null)
  {
    if ($message) $this->message = $message;
    if ($code) $this->code = $code;
  }
}
