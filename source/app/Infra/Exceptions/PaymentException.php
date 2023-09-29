<?php

namespace App\Infra\Exceptions;

use Exception;

class PaymentException extends Exception
{
  protected $code = 500;
  protected $message = 'Payment error!';
}
