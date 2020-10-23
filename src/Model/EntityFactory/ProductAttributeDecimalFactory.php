<?php

namespace App\Model\Repository;

use App\Model\Entity\Product;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeDecimal;

class ProductAttributeDecimalFactory extends AbstractRepository
{
    /**
     * @param string $value
     * @param \App\Model\Entity\Product $product
     * @param \App\Model\Entity\ProductAttribute $productAttribute
     * @return \App\Model\Entity\ProductAttributeDecimal
     */
    public function create(string $value, Product $product, ProductAttribute $productAttribute): ProductAttributeDecimal
    {
        return new ProductAttributeDecimal($value, $product, $productAttribute);
    }
}