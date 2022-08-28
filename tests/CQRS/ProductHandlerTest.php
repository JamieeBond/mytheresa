<?php

namespace App\Tests\CQRS;

use App\CQRS\Query\ProductHandler;
use App\CQRS\Query\ProductQuery;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Util\ProductUtil;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ProductHandlerTest extends TestCase
{
    private EntityManagerInterface $em;
    private ProductUtil $util;
    private ProductRepository $repository;
    private Product $product;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->util = $this->createMock(ProductUtil::class);
        $this->repository = $this->createMock(ProductRepository::class);
        $this->product = $this->createMock(Product::class);
    }

    /**
     * @see ProductHandler::__invoke()
     * @return void
     */
    public function testInvokeOneProduct()
    {
        $em = $this->em;
        $util = $this->util;
        $repository = $this->repository;

        $repository
            ->expects($this->once())
            ->method('match')
            ->willReturn([$this->product])
        ;

        $em
            ->expects($this->once())
            ->method('getRepository')
            ->willReturn($repository)
        ;

        $util
            ->expects($this->once())
            ->method('convertProductsToArray')
            ->willReturn(['product'])
        ;

        $handler = new ProductHandler($em, $util);
        $query = New ProductQuery(Product::CATEGORY_SANDALS, null);
        $handled = $handler->__invoke($query);

        $this->assertCount(1, $handled, 'Repo returns one product and calls util.');
    }

    /**
     * @see ProductHandler::__invoke()
     * @return void
     */
    public function testInvokeNoProducts()
    {
        $em = $this->em;
        $util = $this->util;
        $repository = $this->repository;

        $repository
            ->expects($this->once())
            ->method('match')
            ->willReturn([])
        ;

        $em
            ->expects($this->once())
            ->method('getRepository')
            ->willReturn($repository)
        ;

        $util
            ->expects($this->never())
            ->method('convertProductsToArray')
        ;

        $handler = new ProductHandler($em, $util);
        $query = New ProductQuery(Product::CATEGORY_BOOTS, 1000);
        $handled = $handler->__invoke($query);

        $this->assertCount(0, $handled, 'Repo returns no products and no util call.');
    }
}
