<?php

namespace App\Controllers;

use Ibrohim\Framework\Http\Response;

class HomeController
{
    public function index(): Response
    {
        $content = '<h1>Hello sdad</h1>';

        return new Response($content);
    }
}