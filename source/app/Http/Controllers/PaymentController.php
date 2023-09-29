<?php

namespace App\Http\Controllers;

use App\Http\Config\Request;
use App\Http\Services\AsaasWebHookService;
use App\Http\Services\CheckoutService;

class PaymentController
{
  public function __construct(
    private readonly CheckoutService $checkoutService,
    private readonly AsaasWebHookService $asaasWebHookService,
  ) {
  }

  public function checkout(string $id, Request $request): array
  {
    $body = $request->getPostVars();
    $paymentType = $body['paymentType'];
    return $this->checkoutService->getLink($id, $paymentType);
  }

  public function webHook(Request $request): void
  {
    $body = $request->getPostVars();
    $data = [
      'event' => $body['event'],
      'customerId' => $body['payment']['customer'],
      'paymentType' =>  $body['payment']['billingType'],
      'total' => $body['payment']['value'],
      'installmentNumber' => $body['payment']['installmentNumber'] ?? 0,
      'transactionId' => $body['payment']['id'],
      'processorResponse' => json_encode($body),
    ];
    $this->asaasWebHookService->processPayment($data);
  }
}

// O WEBHOOK SÓ É VÁLIDO SE RECEBER UM STATUS 200, ENQUANTO N RECEBER ELE FICA BATENDO NA ROTA
// ENTÃO SE ESTOURAR UMA EXCEPTION ELE VAI TENTAR REENVIAR O WEBHOOK PQ VAI RECEBER UM ERRO (500)
// DEPOIS DE ALGUMAS REQUEST ELE DESABILITA A FILA E VOCÊ TEM QUE REATIVAR MANUALMENTE
