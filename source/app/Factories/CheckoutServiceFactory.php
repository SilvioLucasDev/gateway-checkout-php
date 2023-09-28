<?php

namespace App\Factories;

use App\Http\Services\CheckoutService;
use App\Infra\Adapters\AsaasGateway;
use App\Infra\Repositories\SQLite\ProductRepository;

class CheckoutServiceFactory
{
  public static function create(): CheckoutService
  {
    $productRepository = new ProductRepository();
    $paymentGateway = new AsaasGateway();
    return new CheckoutService($productRepository, $paymentGateway);
  }
}
