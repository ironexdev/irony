<?php

namespace App\Model\Repository;

use App\Model\Entity\Language;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeTranslatableContent;

class ProductAttributeTranslatableContentFactory extends AbstractRepository
{
    /**
     * @param string $title
     * @param string $units
     * @param \App\Model\Entity\ProductAttribute $productAttribute
     * @param \App\Model\Entity\Language $language
     * @return \App\Model\Entity\ProductAttributeTranslatableContent
     */
    public function create(string $title, string $units, ProductAttribute $productAttribute, Language $language): ProductAttributeTranslatableContent
    {
        return new ProductAttributeTranslatableContent($title, $units, $productAttribute, $language);
    }
}