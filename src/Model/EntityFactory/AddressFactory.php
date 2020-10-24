<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Entity\Address;
use App\Model\Service\EntityManagerService;

class AddressFactory extends AbstractRepository
{
    /**
     * @param string $street
     * @param string $streetNumber
     * @param string $city
     * @param string $zipCode
     * @param string $country
     * @param string $note
     * @return \App\Model\Entity\Address
     */
    public function create(string $street, string $streetNumber, string $city, string $zipCode, string $country, string $note): Address
    {
        return new Address($street, $streetNumber, $city, $zipCode, $country, $note);
    }
}