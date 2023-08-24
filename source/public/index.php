<?php

require __DIR__ . '/../vendor/autoload.php';

use App\http\config\Router;

date_default_timezone_set('America/Sao_Paulo');
define('DSN', 'sqlite:../../data/db.sqlite');
define('USERNAME', '');
define('PASSWORD', '');

define('URL', 'http://localhost:8000/api');

$objRouter = new Router(URL);

include __DIR__ . '/../routes/record.php';

$objRouter->run()->sendResponse();
