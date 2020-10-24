<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Service\EntityManagerService;

class CategoryFactory extends AbstractRepository
{
    /**
     * @var CategoryCountryContentFactory
     */
    private $categoryCountryContentFactory;

    /**
     * @var CategoryTranslatableContentFactory
     */
    private $categoryTranslatableContentFactory;

    /**
     * CategoryFactory constructor.
     * @param \App\Model\Repository\CategoryCountryContentFactory $categoryCountryContentFactory
     * @param \App\Model\Repository\CategoryTranslatableContentFactory $categoryTranslatableContentFactory
     * @param \App\Model\Service\EntityManagerService $entityManagerService
     */
    public function __construct(CategoryCountryContentFactory $categoryCountryContentFactory, CategoryTranslatableContentFactory $categoryTranslatableContentFactory, EntityManagerService $entityManagerService)
    {
        $this->categoryCountryContentFactory = $categoryCountryContentFactory;
        $this->categoryTranslatableContentFactory = $categoryTranslatableContentFactory;

        parent::__construct($entityManagerService);
    }

    /**
     * @param string $title
     * @param bool $active
     * @param \App\Model\Entity\Category|null $parent
     * @param \App\Model\Entity\Country $country
     * @param \App\Model\Entity\Language $language
     * @return \App\Model\Entity\Category
     */
    public function create(string $title, bool $active, Category $parent = null, Country $country, Language $language): Category
    {
        $category = new Category($parent);
        $translatableContent = $this->categoryTranslatableContentFactory->create($title, $category, $language);
        $countryContent = $this->categoryCountryContentFactory->create($active, $category, $country);

        $category->addTranslatableContent($translatableContent);
        $category->addCountryContent($countryContent);

        return $category;
    }
}