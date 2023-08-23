<?php
require_once './app/http/response.php';
require_once './app/controllers/record.php';

$objRouter->get('/registros', [
  function($request){
    return  new Response('200', RecordController::index($request));
  }
]);
