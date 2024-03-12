<?php

define('BASE_PATH', dirname(__DIR__));
require_once dirname(__DIR__).'/vendor/autoload.php';
require_once dirname(__DIR__).'/framework/vendor/autoload.php';
use Ibrohim\Framework\Http\Kernel;
use Ibrohim\Framework\Http\Request;


$request = Request::createFromGlobals();

/** @var \League\Container\Container $container */
$container = require BASE_PATH.'/config/services.php';

$kernel = $container->get(Kernel::class);

$response = $kernel->handle($request);

$response->send();

