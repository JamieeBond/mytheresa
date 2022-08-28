<?php

namespace App\Tests\Repository;

use App\Entity\Product;
use App\Repository\ProductCriteria;
use PHPUnit\Framework\TestCase;

class ProductCriteriaTest extends TestCase
{
    private ProductCriteria $criteria;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->criteria = new ProductCriteria();
    }

    /**
     * @see ProductCriteria::setCategory()
     * @see ProductCriteria::getCategory()
     * @return void
     */
    public function testSetGetCategory(): void
    {
        $expected = Product::CATEGORY_SANDALS;
        $criteria = $this->criteria->setCategory($expected);
        $this->assertSame($expected, $criteria->getCategory());
        $this->assertNull($criteria->getPriceLessThan());
    }

    /**
     * @see ProductCriteria::setPriceLessThan()
     * @see ProductCriteria::getPriceLessThan()
     * @return void
     */
    public function testSetGetPriceLessThan(): void
    {
        $expected = 40000;
        $criteria = $this->criteria->setPriceLessThan($expected);
        $this->assertSame($expected, $criteria->getPriceLessThan());
        $this->assertNull($criteria->getCategory());
    }
}
