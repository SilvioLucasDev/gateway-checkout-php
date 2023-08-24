<?php
require_once './app/http/response.php';
require_once './app/controllers/record.php';

$objRouter->get('/registros', [
  function($request){
    return  new Response('200', RecordController::index($request));
  }
]);

$objRouter->get('/registro/{id}', [
  function($id){
    return  new Response('200', RecordController::show($id));
  }
]);

$objRouter->post('/registro', [
  function($request){
    return  new Response('200', RecordController::store($request));
  }
]);
