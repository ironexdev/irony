<?php

namespace App\Model\Repository;

use App\Model\Entity\Product;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeDecimal;

class ProductAttributeDecimalRepository extends AbstractRepository
{
    const ENTITY = ProductAttributeDecimal::class;

    /**
     * @param string $value
     * @param \App\Model\Entity\Product $product
     * @param \App\Model\Entity\ProductAttribute $productAttribute
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(string $value, Product $product, ProductAttribute $productAttribute)
    {
        $productAttributeValue = new ProductAttributeDecimal($value, $product, $productAttribute);

        $this->entityManagerService->persist($productAttributeValue);
    }
}