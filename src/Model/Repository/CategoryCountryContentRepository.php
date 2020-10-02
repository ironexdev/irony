<?php

namespace App\Model\Repository;

use App\Model\Entity\CategoryCountryContent;
use Doctrine\ORM\NonUniqueResultException;
use Error;

class CategoryCountryContentRepository extends AbstractRepository
{
    const ENTITY = CategoryCountryContent::class;
}