<?php

namespace Ibrohim\Framework\Http;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Kernel
{
    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector){
            $collector->get( '/', function (){
                $content = '<h1>Hello</h1>';

                return new Response($content);
            });

            $collector->get('/posts/{id}', function (array $vars){
                $content = "<h1>Hello - {$vars['id']} </h1>";
                return new Response($content);
            });
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPath(),
        );

        [$status, $handler, $vars] = $routeInfo;

        return $handler($vars);
    }

}