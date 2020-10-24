<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;
use App\Model\Entity\Country;
use App\Model\Entity\CategoryCountryContent;

class CategoryCountryContentFactory extends AbstractRepository
{
    /**
     * @param bool $active
     * @param \App\Model\Entity\Category $category
     * @param \App\Model\Entity\Country $country
     * @return \App\Model\Entity\CategoryCountryContent
     */
    public function create(bool $active, Category $category, Country $country): CategoryCountryContent
    {
        return new CategoryCountryContent($active, $category, $country);
    }
}