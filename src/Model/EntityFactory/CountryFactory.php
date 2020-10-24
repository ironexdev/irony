<?php

namespace App\Model\Repository;

use App\Model\Entity\Country;

class CountryFactory extends AbstractRepository
{
    /**
     * @param string $iso2
     * @return \App\Model\Entity\Country
     */
    public function create(string $iso2): Country
    {
        return new Country($iso2);
    }
}