<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Entity\Product;
use App\Model\Entity\ProductCountryContent;
use App\Model\Entity\ProductTranslatableContent;

class ProductRepository extends AbstractRepository
{
    const ENTITY = Product::class;
}