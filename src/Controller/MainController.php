<?php

namespace App\Controller;

use App\Entity\Provider;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Provider::class);
        $queryBuilder = $repository->createQueryBuilder('p');

        $searchTerm = $request->query->get('search');
        $this->applySearch($searchTerm, $queryBuilder);

        $sortby = $request->query->get('sortby');
        $sortorder = $request->query->get('ord');

        $this->applySorting($sortby, $sortorder, $queryBuilder);

        $currentPage = $request->query->getInt('page', 1);
        $pageSize = 10;
        list($paginator, $totalPages) = $this->paginateContent($queryBuilder, $pageSize, $currentPage);

        return $this->render('main.html.twig', [
            'providers' => $paginator,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    /**
     * @param $sortby
     * @param $sortorder
     * @param $queryBuilder
     * @return void
     */
    public function applySorting($sortby, $sortorder, $queryBuilder): void
    {
        // Maps sortby values to entity fields
        $sortFieldMapping = [
            'name' => 'p.name',
            'email' => 'p.email',
            'phone' => 'p.phone',
            'createdAt' => 'p.created_at',
        ];

        // Apply sorting if valid sortby value provided in query params
        if (isset($sortFieldMapping[$sortby])) {
            $sortorder = strtolower($sortorder);
            if ($sortorder === 'asc' || $sortorder === 'desc') {
                $queryBuilder->orderBy($sortFieldMapping[$sortby], $sortorder);
            } else {
                // If invalid sort order provided, default to 'asc'
                $queryBuilder->orderBy($sortFieldMapping[$sortby], 'asc');
            }
        }
    }

    /**
     * @param $queryBuilder
     * @param int $pageSize
     * @param int $currentPage
     * @return array
     */
    public function paginateContent($queryBuilder, int $pageSize, int $currentPage): array
    {
        // Get the total count for pagination
        $totalCount = count($queryBuilder->getQuery()->getResult());

        // Apply pagination
        $queryBuilder->setFirstResult($pageSize * ($currentPage - 1))
            ->setMaxResults($pageSize);

        // Create the Paginator
        $paginator = new Paginator($queryBuilder->getQuery());

        // Calculate total pages for pagination
        $totalPages = (int)ceil($totalCount / $pageSize);
        return array($paginator, $totalPages);
    }

    /**
     * @param $searchTerm
     * @param $queryBuilder
     * @return void
     */
    public function applySearch($searchTerm, $queryBuilder): void
    {
        // Apply search if search term provided in query params
        if ($searchTerm) {
            $queryBuilder->where(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->like('p.name', ':searchTerm'),
                    $queryBuilder->expr()->like('p.email', ':searchTerm'),
                    $queryBuilder->expr()->like('p.phone', ':searchTerm')
                )
            )->setParameter('searchTerm', '%' . $searchTerm . '%');
        }
    }
}