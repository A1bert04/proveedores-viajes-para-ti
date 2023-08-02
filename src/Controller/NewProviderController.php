<?php

namespace App\Controller;

use App\Entity\Provider;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class NewProviderController extends AbstractController
{
    public function new(Request $request): Response
    {
        $newProvider = new Provider();


        $form = $this->createFormBuilder($newProvider)
            ->add('name', TextType::class)
            ->add('email', EmailType::class, ['required' => true])
            ->add('phone', TelType::class, ['required' => true])
            ->add('active', CheckboxType::class, ['required' => false])
            ->add('type', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Hotel' => 'Hotel',
                    'Pista' => 'Pista',
                    'Complemento' => 'Complemento',
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Add'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save the entity to the database
            $newProvider->setCreatedAt(new \DateTimeImmutable());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newProvider);
            $entityManager->flush();

            return $this->redirectToRoute('index', ['success' => 'true']);
        }

        return $this->render('new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}