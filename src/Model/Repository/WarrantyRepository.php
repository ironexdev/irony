<?php

namespace App\Model\Repository;

use App\Model\Entity\Order;
use App\Model\Entity\Warranty;
use Doctrine\ORM\NonUniqueResultException;

class WarrantyRepository extends AbstractRepository
{
    const ENTITY = Warranty::class;
}