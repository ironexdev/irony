<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Entity\Product;
use App\Model\Entity\ProductCountryContent;
use App\Model\Entity\ProductTranslatableContent;

class ProductRepository extends AbstractRepository
{
    const ENTITY = Product::class;

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
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(string $title, string $summary, string $description, string $price, string $tax, string $discount, string $currency, bool $active, bool $top, Category $category, Country $country, Language $language): Product
    {
        $product = new Product();
        $translatableContent = new ProductTranslatableContent($title, $summary, $description, $product, $language);
        $countryContent = new ProductCountryContent($price, $tax, $discount, $currency, $active, $top, $product, $country);

        $product->addCategory($category);
        $product->addTranslatableContent($translatableContent);
        $product->addCountryContent($countryContent);

        $this->entityManagerService->persist($product);

        return $product;
    }
}