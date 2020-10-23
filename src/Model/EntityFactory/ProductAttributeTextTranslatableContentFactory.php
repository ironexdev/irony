<?php

namespace App\Model\Repository;

use App\Model\Entity\Language;
use App\Model\Entity\ProductAttributeText;
use App\Model\Entity\ProductAttributeTextTranslatableContent;

class ProductAttributeTextTranslatableContentFactory extends AbstractRepository
{
    /**
     * @param string $value
     * @param \App\Model\Entity\ProductAttributeText $productAttributeText
     * @param \App\Model\Entity\Language $language
     * @return \App\Model\Entity\ProductAttributeTextTranslatableContent
     */
    public function create(string $value, ProductAttributeText $productAttributeText, Language $language): ProductAttributeTextTranslatableContent
    {
        return new ProductAttributeTextTranslatableContent($value, $productAttributeText, $language);
    }
}