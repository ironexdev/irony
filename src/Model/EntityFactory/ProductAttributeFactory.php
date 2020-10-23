<?php

namespace App\Model\Repository;

use App\Model\Entity\Language;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeTranslatableContent;
use App\Model\Service\EntityManagerService;

class ProductAttributeFactory extends AbstractRepository
{
    /**
     * @var ProductAttributeTranslatableContentFactory
     */
    private $productAttributeTranslatableContentFactory;

    /**
     * ProductAttributeFactory constructor.
     * @param \App\Model\Repository\ProductAttributeTranslatableContentFactory $productAttributeTranslatableContentFactory
     * @param \App\Model\Service\EntityManagerService $entityManagerService
     */
    public function __construct(ProductAttributeTranslatableContentFactory $productAttributeTranslatableContentFactory, EntityManagerService $entityManagerService)
    {
        $this->productAttributeTranslatableContentFactory = $productAttributeTranslatableContentFactory;

        parent::__construct($entityManagerService);
    }

    /**
     * @param string $type
     * @param string $title
     * @param string $units
     * @param \App\Model\Entity\Language $language
     * @return \App\Model\Entity\ProductAttribute
     */
    public function create(string $type, string $title, string $units, Language $language): ProductAttribute
    {
        $productAttribute = new ProductAttribute($type);

        $translatableContent = $this->productAttributeTranslatableContentFactory->create($title, $units, $productAttribute, $language);
        $productAttribute->addTranslatableContent($translatableContent);

        return $productAttribute;
    }
}