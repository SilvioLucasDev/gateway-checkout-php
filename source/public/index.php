<?php

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../vendor/autoload.php';

use App\http\config\Router;

$objRouter = new Router(URL);

include __DIR__ . '/../routes/payment.php';

$objRouter->run()->sendResponse();
