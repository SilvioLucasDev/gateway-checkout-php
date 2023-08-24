<?php

use App\http\config\Response;
use App\http\controllers\RecordController;
use App\infra\repositories\sqlite\RecordRepository;


$objRouter->get('/registros', [
  function ($request) {
    $repository = new RecordRepository();
    $controller = new RecordController($repository);
    return new Response($controller->index($request));
  }
]);

$objRouter->get('/registros', [
  function ($request) {
    $repository = new RecordRepository();
    $controller = new RecordController($repository);
    return  new Response($controller->index($request));
  }
]);

$objRouter->get('/registro/{id}', [
  function ($id) {
    $repository = new RecordRepository();
    $controller = new RecordController($repository);
    return  new Response($controller->show($id));
  }
]);

$objRouter->post('/registro', [
  function ($request) {
    $repository = new RecordRepository();
    $controller = new RecordController($repository);
    return  new Response($controller->store($request));
  }
]);

$objRouter->delete('/registro/{id}', [
  function ($id) {
    $repository = new RecordRepository();
    $controller = new RecordController($repository);
    return  new Response($controller->destroy($id));
  }
]);

$objRouter->put('/registro/{id}', [
  function ($id, $request) {
    $repository = new RecordRepository();
    $controller = new RecordController($repository);
    return  new Response($controller->update($id, $request));
  }
]);
