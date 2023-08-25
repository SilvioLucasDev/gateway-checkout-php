<?php

namespace App\Http\Validations;

use App\Http\Exceptions\RequiredFieldError;

class RequiredValidation
{
  public static function validate(array $data, array $requiredFields): void
  {
    foreach ($requiredFields as $field) {
      if (!isset($data[$field])) {
        throw new RequiredFieldError($field);
      }
    }
  }
}
