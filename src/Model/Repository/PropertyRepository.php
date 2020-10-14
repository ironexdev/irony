<?php

namespace App\Model\Repository;

use App\Model\Entity\Order;
use App\Model\Entity\Property;
use Doctrine\ORM\NonUniqueResultException;

class PropertyRepository extends AbstractRepository
{
    const ENTITY = Property::class;
}