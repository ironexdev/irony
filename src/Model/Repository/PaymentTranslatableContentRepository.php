<?php

namespace App\Model\Repository;

use App\Model\Entity\PaymentTranslatableContent;
use Doctrine\ORM\NonUniqueResultException;

class PaymentTranslatableContentRepository extends AbstractRepository
{
    const ENTITY = PaymentTranslatableContent::class;
}