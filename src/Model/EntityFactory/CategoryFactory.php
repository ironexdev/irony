<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;

class CategoryFactory extends AbstractRepository
{
    /**
     * @param \App\Model\Entity\Category|null $parent
     * @return \App\Model\Entity\Category
     */
    public function create(Category $parent = null): Category
    {
        return new Category($parent);
    }
}