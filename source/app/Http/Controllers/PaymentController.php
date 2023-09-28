<?php

namespace App\Http\Controllers;

use App\Http\Config\Request;
use App\Http\Services\CheckoutService;

class PaymentController
{
  public function __construct(private readonly CheckoutService $checkoutService)
  {
  }


  public function checkout(string $id, Request $request): array
  {
    //REMOVER DAQUI ESSE CÓDIGO
    define('API_KEY', '$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAwNjQ4MTc6OiRhYWNoX2RlYmJkZDA1LTdjZTEtNGUwOC1hYmYwLTFiMDFkMTZiYWQ4OQ==');

    $body = $request->getPostVars();
    $paymentType = $body['paymentType'];
    return $this->checkoutService->checkout($id, $paymentType);
  }

  public function webHook(Request $request): void
  {
    // RECEBE AS INFORMAÇÕES DO WEBHOOK
    // MANDA UMA REQUISIÇÃO PARA PEGAR OS DADOS DO PAGADOR
    // SALVA NA BASE A COMPRA PELO CPF
  }

  // public function index(Request $request): array
  // {
  //   $queryParams = $request->getQueryParams();
  //   return $this->repository->get($queryParams);
  // }

  // public function show(int|string $id): array|string
  // {
  //   FieldValidation::isNumber(['id' => $id], ['id']);
  //   $record = $this->repository->findById($id);
  //   return $record ? $record : 'Record not found!';
  // }

  // public function store(Request $request): string
  // {
  //   $body = $request->getPostVars();
  //   FieldValidation::isBoolean($body, ['is_identified']);
  //   FieldValidation::isRequired($body, ['type', 'message', 'is_identified']);
  //   $lastId = $this->repository->getLastInsertedId();
  //   $record = Record::create(
  //     $lastId,
  //     $body['type'],
  //     $body['message'],
  //     $body['is_identified'],
  //     $body['whistleblower_name'] ?? null,
  //     $body['whistleblower_birth'] ?? null
  //   );
  //   return $this->repository->save($record);
  // }

  // public function destroy(int|string $id): string
  // {
  //   FieldValidation::isNumber(['id' => $id], ['id']);
  //   $record = $this->repository->findById($id);
  //   if (!$record) throw new RecordNotFoundException();
  //   return $this->repository->delete($id);
  // }

  // public function update(int|string $id, Request $request): string
  // {
  //   $body = $request->getPostVars();
  //   $method = $request->getHttpMethod();
  //   if ($method === 'PUT') FieldValidation::isRequired($body, ['type', 'message', 'is_identified']);
  //   FieldValidation::isBoolean($body, ['is_identified']);
  //   FieldValidation::isNumber(['id' => $id], ['id']);
  //   $record = $this->repository->findById($id);
  //   if (!$record) throw new RecordNotFoundException();
  //   $record = Record::update(
  //     $id,
  //     $body['type'] ?? $record['type'],
  //     $body['message'] ?? $record['message'],
  //     $body['is_identified'] ?? $record['is_identified'],
  //     $body['whistleblower_name'] ?? $record['whistleblower_name'],
  //     $body['whistleblower_birth'] ?? $record['whistleblower_birth'],
  //   );
  //   return $this->repository->update($record);
  // }
}
