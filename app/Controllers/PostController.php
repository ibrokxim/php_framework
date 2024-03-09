<?php

namespace App\Controllers;

use Ibrohim\Framework\src\Http\Response;

class PostController
{
    public function show(int $id): Response
    {
        $content = "<h1>Hello - $id</h1>";
        return new Response($content);
    }
}