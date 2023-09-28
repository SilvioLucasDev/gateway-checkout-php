<?php

namespace App\Factories;

use App\Http\Controllers\PaymentController;

class PaymentControllerFactory
{
  public static function create(): PaymentController
  {
    $checkoutService = CheckoutServiceFactory::create();
    return new PaymentController($checkoutService);
  }
}
