<?php

namespace App\Model\Repository;

use App\Model\Entity\AuthenticationToken;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Error;

class AuthenticationTokenRepository extends AbstractRepository
{
    const ENTITY = AuthenticationToken::class;

    /**
     * @param string $code
     * @return \App\Model\Entity\AuthenticationToken|null
     */
    public function selectByCode(string $code): ?AuthenticationToken
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
}