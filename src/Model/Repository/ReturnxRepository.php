<?php

namespace App\Model\Repository;

use App\Model\Entity\Returnx;
use Doctrine\ORM\NonUniqueResultException;

class ReturnxRepository extends AbstractRepository
{
    const ENTITY = Returnx::class;
}