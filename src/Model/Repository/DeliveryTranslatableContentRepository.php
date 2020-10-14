<?php

namespace App\Model\Repository;

use App\Model\Entity\DeliveryTranslatableContent;
use Doctrine\ORM\NonUniqueResultException;

class DeliveryTranslatableContentRepository extends AbstractRepository
{
    const ENTITY = DeliveryTranslatableContent::class;
}