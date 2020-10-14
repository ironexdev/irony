<?php

namespace App\Model\Repository;

use App\Model\Entity\ProductCountryContent;
use Doctrine\ORM\NonUniqueResultException;

class ProductCountryContentRepository extends AbstractRepository
{
    const ENTITY = ProductCountryContent::class;
}