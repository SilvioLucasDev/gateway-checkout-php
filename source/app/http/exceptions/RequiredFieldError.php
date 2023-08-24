<?php

namespace App\http\exceptions;

use Exception;

class RequiredFieldError extends Exception
{
  protected $code = 400;
  protected $message = 'Field required';

  public function __construct(string $fieldName) {
    if($fieldName) {
      $this->message = "The field $fieldName is required";
    }
  }
}
