<?php

namespace App\Model\Repository;

use App\Model\Entity\Payment;
use Doctrine\ORM\NonUniqueResultException;

class PaymentRepository extends AbstractRepository
{
    const ENTITY = Payment::class;
}