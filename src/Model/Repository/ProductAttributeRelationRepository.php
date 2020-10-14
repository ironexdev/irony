<?php

namespace App\Model\Repository;

use App\Model\Entity\ProductAttributeRelation;
use Doctrine\ORM\NonUniqueResultException;

class ProductAttributeRelationRepository extends AbstractRepository
{
    const ENTITY = ProductAttributeRelation::class;
}