<?php

namespace App\Http\Validations;

use App\Http\Exceptions\RequiredNumberError;

class RequiredNumberValidation extends RequiredValidation
{
  public static function validate(array $data, array $requiredFields): void
  {
    parent::validate($data, $requiredFields);
    foreach ($requiredFields as $field) {
      if (!is_numeric($data[$field])) {
        throw new RequiredNumberError($field);
      }
    }
  }
}
