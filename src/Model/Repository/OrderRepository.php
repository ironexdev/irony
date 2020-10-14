<?php

namespace App\Model\Repository;

use App\Model\Entity\Order;
use Doctrine\ORM\NonUniqueResultException;

class OrderRepository extends AbstractRepository
{
    const ENTITY = Order::class;
}