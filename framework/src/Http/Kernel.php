<?php

namespace Ibrohim\Framework\Http;

use Ibrohim\Framework\Http\Exceptions\HttpException;
use Ibrohim\Framework\Routing\RouterInterface;
use League\Container\Container;


class Kernel
{
    private string $appEnv = 'local';
    public function __construct(
        private RouterInterface $router,
        private Container $container
    )
    {
        $this->appEnv = $this->container->get('APP_ENV');
    }

    public function handle(Request $request): Response
    {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);

            $response = call_user_func_array($routeHandler, $vars);
        } catch (\Exception $e) {
            $response = $this->createExceptionResponse($e);
        }

        return $response;

    }

    private function createExceptionResponse(\Exception $e)
    {
        if (in_array($this->appEnv,['local', 'testing'])){
            throw $e;
        }
        if ($e instanceof HttpException) {
            return new  Response($e->getMessage(), $e->getStatusCode());
        }
        return  new Response('Ошибка сервера', 500);
    }

}