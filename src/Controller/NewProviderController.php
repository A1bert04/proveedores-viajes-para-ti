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
            ->add('name', TextType::class, ['required' => true, 'attr' => ['class' => 'input input-bordered w-full max-w-xs my-3']])
            ->add('email', EmailType::class, ['required' => true, 'attr' => ['class' => 'input input-bordered w-full max-w-xs my-3']])
            ->add('phone', TelType::class, ['required' => true, 'attr' => ['class' => 'input input-bordered w-full max-w-xs my-3']])
            ->add('active', CheckboxType::class, ['required' => false, 'attr' => ['class' => 'toggle block my-3']])
            ->add('type', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Hotel' => 'Hotel',
                    'Pista' => 'Pista',
                    'Complemento' => 'Complemento',
                ],
                'attr' => ['class' => 'select select-bordered w-full max-w-xs my-3'],
            ])
            ->add('save', SubmitType::class, ['label' => 'Add', 'attr' => ['class' => 'btn btn-neutral w-full text-black']])
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