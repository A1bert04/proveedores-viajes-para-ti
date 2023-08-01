<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('main.html.twig',
            [
                'title' => 'Hello World!',
                'message' => 'Welcome to my first Symfony 5 application!'
            ]
        );
    }
}