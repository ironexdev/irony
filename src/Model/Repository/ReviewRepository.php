<?php

namespace App\Model\Repository;

use App\Model\Entity\Review;
use Doctrine\ORM\NonUniqueResultException;

class ReviewRepository extends AbstractRepository
{
    const ENTITY = Review::class;
}