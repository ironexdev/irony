<?php

namespace App\Model\Repository;

use App\Model\Entity\ProductAttributeTextTranslatableContent;
use Doctrine\ORM\NonUniqueResultException;

class ProductAttributeTextTranslatableContentRepository extends AbstractRepository
{
    const ENTITY = ProductAttributeTextTranslatableContent::class;
}