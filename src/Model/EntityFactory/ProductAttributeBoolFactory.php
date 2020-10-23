<?php

namespace App\Model\Repository;

use App\Model\Entity\Product;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeBool;

class ProductAttributeBoolFactory extends AbstractRepository
{
    /**
     * @param bool $value
     * @param \App\Model\Entity\Product $product
     * @param \App\Model\Entity\ProductAttribute $productAttribute
     * @return \App\Model\Entity\ProductAttributeBool
     */
    public function create(bool $value, Product $product, ProductAttribute $productAttribute): ProductAttributeBool
    {
        return new ProductAttributeBool($value, $product, $productAttribute);
    }
}