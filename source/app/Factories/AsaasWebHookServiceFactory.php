<?php

namespace App\Factories;

use App\Http\Services\AsaasWebHookService;
use App\Infra\Adapters\AsaasGateway;
use App\Infra\Repositories\SQLite\TransactionRepository;

class AsaasWebHookServiceFactory
{
  public static function create(): AsaasWebHookService
  {
    $transactionRepository = new TransactionRepository();
    $paymentGateway = new AsaasGateway();
    return new AsaasWebHookService($transactionRepository, $paymentGateway);
  }
}
