<?php

namespace App\Tests\Repository;

use App\Entity\Product;
use App\Repository\ProductCriteria;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Generator;

class ProductRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;

    /**
     * Setting up EntityManager
     * @return void
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @return Generator
     */
    protected function getMatchCriteria(): Generator
    {
        $criteria = new ProductCriteria();
        $criteria->setCategory(Product::CATEGORY_SANDALS);

        yield [$criteria, 1, 'Database contains 1 sandal'];

        $criteria = new ProductCriteria();
        $criteria->setCategory(Product::CATEGORY_SANDALS);
        $criteria->setPriceLessThan(1000);

        yield [$criteria, 0, 'Database contains no sandals at 1000 or under'];

        $criteria = new ProductCriteria();
        $criteria->setCategory(Product::CATEGORY_BOOTS);

        yield [$criteria, 3, 'Database contains 3 boots'];

        $criteria = new ProductCriteria();
        $criteria->setCategory(Product::CATEGORY_BOOTS);
        $criteria->setPriceLessThan(90000);

        yield [$criteria, 2, 'Database contains 2 boots at 90000 or under'];
    }

    /**
     * @see ProductRepository::match()
     * @dataProvider getMatchCriteria()
     */
    public function testMatch(ProductCriteria $criteria, int $expected, string $message): void
    {
        $products = $this->entityManager
            ->getRepository(Product::class)
            ->match($criteria)
        ;

        $this->assertCount($expected, $products, $message);
    }

    /**
     * Tear down to prevent memory leak
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
