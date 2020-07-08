<?php

namespace App\Model\Repository;

use App\Model\Entity\Account;
use Doctrine\ORM\NonUniqueResultException;
use Error;

class AccountRepository extends AbstractRepository
{
    const ENTITY = Account::class;

    /**
     * @param string $email
     * @return \App\Model\Entity\AuthenticationToken|null
     */
    public function selectByEmail(string $email): ?Account
    {
        $query = $this->entityManagerService->createQuery("SELECT a FROM " . static::ENTITY . " a WHERE a.email = :email");
        $query->setParameter("email", $email);

        try
        {
            return $query->getOneOrNullResult();
        }
        catch (NonUniqueResultException $e)
        {
            throw new Error($e->getMessage(), 0, $e);
        }
    }
}