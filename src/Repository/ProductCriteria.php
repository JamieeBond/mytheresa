<?php

namespace App\Repository;

class ProductCriteria
{
    private ?string $category;
    private ?int $priceLessThan;

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return ProductCriteria
     */
    public function setCategory(?string $category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriceLessThan(): ?int
    {
        return $this->priceLessThan;
    }

    /**
     * @param int|null $priceLessThan
     * @return ProductCriteria
     */
    public function setPriceLessThan(?int $priceLessThan): self
    {
        $this->priceLessThan = $priceLessThan;
        return $this;
    }
}
