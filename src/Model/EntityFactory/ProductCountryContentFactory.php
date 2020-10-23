<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Entity\Product;
use App\Model\Entity\ProductCountryContent;
use App\Model\Entity\ProductTranslatableContent;
use App\Model\Service\EntityManagerService;

class ProductCountryContentFactory extends AbstractRepository
{
    /**
     * @param string $price
     * @param string $tax
     * @param string $discount
     * @param string $currency
     * @param bool $active
     * @param bool $top
     * @param \App\Model\Entity\Product $product
     * @param \App\Model\Entity\Country $country
     * @return \App\Model\Entity\ProductCountryContent
     */
    public function create(string $price, string $tax, string $discount, string $currency, bool $active, bool $top, Product $product, Country $country): ProductCountryContent
    {
        return new ProductCountryContent($price, $tax, $discount, $currency, $active, $top, $product, $country);
    }
}