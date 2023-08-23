<?php
require_once './app/db/database.php';
require_once './app/http/request.php';
require_once './app/http/response.php';
require_once './app/http/router.php';
require_once './app/controllers/record.php';


date_default_timezone_set('America/Sao_Paulo');
define('URL', 'http://localhost:8000/api');

$objRouter = new Router(URL);

include __DIR__.'/app/routes/record.php';

$objRouter->run()->sendResponse();
