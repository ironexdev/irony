<?php

namespace App\Model\Repository;

use Backup\App\Model\Entity\Delivery;
use Doctrine\ORM\NonUniqueResultException;

class DeliveryRepository extends AbstractRepository
{
    const ENTITY = Delivery::class;
}