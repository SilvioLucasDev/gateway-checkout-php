<?php

namespace App\Infra\Adapters\Interfaces;

interface GatewayInterface
{
  public function generateLink(array $product, string $paymentType): string;
  public function getClient(string $customerId): string;
}
