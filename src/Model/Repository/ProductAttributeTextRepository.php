<?php

namespace App\Model\Repository;

use App\Model\Entity\Language;
use App\Model\Entity\Product;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeText;
use App\Model\Entity\ProductAttributeTextTranslatableContent;

class ProductAttributeTextRepository extends AbstractRepository
{
    const ENTITY = ProductAttributeText::class;

    /**
     * @param string $value
     * @param \App\Model\Entity\Product $product
     * @param \App\Model\Entity\ProductAttribute $productAttribute
     * @param \App\Model\Entity\Language $language
     * @return \App\Model\Entity\ProductAttributeText
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(string $value, Product $product, ProductAttribute $productAttribute, Language $language): ProductAttributeText
    {
        $productAttributeValue = new ProductAttributeText($product, $productAttribute);
        $translatableContent = new ProductAttributeTextTranslatableContent($value, $productAttributeValue, $language);

        $productAttributeValue->addTranslatableContent($translatableContent);

        $this->entityManagerService->persist($productAttributeValue);

        return $productAttributeValue;
    }
}