<?php

namespace App\Controller;

use App\CQRS\Query\ProductQuery;
use App\CQRS\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private QueryBus $queryBus;

    /**
     * @param QueryBus $queryBus
     */
    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * Return Json of filtered products
     *
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/products', name: 'app_products'),Route('/', name: 'app_default')]
    public function index(Request $request): JsonResponse
    {
        return $this->json($this->queryBus
            ->handle(new ProductQuery(
                $request->get('category'),
                $request->get('priceLessThan')
            ))
        );
    }
}
