<?php

namespace App\Http\Exceptions;

use Exception;

class ProductNotFoundException extends Exception
{
  protected $code = 400;
  protected $message = 'Product not found!';
}
