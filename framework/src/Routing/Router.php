<?php

namespace Ibrohim\Framework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Ibrohim\Framework\Http\Exceptions\MethodNotAllowedException;
use Ibrohim\Framework\Http\Exceptions\RouteNotFoundException;
use Ibrohim\Framework\Http\Request;
use League\Container\Container;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    private array $routes;
    public function dispatch(Request $request, Container $container)
    {
        [$handler, $vars] = $this->extractRouteInfo($request);

        if (is_array($handler)) {
            [$controllerId, $method] = $handler;
            $controller = $container->get($controllerId);
            $handler = [$controller, $method];
        }

        return [$handler, $vars];
    }

    public function registerRoutes(array $routes): void
    {
        $this->routes = $routes;
    }

    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector){
            foreach ($this->routes as $route) {
                $collector->addRoute(...$route);
            }
        });
        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPath(),
        );
        switch ($routeInfo[0]){
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(', ', $routeInfo[1]);
                $e = new MethodNotAllowedException("Поддерживаемые HTTP методы: $allowedMethods");
                $e->setStatusCode( 405);
                throw $e;
            default:
                $e = new RouteNotFoundException('Маршрут не найден');
                $e->setStatusCode(404);
                throw $e;
        }
    }
}