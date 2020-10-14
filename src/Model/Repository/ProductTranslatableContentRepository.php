<?php

namespace App\Model\Repository;

use App\Model\Entity\ProductTranslatableContent;
use Doctrine\ORM\NonUniqueResultException;

class ProductTranslatableContentRepository extends AbstractRepository
{
    const ENTITY = ProductTranslatableContent::class;
}