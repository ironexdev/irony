<?php

namespace App\Model\Repository;

use App\Model\Entity\Product;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeInt;

class ProductAttributeIntFactory extends AbstractRepository
{
    /**
     * @param int $value
     * @param \App\Model\Entity\Product $product
     * @param \App\Model\Entity\ProductAttribute $productAttribute
     * @return \App\Model\Entity\ProductAttributeInt
     */
    public function create(int $value, Product $product, ProductAttribute $productAttribute): ProductAttributeInt
    {
        return new ProductAttributeInt($value, $product, $productAttribute);
    }
}