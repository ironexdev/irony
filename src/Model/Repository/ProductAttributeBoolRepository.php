<?php

namespace App\Model\Repository;

use App\Model\Entity\Product;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeBool;

class ProductAttributeBoolRepository extends AbstractRepository
{
    const ENTITY = ProductAttributeBool::class;
}