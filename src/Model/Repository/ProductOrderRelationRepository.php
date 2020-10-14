<?php

namespace App\Model\Repository;

use App\Model\Entity\ProductOrderRelation;
use Doctrine\ORM\NonUniqueResultException;

class ProductOrderRelationRepository extends AbstractRepository
{
    const ENTITY = ProductOrderRelation::class;
}