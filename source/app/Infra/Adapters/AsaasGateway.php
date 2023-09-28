<?php

namespace App\Infra\Adapters;

use App\Infra\Adapters\Interfaces\GatewayInterface;

class AsaasGateway implements GatewayInterface
{

  public function generateLink(array $product, string $paymentType): string
  {

    $paymentData = [
      'name' => $product['name'],
      'description' => $product['description'],
      'value' => $product['price'],
      'billingType' => 'UNDEFINED',
      'chargeType' => 'INSTALLMENT',
      'maxInstallmentCount' => 6,
      'dueDateLimitDays' => 10,
      'notificationEnabled' => true
    ];

    // $paymentData = [
    //   'name' => $product['name'],
    //   'description' => $product['description'],
    //   'value' => $product['price'],
    //   'notificationEnabled' => true // DEFINE SE O CLIENTE IRÁ RECEBER NOTIFICAÇÕES SOBRE O PAGAMENTO (GERÁ COBRANÇA)
    // ];

    // if ($paymentType === 'CREDIT_CARD') {
    //   $paymentData += [
    //     'billingType' => 'CREDIT_CARD',
    //     'chargeType' => 'INSTALLMENT',
    //     'maxInstallmentCount' => 3,
    //   ];
    // } elseif ($paymentType === 'BILLET') {
    //   $paymentData += [
    //     'billingType' => 'BOLETO',
    //     'chargeType' => 'DETACHED',
    //     'dueDateLimitDays' => 10,
    //   ];
    // } elseif ($paymentType === 'PIX') {
    //   $paymentData += [
    //     'billingType' => 'PIX',
    //     'chargeType' => 'DETACHED',
    //     'dueDateLimitDays' => 10,
    //   ];
    // }

    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://sandbox.asaas.com/api/v3/paymentLinks",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
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

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $responseData = json_decode($response, true);
      return $responseData['url'];
    }
  }
}
