<?php

namespace App\Model\Repository;

use App\Model\Entity\Language;
use App\Model\Entity\Product;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeText;
use App\Model\Entity\ProductAttributeTextTranslatableContent;
use App\Model\Service\EntityManagerService;

class ProductAttributeTextFactory extends AbstractRepository
{
    /**
     * @var ProductAttributeTextTranslatableContentFactory
     */
    private $productAttributeTextTranslatableContentFactory;

    /**
     * ProductAttributeFactory constructor.
     * @param \App\Model\Repository\ProductAttributeTextTranslatableContentFactory $productAttributeTextTranslatableContentFactory
     * @param \App\Model\Service\EntityManagerService $entityManagerService
     */
    public function __construct(ProductAttributeTextTranslatableContentFactory $productAttributeTextTranslatableContentFactory, EntityManagerService $entityManagerService)
    {
        $this->productAttributeTextTranslatableContentFactory = $productAttributeTextTranslatableContentFactory;

        parent::__construct($entityManagerService);
    }

    /**
     * @param string $value
     * @param \App\Model\Entity\Product $product
     * @param \App\Model\Entity\ProductAttribute $productAttribute
     * @param \App\Model\Entity\Language $language
     * @return \App\Model\Entity\ProductAttributeText
     */
    public function create(string $value, Product $product, ProductAttribute $productAttribute, Language $language): ProductAttributeText
    {
        $productAttributeText = new ProductAttributeText($product, $productAttribute);
        $translatableContent = $this->productAttributeTextTranslatableContentFactory->create($value, $productAttributeText, $language);

        $productAttributeText->addTranslatableContent($translatableContent);

        return $productAttributeText;
    }
}