<?php

namespace App\Model\Repository;

use App\Model\Entity\DeliveryCountryContent;
use Doctrine\ORM\NonUniqueResultException;

class DeliveryCountryContentRepository extends AbstractRepository
{
    const ENTITY = DeliveryCountryContent::class;
}