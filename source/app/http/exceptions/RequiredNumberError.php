<?php

namespace App\http\exceptions;

use Exception;

class RequiredNumberError extends Exception
{
  protected $code = 400;
  protected $message = 'Field must be a number';

  public function __construct(string $fieldName) {
    if($fieldName) {
      $this->message = "The $fieldName field must be a number";
    }
  }
}
