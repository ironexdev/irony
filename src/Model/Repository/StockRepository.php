<?php

namespace App\Model\Repository;

use App\Model\Entity\Stock;
use Doctrine\ORM\NonUniqueResultException;

class StockRepository extends AbstractRepository
{
    const ENTITY = Stock::class;
}