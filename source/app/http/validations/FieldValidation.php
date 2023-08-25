<?php

namespace App\Http\Validations;

use App\Http\Exceptions\ValidationException;

class FieldValidation
{

  public static function isRequired(array $data, array $requiredFields): void
  {
    foreach ($requiredFields as $field) {
      if (!isset($data[$field])) throw new ValidationException("The field $field is required!");
    }
  }

  public static function isNumber(array $data, array $requiredFields): void
  {
    foreach ($requiredFields as $field) {
      if (isset($data[$field])) {
        if (!is_numeric($data[$field])) throw new ValidationException("The $field field must be a number!");
      }
    }
  }

  public static function isString(array $data, array $requiredFields): void
  {
    foreach ($requiredFields as $field) {
      if (isset($data[$field])) {
        if (!is_string($data[$field])) throw new ValidationException("The $field field must be a string!");
      }
    }
  }

  public static function isBoolean(array $data, array $requiredFields): void
  {
    foreach ($requiredFields as $field) {
      if (isset($data[$field])) {
        if (!is_bool($data[$field]) && $data[$field] !== 0 && $data[$field] !== 1 && $data[$field] !== '0' && $data[$field] !== '1') throw new ValidationException("The $field field must be a boolean!");
      }
    }
  }
}
