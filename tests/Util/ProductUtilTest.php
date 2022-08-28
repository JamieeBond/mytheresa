<?php

namespace App\Tests\Util;

use App\Entity\Product;
use App\Util\ProductUtil;
use PHPUnit\Framework\TestCase;
use Generator;

class ProductUtilTest extends TestCase
{
    private ProductUtil $util;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->util = new ProductUtil();
    }

    /**
     * @param int $original
     * @param int $final
     * @param string|null $discountPercentage
     * @return array
     */
    private function createPriceArray(int $original, int $final, ?string $discountPercentage): array
    {
        return [
            'original' => $original,
            'final' => $final,
            'discount_percentage' => $discountPercentage,
            'currency' => Product::CURRENCY_EUR,
        ];
    }

    /**
     * @param Product $product
     * @param array $price
     * @return array
     */
    private function createProductArray(Product $product, array $price): array
    {
        return [
            'sku' => $product->getSku(),
            'name' => $product->getName(),
            'category' => $product->getCategory(),
            'price' => $price,
        ];
    }

    /**
     * @return Generator
     */
    protected function getProductPriceTestData(): Generator
    {
        $price = 80000;

        $product = new Product(
            '000003',
            'Green Sandals',
            Product::CATEGORY_SANDALS,
            $price
        );

        $expected = $this->createPriceArray(
            $price,
            68000,
            '15%'
        );

        yield [$product, $expected, 'Sku:000003 has 15% discount.'];

        $price = 90000;

        $product = new Product(
            '000003',
            'Green Boots',
            Product::CATEGORY_BOOTS,
            $price
        );

        $expected = $this->createPriceArray(
            $price,
            63000,
            '30%'
        );

        yield [$product, $expected, 'Has 15% and 30% discount, apply the highest.'];

        $price = 40000;

        $product = new Product(
            '000005',
            'Green Boots',
            Product::CATEGORY_BOOTS,
            $price
        );

        $expected = $this->createPriceArray(
            $price,
            28000,
            '30%'
        );

        yield [$product, $expected, 'Category:boots has 30% discount.'];

        $price = 60000;

        $product = new Product(
            '000009',
            'Green Boots',
            Product::CATEGORY_SANDALS,
            $price
        );

        $expected = $this->createPriceArray(
            $price,
            $price,
            null
        );

        yield [$product, $expected, 'Matches no discount criteria.'];
    }

    /**
     * @see ProductUtil::getPrice()
     * @dataProvider getProductPriceTestData
     */
    public function testGetPrice(Product $product, array $expected, string $message): void
    {
        $actual = $this->util->getPrice($product);
        $this->assertSame($expected, $actual, $message);
    }

    /**
     * @see ProductUtil::convertProductToArray()
     * @return void
     */
    public function testConvertProductToArray(): void
    {
        $originalPrice = 80000;

        $product = new Product(
            '000003',
            'Green Sandals',
            Product::CATEGORY_SANDALS,
            $originalPrice
        );

        $price = $this->createPriceArray(
            $originalPrice,
            68000,
            '15%'
        );

        $expected = $this->createProductArray($product, $price);
        $actual = $this->util->convertProductToArray($product);
        $this->assertSame($expected, $actual);
    }

    /**
     * @see ProductUtil::convertProductsToArray()
     * @return void
     */
    public function testConvertProductsToArray(): void
    {
        $expected = [];

        $originalPrice = 80000;

        $productOne = new Product(
            '000003',
            'Green Sandals',
            Product::CATEGORY_SANDALS,
            $originalPrice
        );

        $price = $this->createPriceArray(
            $originalPrice,
            68000,
            '15%'
        );

        $expected[] = $this->createProductArray($productOne, $price);

        $originalPrice = 60000;

        $productTwo = new Product(
            '000009',
            'Green Boots',
            Product::CATEGORY_SANDALS,
            $originalPrice
        );

        $price = $this->createPriceArray(
            $originalPrice,
            $originalPrice,
            null
        );

        $expected[] = $this->createProductArray($productTwo, $price);

        $actual = $this->util->convertProductsToArray([
            $productOne,
            $productTwo
        ]);

        $this->assertSame($expected, $actual);
    }
}
