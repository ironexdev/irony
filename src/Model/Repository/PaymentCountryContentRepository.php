<?php

namespace App\Model\Repository;

use App\Model\Entity\PaymentCountryContent;
use Doctrine\ORM\NonUniqueResultException;

class PaymentCountryContentRepository extends AbstractRepository
{
    const ENTITY = PaymentCountryContent::class;
}