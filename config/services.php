<?php

use Ibrohim\Framework\Http\Kernel;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use Ibrohim\Framework\Routing\RouterInterface;
use Ibrohim\Framework\Routing\Router;
use League\Container\ReflectionContainer;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(BASE_PATH.'/.env');


// Параметры приложения
$routes = include BASE_PATH.'/routes/web.php';

// Сервисы приложения
$container = new Container();
$container->delegate(new ReflectionContainer(true));

$appEnv = $_ENV['APP_ENV'] ?? 'local';
$container->add('APP_ENV', new StringArgument($appEnv));

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)
          ->addMethodCall('registerRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)
          ->addArgument(RouterInterface::class)
          ->addArgument($container);

return $container;