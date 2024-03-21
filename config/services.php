<?php

use Ibrohim\Framework\Controller\AbstractController;
use Ibrohim\Framework\Http\Kernel;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use Ibrohim\Framework\Routing\RouterInterface;
use Ibrohim\Framework\Routing\Router;
use League\Container\ReflectionContainer;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dotenv = new Dotenv();
$dotenv->load(BASE_PATH.'/.env');


// Параметры приложения
$routes = include BASE_PATH.'/routes/web.php';
$appEnv = $_ENV['APP_ENV'] ?? 'local';
$viewsPath = BASE_PATH.'/views';

// Сервисы приложения
$container = new Container();
$container->delegate(new ReflectionContainer(true));

$container->add('APP_ENV', new StringArgument($appEnv));

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)
          ->addMethodCall('registerRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)
          ->addArgument(RouterInterface::class)
          ->addArgument($container);


$container->addShared('twig-loader', FilesystemLoader::class)
          ->addArgument(new StringArgument($viewsPath));

$container->addShared('twig', Environment::class)
          ->addArgument('twig-loader');

$container->inflector(AbstractController::class)
          ->invokeMethod('setContainer', [$container]);
return $container;