<?php

namespace App\Util;

use App\Entity\Product;

/**
 *  Util for Product.
 */
class ProductUtil
{
    /**
     * Return price array with final price and applied discount, if applicable.
     *
     * @param Product $product
     * @return array
     */
    public function getPrice(Product $product): array
    {
        $original = $product->getPrice();

        $discountPercentage = null;
        $final = $original;
        $discounts = [];

        // Calculate 30% discount if category is boots.
        if (Product::CATEGORY_BOOTS === $product->getCategory()) {
            $percentage = 30;
            $discounts[$percentage] = $this->getDiscountedAmount(
                $percentage,
                $original
            );
        }

        // Calculate 15% discount if sku matches.
        if ('000003' === $product->getSku()) {
            $percentage = 15;
            $discounts[$percentage] = $this->getDiscountedAmount(
                $percentage,
                $original
            );
        }

        // If there are discounts, apply the highest discount.
        if (0 !== count($discounts)) {
            $discountPercentage = max(array_keys($discounts));
            $final = $discounts[$discountPercentage];
            $discountPercentage = ((string) $discountPercentage) . '%';
        }

        return [
            'original' => $original,
            'final' => $final,
            'discount_percentage' => $discountPercentage,
            'currency' => Product::CURRENCY_EUR,
        ];
    }

    /**
     * Return product in required format.
     *
     * @param Product $product
     * @return array
     */
    public function convertProductToArray(Product $product)
    {
        return [
            'sku' => $product->getSku(),
            'name' => $product->getName(),
            'category' => $product->getCategory(),
            'price' => $this->getPrice($product),
        ];
    }

    /**
     * Return array of formatted products.
     *
     * @param array $products
     * @return array
     */
    public function convertProductsToArray(array $products): array
    {
        $converted = [];

        foreach ($products as $product) {
            $converted[] = $this->convertProductToArray($product);
        }

        return $converted;
    }

    /**
     * Return the discounted price.
     *
     * @param int $percentage
     * @param int $price
     * @return int
     */
    private function getDiscountedAmount(int $percentage, int $price): int
    {
        return $price - ($price * ($percentage / 100));
    }
}
