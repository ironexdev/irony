<?php

namespace App\Model\Repository;

use App\Model\Entity\Product;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeDecimal;

class ProductAttributeDecimalRepository extends AbstractRepository
{
    const ENTITY = ProductAttributeDecimal::class;
}