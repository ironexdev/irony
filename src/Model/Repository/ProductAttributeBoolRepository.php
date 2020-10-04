<?php

namespace App\Model\Repository;

use App\Model\Entity\Product;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeBool;

class ProductAttributeBoolRepository extends AbstractRepository
{
    const ENTITY = ProductAttributeBool::class;

    /**
     * @param bool $value
     * @param \App\Model\Entity\Product $product
     * @param \App\Model\Entity\ProductAttribute $productAttribute
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(bool $value, Product $product, ProductAttribute $productAttribute)
    {
        $productAttributeValue = new ProductAttributeBool($value, $product, $productAttribute);

        $this->entityManagerService->persist($productAttributeValue);
    }
}