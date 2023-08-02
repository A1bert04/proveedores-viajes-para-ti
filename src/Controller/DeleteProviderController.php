<?php

namespace App\Controller;

use App\Entity\Provider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteProviderController extends AbstractController
{
    public function delete(Request $request): Response
    {
        $id = $request->attributes->get('id');
        $opConfirmed = $request->query->get('opConfirmed');

        if (!$opConfirmed) {
            return $this->redirectToRoute('index', ['remove' => $id]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $provider = $entityManager->getRepository(Provider::class)->find($id);

        if (!$provider) {
            throw $this->createNotFoundException('Provider not found');
        }

        $entityManager->remove($provider);
        $entityManager->flush();

        return $this->redirectToRoute('index', ['successful' => true, 'operation' => 'delete']);
    }
}