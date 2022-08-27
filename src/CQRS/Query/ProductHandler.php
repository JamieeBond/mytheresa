<?php

namespace App\CQRS\Query;

use App\CQRS\QueryHandler;
use App\Entity\Product;
use App\Util\ProductUtil;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Query product match, returning formatted array.
 */
class ProductHandler implements QueryHandler
{
    private EntityManagerInterface $em;
    private ProductUtil $util;

    /**
     * @param EntityManagerInterface $em
     * @param ProductUtil $util
     */
    public function __construct(EntityManagerInterface $em, ProductUtil $util)
    {
        $this->em = $em;
        $this->util = $util;
    }

    /**
     * @param ProductQuery $query
     * @return array
     */
    public function __invoke(ProductQuery $query): array
    {
        $products = $this->em->getRepository(Product::class)->match($query);

        if (0 === count($products)) {
            return [];
        }

        return $this->util->convertProductsToArray($products);
    }
}
