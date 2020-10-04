<?php

namespace App\Model\Repository;

use App\Model\Entity\Language;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeTranslatableContent;

class ProductAttributeRepository extends AbstractRepository
{
    const ENTITY = ProductAttribute::class;

    /**
     * @param string $type
     * @param string $title
     * @param string $units
     * @param \App\Model\Entity\Language $language
     * @return \App\Model\Entity\ProductAttribute
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(string $type, string $title, string $units, Language $language): ProductAttribute
    {
        $productAttribute = new ProductAttribute($type);

        $translatableContent = new ProductAttributeTranslatableContent($title, $units, $productAttribute, $language);
        $productAttribute->addTranslatableContent($translatableContent);

        $this->entityManagerService->persist($productAttribute);

        return $productAttribute;
    }
}