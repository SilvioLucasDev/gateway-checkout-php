<?php

namespace App\Factories;

use App\Http\Controllers\PaymentController;

class PaymentControllerFactory
{
  public static function create(): PaymentController
  {
    $checkoutService = CheckoutServiceFactory::create();
    $asaasWebHookService = AsaasWebHookServiceFactory::create();
    return new PaymentController($checkoutService, $asaasWebHookService);
  }
}
