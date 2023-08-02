<?php

namespace App\Controller;

use App\Entity\Provider;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    public function index(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Provider::class);

        $currentPage = $request->query->getInt('page', 1);
        $pageSize = 10;

        $query = $repository->createQueryBuilder('p')
            ->getQuery();

        $paginator = new Paginator($query);
        $paginator->getQuery()
            ->setFirstResult($pageSize * ($currentPage - 1))
            ->setMaxResults($pageSize);

        $totalCount = count($paginator);

        $totalPages = (int) ceil($totalCount / $pageSize);

        return $this->render('main.html.twig', [
            'providers' => $paginator,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }
}