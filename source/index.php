<?php

require __DIR__ . '/vendor/autoload.php';

use \App\http\Router;

date_default_timezone_set('America/Sao_Paulo');
define('URL', 'http://localhost:8000/api');

$objRouter = new Router(URL);

include __DIR__ . '/app/routes/record.php';

$objRouter->run()->sendResponse();
