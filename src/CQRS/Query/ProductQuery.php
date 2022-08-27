<?php

namespace App\CQRS\Query;

use App\CQRS\Query;
use App\Repository\ProductCriteria;

class ProductQuery extends ProductCriteria implements Query
{
    private ?string $category;
    private ?string $priceLessThan;

    /**
     * @param string|null $category
     * @param string|null $priceLessThan
     */
    public function __construct(?string $category, ?string $priceLessThan)
    {
        $this->setCategory($category);
        $this->setPriceLessThan($priceLessThan);
    }
}
