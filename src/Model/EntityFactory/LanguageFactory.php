<?php

namespace App\Model\Repository;

use App\Model\Entity\Language;

class LanguageFactory extends AbstractRepository
{
    /**
     * @param string $iso2
     * @return \App\Model\Entity\Language
     */
    public function create(string $iso2): Language
    {
        return new Language($iso2);
    }
}