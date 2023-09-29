<?php

namespace App\Http\Services;

use App\Infra\Adapters\Interfaces\GatewayInterface;
use App\Infra\Repositories\Interfaces\TransactionRepositoryInterface;
use DateTime;

class AsaasWebHookService
{
  public function __construct(
    private readonly TransactionRepositoryInterface $transactionRepository,
    private readonly GatewayInterface $paymentGateway,
  ) {
  }

  public function processPayment(array $data): void
  {
    $document = $this->paymentGateway->getClient($data['customerId']);
    // PEGA O USER ID PELO CPF E PEGA O ID DO PRODUTO QUE ELE ESTÁ VINCULADO
    $userId = 1;
    $productId = 1;
    if ($data['event'] === 'PAYMENT_CREATED') {
      $transaction = [
        'user_id' => $userId,
        'product_id' => $productId,
        'payment_type' => $data['paymentType'],
        'total' => $data['total'],
        'installments' => $data['installmentNumber'],
        'transaction_id' => $data['transactionId'],
        'status' => 'PENDING',
        'processor_response' => $data['processorResponse'],
        'created_at' => new DateTime(),
        'updated_at' => new DateTime(),
      ];
      $this->transactionRepository->save($transaction);
    } elseif ($data['event'] === 'PAYMENT_CONFIRMED' || $data['event'] === 'PAYMENT_RECEIVED') {
      $transaction = [
        'transaction_id' => $data['transactionId'],
        'status' => 'APPROVED',
        'processor_response' => $data['processorResponse'],
      ];
      $this->transactionRepository->update($transaction);
    } elseif ($data['event'] === 'PAYMENT_REFUNDED') {
      $transaction = [
        'transaction_id' => $data['transactionId'],
        'status' => 'CANCELLED',
        'processor_response' => $data['processorResponse'],
      ];
      $this->transactionRepository->update($transaction);
    } else {
      // SE NÃO FOR NENHUM DOS EVENTOS DEFINIDOS, PODE SER PAYMENT_REFUNDED, PAYMENT_OVERDUE E ETC.
      // VOCE PODE MANTER O STATUS E SÓ GRAVAR O PROCESSO RESPONSE
      $transaction = [
        'transaction_id' => $data['transactionId'],
        'processor_response' => $data['processorResponse'],
      ];
      $this->transactionRepository->update($transaction);
    }
  }
}
// ESTORNO PAYMENT_REFUNDED
// PARA CHEGAR NESSE RETORNO PODE TER ALGUNS ANTES, MAS SEMPRE QUE CHEGAR O VALOR SERÁ ESTORNADO

// ATRASO PAYMENT_OVERDUE ->
// SEMPRE DPS DO PAYMENT_OVERDUE VEM O PAYMENT_CONFIRMED OU PAYMENT_RECEIVED,
// SE CASO FOR COBRAR MULTA POR ATRASO VAI TER QUE TRABALHAR NA REQUEST, COLOCAR JUROS E ETC.

// RECOMENDO USAR UM BANCO DE DADOS NÃO RELACIONAL PARA TER O HISTÓRICO DOS WEBHOOK
