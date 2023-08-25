<?php

namespace App\Http\Validations;

use App\Http\Exceptions\ValidationException;

class RequiredNumberValidation extends RequiredValidation
{
  public static function validate(array $data, array $requiredFields): void
  {
    parent::validate($data, $requiredFields);
    foreach ($requiredFields as $field) {
      if (!is_numeric($data[$field])) throw new ValidationException("The $field field must be a number!");
    }
  }
}
