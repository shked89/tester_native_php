<?php

require_once 'autoload.php';
require_once 'getenv.php';

// echo env('APP_URL');

use App\Config\Router;

$router = new Router();

$router->CheckRoutes();

