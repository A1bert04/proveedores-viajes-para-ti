<?php

namespace App\Controller;

use App\Entity\Provider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    public function index(Request $request): Response
    {

        // Check if the 'success' query parameter is set to true
        $success = $request->query->getBoolean('success');

        // Get all providers from the database
        $providers = $this->getDoctrine()
            ->getRepository(Provider::class)
            ->findAll();

        return $this->render('main.html.twig',
            [
                'providers' => $providers,
            ]
        );
    }
}