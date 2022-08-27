<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param ProductCriteria $criteria
     * @return Product[] Returns an array of Product objects
     */
    public function match(ProductCriteria $criteria): array
    {
        $qb = $this
            ->createQueryBuilder('p')
        ;

        if (null !== $criteria->getCategory()) {
            $qb
                ->andWhere('p.category = :category')
                ->setParameter('category', $criteria->getCategory())
            ;
        }

        if (null !== $criteria->getPriceLessThan()) {
            $qb
                ->andWhere('p.price <= :price_less_than')
                ->setParameter('price_less_than', $criteria->getPriceLessThan())
            ;
        }

        return $qb
            ->orderBy('p.name')
            ->getQuery()
            ->getResult()
        ;
    }
}
