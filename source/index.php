<?php
require_once './api/db/database.php';
require_once './api/http/request.php';
require_once './api/http/response.php';
require_once './api/http/router.php';
require_once './api/controllers/record.php';


date_default_timezone_set('America/Sao_Paulo');
define('URL', 'http://localhost:8000/api');

$request = new Request();
$objRouter = new Router(URL, $request);

include __DIR__.'/api/routes/record.php';

$objRouter->run()->sendResponse();
