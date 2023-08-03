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

        $searchTerm = $request->query->get('search');

        $queryBuilder = $repository->createQueryBuilder('p');

        if ($searchTerm) {
            $queryBuilder->where(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->like('p.name', ':searchTerm'),
                    $queryBuilder->expr()->like('p.email', ':searchTerm'),
                    $queryBuilder->expr()->like('p.phone', ':searchTerm')
                )
            )->setParameter('searchTerm', '%'.$searchTerm.'%');
        }

        // Get the total count for pagination
        $totalCount = count($queryBuilder->getQuery()->getResult());

        // Apply pagination
        $queryBuilder->setFirstResult($pageSize * ($currentPage - 1))
            ->setMaxResults($pageSize);

        // Create the Paginator
        $paginator = new Paginator($queryBuilder->getQuery());

        // Calculate total pages for pagination
        $totalPages = (int) ceil($totalCount / $pageSize);

        return $this->render('main.html.twig', [
            'providers' => $paginator,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }
}