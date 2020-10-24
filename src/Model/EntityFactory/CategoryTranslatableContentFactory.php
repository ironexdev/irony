<?php

namespace App\Model\Repository;

use App\Model\Entity\Language;
use App\Model\Entity\Category;
use App\Model\Entity\CategoryTranslatableContent;

class CategoryTranslatableContentFactory extends AbstractRepository
{
    /**
     * @param string $title
     * @param \App\Model\Entity\Category $category
     * @param \App\Model\Entity\Language $language
     * @return \App\Model\Entity\CategoryTranslatableContent
     */
    public function create(string $title, Category $category, Language $language): CategoryTranslatableContent
    {
        return new CategoryTranslatableContent($title, $category, $language);
    }
}