<?php

use App\factories\PaymentControllerFactory;
use App\http\config\Response;

$objRouter->post('/purchase/products/{id}', [
  function ($id, $request) {
    $controller = PaymentControllerFactory::create();
    return  new Response($controller->checkout($id, $request));
  }
]);

$objRouter->post('/webhook/asaas/payments', [
  function ($request) {
    $controller = PaymentControllerFactory::create();
    return  new Response($controller->webhook($request));
  }
]);

