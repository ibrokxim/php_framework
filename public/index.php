<?php

use Ibrohim\Framework\Http\Kernel;
use Ibrohim\Framework\Http\Request;

require_once dirname(__DIR__).'/vendor/autoload.php';

$request = Request::createFromGlobals();

$kernel = new Kernel;
$response = $kernel->handle($request);

$response->send();
