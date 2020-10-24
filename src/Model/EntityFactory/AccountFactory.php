<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Entity\Account;
use App\Model\Service\EntityManagerService;

class AccountFactory extends AbstractRepository
{
    /**
     * @param string $email
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     * @param bool $cookieConsent
     * @param string $role
     * @param \App\Model\Entity\Country $country
     * @param \App\Model\Entity\Language $language
     * @return \App\Model\Entity\Account
     */
    public function create(string $email, string $password, string $firstName, string $lastName, bool $cookieConsent, string $role, Country $country, Language $language): Account
    {
        return new Account($email, $password, $firstName, $lastName, $cookieConsent, $role, $country, $language);
    }
}