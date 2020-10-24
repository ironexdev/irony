<?php

namespace App\Model\Repository;

use App\Model\Entity\Language;
use App\Model\Entity\Product;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeText;
use App\Model\Entity\ProductAttributeTextTranslatableContent;

class ProductAttributeTextRepository extends AbstractRepository
{
    const ENTITY = ProductAttributeText::class;
}