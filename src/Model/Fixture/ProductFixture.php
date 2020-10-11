<?php

namespace App\Model\Fixture;

use App\Enum\CountryEnum;
use App\Enum\CurrencyEnum;
use App\Enum\LanguageEnum;
use App\Model\Entity\Category;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Entity\Product;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeRelation;
use App\Model\Entity\ProductCountryContent;
use App\Model\Entity\ProductTranslatableContent;
use App\Model\Repository\CategoryRepository;
use App\Model\Repository\CountryRepository;
use App\Model\Repository\LanguageRepository;
use App\Model\Repository\ProductAttributeRepository;
use App\Model\Repository\ProductRepository;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var ProductAttributeRepository
     */
    private $productAttributeRepository;

    /**
     * ProductFixture constructor.
     * @param \App\Model\Repository\CategoryRepository $categoryRepository
     * @param \App\Model\Repository\CountryRepository $countryRepository
     * @param \App\Model\Repository\LanguageRepository $languageRepository
     * @param \App\Model\Repository\ProductRepository $productRepository
     * @param \App\Model\Repository\ProductAttributeRepository $productAttributeRepository
     */
    public function __construct(CategoryRepository $categoryRepository, CountryRepository $countryRepository, LanguageRepository $languageRepository, ProductRepository $productRepository, ProductAttributeRepository $productAttributeRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->countryRepository = $countryRepository;
        $this->languageRepository = $languageRepository;
        $this->productRepository = $productRepository;
        $this->productAttributeRepository = $productAttributeRepository;
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     * @throws \Doctrine\ORM\ORMException
     */
    public function load(ObjectManager $manager): void
    {
        $this->insert(0, 5000);
        $manager->flush();
        $manager->clear();

        $this->insert(5000, 10000);
        $manager->flush();
        $manager->clear();

        echo static::class . " done.\n";
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            CategoryFixture::class,
            CountryFixture::class,
            LanguageFixture::class,
            ProductAttributeFixture::class,
        ];
    }

    /**
     * @param int $min
     * @param int $max
     * @throws \Doctrine\ORM\ORMException
     */
    private function insert(int $min, int $max): void
    {
        /** @var Language $enLanguage */
        $enLanguage = $this->languageRepository->findOneBy(["iso2" => LanguageEnum::EN]);
        /** @var Language $csLanguage */
        $csLanguage = $this->languageRepository->findOneBy(["iso2" => LanguageEnum::CS]);

        /** @var Country $usCountry */
        $usCountry = $this->countryRepository->findOneBy(["iso2" => CountryEnum::US]);
        /** @var Country $czCountry */
        $czCountry = $this->countryRepository->findOneBy(["iso2" => CountryEnum::CZ]);

        /** @var Category[] $categories */
        $categories = $this->categoryRepository->findAll();

        /** @var ProductAttribute[] $productAttributes */
        $productAttributes = $this->productAttributeRepository->findAll();

        for ($i = $min; $i < $max; $i++)
        {
            $category = $categories[(int) floor($i / 25)];
            $enTitle = "Title " . " " . $enLanguage->getIso2() . " " . $i;
            $csTitle = "Title " . " " . $csLanguage->getIso2() . " " . $i;
            $enSummary = "Summary " . " " . $enLanguage->getIso2() . " " . $i;
            $csSummary = "Summary " . " " . $csLanguage->getIso2() . " " . $i;
            $enDescription = "Description " . " " . $enLanguage->getIso2() . " " . $i;
            $csDescription = "Description " . " " . $csLanguage->getIso2() . " " . $i;
            $usPrice = $i;
            $czPrice = $i * 25;
            $usTax = 7.25;
            $czTax = 21;
            $usDiscount = 0;
            $czDiscount = 0;
            $usCurrency = CurrencyEnum::USD;
            $czCurrency = CurrencyEnum::CZK;

            $product = $this->productRepository->create($enTitle, $enSummary, $enDescription, $usPrice, $usTax, $usDiscount, $usCurrency, true, false, $category, $usCountry, $enLanguage);
            $product->addCountryContent(new ProductCountryContent($czPrice, $czTax, $czDiscount, $czCurrency, true, false, $product, $czCountry));
            $product->addTranslatableContent(new ProductTranslatableContent($csTitle, $csSummary, $csDescription, $product, $csLanguage));
            $product->addAttributes(array_slice($productAttributes, ceil($i / 50) + 50, 50));
        }
    }
}