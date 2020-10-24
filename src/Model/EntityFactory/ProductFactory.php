<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Entity\Product;
use App\Model\Service\EntityManagerService;

class ProductFactory extends AbstractRepository
{
    /**
     * @var ProductCountryContentFactory
     */
    private $productCountryContentFactory;

    /**
     * @var ProductTranslatableContentFactory
     */
    private $productTranslatableContentFactory;

    /**
     * ProductAttributeFactory constructor.
     * @param \App\Model\Repository\ProductCountryContentFactory $productCountryContentFactory
     * @param \App\Model\Repository\ProductTranslatableContentFactory $productTranslatableContentFactory
     * @param \App\Model\Service\EntityManagerService $entityManagerService
     */
    public function __construct(ProductCountryContentFactory $productCountryContentFactory, ProductTranslatableContentFactory $productTranslatableContentFactory, EntityManagerService $entityManagerService)
    {
        $this->productCountryContentFactory = $productCountryContentFactory;
        $this->productTranslatableContentFactory = $productTranslatableContentFactory;

        parent::__construct($entityManagerService);
    }

    /**
     * @param string $title
     * @param string $summary
     * @param string $description
     * @param string $price
     * @param string $tax
     * @param string $discount
     * @param string $currency
     * @param bool $active
     * @param bool $top
     * @param \App\Model\Entity\Category $category
     * @param \App\Model\Entity\Country $country
     * @param \App\Model\Entity\Language $language
     * @return \App\Model\Entity\Product
     */
    public function create(string $title, string $summary, string $description, string $price, string $tax, string $discount, string $currency, bool $active, bool $top, Category $category, Country $country, Language $language): Product
    {
        $product = new Product();
        $translatableContent = $this->productTranslatableContentFactory->create($title, $summary, $description, $product, $language);
        $countryContent = $this->productCountryContentFactory->create($price, $tax, $discount, $currency, $active, $top, $product, $country);

        $product->addCategory($category);
        $product->addTranslatableContent($translatableContent);
        $product->addCountryContent($countryContent);

        return $product;
    }
}