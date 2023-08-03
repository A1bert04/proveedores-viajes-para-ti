<?php

namespace App\Controller;

use App\Entity\Provider;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditProviderController extends AbstractController
{
    public function edit(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $provider = $entityManager->getRepository(Provider::class)->find($id);

        if (!$provider) {
            throw $this->createNotFoundException('Provider not found.');
        }

        $form = $this->createFormBuilder($provider)
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
            ->add('save', SubmitType::class, ['label' => 'Save', 'attr' => ['class' => 'btn btn-neutral w-full text-black hover:text-white']])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $provider->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();

            return $this->redirectToRoute('index', ['success' => 'true', 'operation' => 'edit']);
        }

        return $this->render('edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
