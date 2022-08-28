<?php

namespace App\Tests\CQRS;

use App\CQRS\Query\ProductQuery;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductQueryTest extends TestCase
{
    /**
     * @see ProductQuery::__construct()
     * @return void
     */
    public function testConstructor(): void
    {
        $category = Product::CATEGORY_SANDALS;
        $priceLessThan = 45560;
        $query = new ProductQuery($category, $priceLessThan);

        $this->assertSame($category, $query->getCategory());
        $this->assertSame($priceLessThan, $query->getPriceLessThan());
    }
}
