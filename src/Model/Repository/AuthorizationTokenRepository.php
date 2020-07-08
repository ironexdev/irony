<?php

namespace App\Model\Repository;

use App\Model\Entity\AuthorizationToken;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Error;

class AuthorizationTokenRepository extends AbstractRepository
{
    const ENTITY = AuthorizationToken::class;

    /**
     * @param string $code
     * @return \App\Model\Entity\AuthorizationToken|null
     */
    public function selectByCode(string $code): ?AuthorizationToken
    {
        $query = $this->getEntityManager()->createQuery("SELECT token FROM " . static::ENTITY . " token WHERE token.code = :code");
        $query->setParameter("code", $code);

        try
        {
            return $query->getSingleResult();
        }
        catch (NoResultException $e)
        {
            return null;
        }
        catch (NonUniqueResultException $e)
        {
            throw new Error($e->getMessage(), 0, $e);
        }
    }

    /**
     * @param string $accountId
     */
    public function deleteByAccountId(string $accountId): void
    {
        $query = $this->getEntityManager()->createQuery("DELETE FROM " . static::ENTITY . " token WHERE token.account = :accountId");
        $query->setParameter("accountId", $accountId);

        $query->execute();
    }
}