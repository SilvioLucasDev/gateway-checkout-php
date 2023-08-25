<?php

use App\factories\RecordControllerFactory;
use App\http\config\Response;

$objRouter->get('/registros', [
  function ($request) {
    $controller = RecordControllerFactory::create();
    return  new Response($controller->index($request));
  }
]);

$objRouter->get('/registros/{id}', [
  function ($id) {
    $controller = RecordControllerFactory::create();
    return  new Response($controller->show($id));
  }
]);

$objRouter->post('/registros', [
  function ($request) {
    $controller = RecordControllerFactory::create();
    return  new Response($controller->store($request));
  }
]);

$objRouter->delete('/registros/{id}', [
  function ($id) {
    $controller = RecordControllerFactory::create();
    return  new Response($controller->destroy($id));
  }
]);

$objRouter->put('/registros/{id}', [
  function ($id, $request) {
    $controller = RecordControllerFactory::create();
    return  new Response($controller->update($id, $request));
  }
]);

$objRouter->patch('/registros/{id}', [
  function ($id, $request) {
    $controller = RecordControllerFactory::create();
    return  new Response($controller->update($id, $request));
  }
]);
