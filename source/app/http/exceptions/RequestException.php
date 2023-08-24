<?php

namespace App\http\exceptions;

use Exception;

class RequestException extends Exception
{
  protected $code = 500;
  protected $message = 'Error in request';

  public function __construct(string $message) {
    if($message) {
      $this->message = 'Error in request: ' . $message;
    }
  }
}
