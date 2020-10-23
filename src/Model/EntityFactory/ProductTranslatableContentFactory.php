<?php

namespace App\Model\Repository;

use App\Model\Entity\Language;
use App\Model\Entity\Product;
use App\Model\Entity\ProductTranslatableContent;

class ProductTranslatableContentFactory extends AbstractRepository
{

    /**
     * @param string $title
     * @param string $summary
     * @param string $description
     * @param \App\Model\Entity\Product $product
     * @param \App\Model\Entity\Language $language
     * @return \App\Model\Entity\ProductTranslatableContent
     */
    public function create(string $title, string $summary, string $description, Product $product, Language $language): ProductTranslatableContent
    {
        return new ProductTranslatableContent($title, $summary, $description, $product, $language);
    }
}