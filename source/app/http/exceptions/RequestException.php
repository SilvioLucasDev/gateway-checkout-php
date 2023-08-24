<?php

namespace App\http\exceptions;

use Exception;

class RequestException extends Exception
{
  protected $code = 500;
  protected $message = 'Error in request';

  public function __construct(string $message, int $code = null) {
    if($message) {
      $this->message = 'Error in request: ' . $message;
    }

    if($code) {
      $this->code = $code;
    }
  }
}
