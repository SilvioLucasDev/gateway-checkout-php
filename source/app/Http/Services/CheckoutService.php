<?php

namespace App\Http\Services;

use App\Http\Exceptions\ProductNotFoundException;
use App\Infra\Adapters\Interfaces\GatewayInterface;
use App\Infra\Repositories\Interfaces\ProductRepositoryInterface;

class CheckoutService
{
  public function __construct(
    private readonly ProductRepositoryInterface $productRepository,
    private readonly GatewayInterface $paymentGateway,
  ) {
  }

  public function checkout(string $productId, string $paymentType): array
  {
    $product = $this->productRepository->findById($productId);
    if (!$product) throw new ProductNotFoundException();
    $paymentLink = $this->paymentGateway->generateLink($product, $paymentType);
    return [
      'paymentLink' => $paymentLink
    ];
  }
}
