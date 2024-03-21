<?php

namespace Ibrohim\Framework\Controller;


use Ibrohim\Framework\Http\Response;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    protected ?ContainerInterface $container = null;

    public function setContainer(ContainerInterface $container):void
    {
        $this->container = $container;
    }


    public function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $content = $this->container->get('twig')->render($view, $parameters);
        $response ??= new Response();

        $response->setContent($content);
        return $response;
    }

}