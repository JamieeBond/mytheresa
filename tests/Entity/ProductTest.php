<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private Product $product;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->product = new Product(
            '00004',
            'Vans Hoodie',
            'hoodies',
            98888
        );
    }

    /**
     * @see Product::CURRENCY_EUR
     * @see Product::CATEGORY_BOOTS
     * @see Product::CATEGORY_SANDALS
     */
    public function testConstants(): void
    {
        $this->assertSame('EUR',Product::CURRENCY_EUR);
        $this->assertSame('boots',Product::CATEGORY_BOOTS);
        $this->assertSame('sandals',Product::CATEGORY_SANDALS);
    }

    /**
     * @see Product::__construct()
     * @return void
     */
    public function testConstructor(): void
    {
        $sku = '00009';
        $name = 'Vans Boots';
        $category = 'boots';
        $price = 89000;

        $product = new Product(
            $sku,
            $name,
            $category,
            $price
        );

        $this->assertNull($product->getId());
        $this->assertSame($sku, $product->getSku());
        $this->assertSame($name, $product->getName());
        $this->assertSame($category, $product->getCategory());
        $this->assertSame($price, $product->getPrice());
    }

    /**
     * @see Product::setName()
     * @see Product::getName()
     * @return void
     */
    public function testSetGetName(): void
    {
        $product = $this->product;
        $name = 'DC Hoodie';
        $product->setName($name);
        $this->assertSame($name, $product->getName());
    }

    /**
     * @see Product::setCategory()
     * @see Product::getCategory()
     * @return void
     */
    public function testSetGetCategory(): void
    {
        $product = $this->product;
        $category = 't-shirts';
        $product->setCategory($category);
        $this->assertSame($category, $product->getCategory());
    }

    /**
     * @see Product::setPrice()
     * @see Product::getPrice()
     * @return void
     */
    public function testSetGetPrice(): void
    {
        $product = $this->product;
        $price = 59878;
        $product->setPrice($price);
        $this->assertSame($price, $product->getPrice());
    }
}
