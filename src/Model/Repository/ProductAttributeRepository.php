<?php

namespace App\Model\Repository;

use App\Model\Entity\Language;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeTranslatableContent;

class ProductAttributeRepository extends AbstractRepository
{
    const ENTITY = ProductAttribute::class;
}