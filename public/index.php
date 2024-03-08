<?php

define('BASE_PATH', dirname(__DIR__));
require_once dirname(__DIR__).'/vendor/autoload.php';

use Ibrohim\Framework\Http\Kernel;
use Ibrohim\Framework\Http\Request;
use Ibrohim\Framework\Routing\Router;

$request = Request::createFromGlobals();
$router = new Router();

$kernel = new Kernel($router);

$response = $kernel->handle($request);

$response->send();

