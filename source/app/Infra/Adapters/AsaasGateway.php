<?php

namespace App\Infra\Adapters;

use App\Infra\Adapters\Interfaces\GatewayInterface;
use App\Infra\Exceptions\PaymentException;

class AsaasGateway implements GatewayInterface
{

  public function generateLink(array $product, string $paymentType): string
  {
    // $paymentData = [
    //   'name' => $product['name'],
    //   'description' => $product['description'],
    //   'value' => $product['price'],
    //   'billingType' => 'UNDEFINED',
    //   'chargeType' => 'INSTALLMENT',
    //   'maxInstallmentCount' => 6,
    //   'dueDateLimitDays' => 10,
    //   'notificationEnabled' => true
    // ];

    $paymentData = [
      'name' => $product['name'],
      'description' => $product['description'],
      'value' => $product['price'],
      'notificationEnabled' => true,
      "callback" => [
        "successUrl" => URL_CALLBACK,
        "autoRedirect" => false
      ]
    ];

    if ($paymentType === 'CREDIT_CARD') {
      $paymentData += [
        'billingType' => 'CREDIT_CARD',
        'chargeType' => 'INSTALLMENT',
        'maxInstallmentCount' => 3,
      ];
    } else {
      $paymentData += [
        'billingType' => $paymentType === 'BILLET' ? 'BOLETO' : 'PIX',
        'chargeType' => 'DETACHED',
        'dueDateLimitDays' => 10,
      ];
    }
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => ASAAS_URL . '/paymentLinks',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($paymentData),
      CURLOPT_HTTPHEADER => [
        'accept: application/json',
        'access_token: ' . API_KEY,
        'content-type: application/json'
      ],
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) throw new PaymentException();
    $responseData = json_decode($response, true);
    return $responseData['url'];
  }

  public function getClient(string $customerId): string
  {
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL =>  ASAAS_URL . '/customers/' . $customerId,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => [
        'accept: application/json',
        'access_token: ' . API_KEY,
      ],
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) throw new PaymentException();
    $responseData = json_decode($response, true);
    return $responseData['cpfCnpj'];
  }
}
