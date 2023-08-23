<?php
require_once './api/http/response.php';
require_once './api/controllers/record.php';

$objRouter->get('/registros', [
  function($request){
    return  new Response('200', RecordController::index($request));
  }
]);
