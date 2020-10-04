<?php

namespace App\Model\Repository;

use App\Model\Entity\Product;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeInt;

class ProductAttributeIntRepository extends AbstractRepository
{
    const ENTITY = ProductAttributeInt::class;

    /**
     * @param int $value
     * @param \App\Model\Entity\Product $product
     * @param \App\Model\Entity\ProductAttribute $productAttribute
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(int $value, Product $product, ProductAttribute $productAttribute)
    {
        $productAttributeValue = new ProductAttributeInt($value, $product, $productAttribute);

        $this->entityManagerService->persist($productAttributeValue);
    }
}