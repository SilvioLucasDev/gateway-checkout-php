<?php

use App\factories\RecordControllerFactory;
use App\http\config\Response;

$objRouter->get('/registros', [
  function ($request) {
    $controller = RecordControllerFactory::create();
    return  new Response($controller->index($request));
  }
]);

$objRouter->get('/registro/{id}', [
  function ($id) {
    $controller = RecordControllerFactory::create();
    return  new Response($controller->show($id));
  }
]);

$objRouter->post('/registro', [
  function ($request) {
    $controller = RecordControllerFactory::create();
    return  new Response($controller->store($request));
  }
]);

$objRouter->delete('/registro/{id}', [
  function ($id) {
    $controller = RecordControllerFactory::create();
    return  new Response($controller->destroy($id));
  }
]);

$objRouter->put('/registro/{id}', [
  function ($id, $request) {
    $controller = RecordControllerFactory::create();
    return  new Response($controller->update($id, $request));
  }
]);

$objRouter->patch('/registro/{id}', [
  function ($id, $request) {
    $controller = RecordControllerFactory::create();
    return  new Response($controller->update($id, $request));
  }
]);
