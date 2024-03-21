<?php

namespace App\Controllers;

use Ibrohim\Framework\Controller\AbstractController;
use Ibrohim\Framework\Http\Response;

class PostController extends AbstractController
{
    public function show(int $id): Response
    {
        return  $this->render('posts.html.twig',[
           'postId' => $id
        ]);
    }
}