<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NewProviderController extends AbstractController
{
    public function new(): Response
    {
        return $this->render('new.html.twig');
    }
}