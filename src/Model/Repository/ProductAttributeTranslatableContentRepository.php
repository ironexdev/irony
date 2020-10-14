<?php

namespace App\Model\Repository;

use App\Model\Entity\ProductAttributeTranslatableContent;
use Doctrine\ORM\NonUniqueResultException;

class ProductAttributeTranslatableContentRepository extends AbstractRepository
{
    const ENTITY = ProductAttributeTranslatableContent::class;
}