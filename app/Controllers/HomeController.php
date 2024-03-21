<?php

namespace App\Controllers;

use Ibrohim\Framework\Controller\AbstractController;
use Ibrohim\Framework\Http\Response;


class HomeController extends AbstractController
{
    public function __construct()
    {

    }

    public function index(): Response
    {
        //$this->container->get('twig');  получаем сервис зарегистрированный в сервисах

        $content = '<h1>Hello sdad</h1>';

        return $this->render('home.html.twig');
    }
}