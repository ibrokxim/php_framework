<?php

namespace Ibrohim\Framework\Http;

class Kernel
{
    public function handle(Request $request): Response
    {
        $content = 'hello world';

        return new Response($content);
    }
}
