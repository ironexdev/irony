<?php

namespace App\Model\Fixture;

use App\Enum\CountryEnum;
use App\Enum\CurrencyEnum;
use App\Enum\LanguageEnum;
use App\Model\Entity\Category;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Entity\Product;
use App\Model\Entity\ProductCountryContent;
use App\Model\Entity\ProductTranslatableContent;
use App\Model\Repository\CategoryRepository;
use App\Model\Repository\CountryRepository;
use App\Model\Repository\LanguageRepository;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends AbstractFixture
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
     * ProductFixture constructor.
     * @param \App\Model\Repository\CategoryRepository $categoryRepository
     * @param \App\Model\Repository\CountryRepository $countryRepository
     * @param \App\Model\Repository\LanguageRepository $languageRepository
     */
    public function __construct(CategoryRepository $categoryRepository, CountryRepository $countryRepository, LanguageRepository $languageRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->countryRepository = $countryRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
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

        for ($i = 0; $i < 12500; $i++)
        {
            $product = new Product();

            $enTitle = "Title " . " " . $enLanguage->getIso2() . " " . $i;
            $csTitle = "Title " . " " . $csLanguage->getIso2() . " " . $i;
            $enSummary = "Summary " . " " . $enLanguage->getIso2() . " " . $i;
            $csSummary = "Summary " . " " . $csLanguage->getIso2() . " " . $i;
            $enDescription = "Description " . " " . $enLanguage->getIso2() . " " . $i;
            $csDescription = "Description " . " " . $csLanguage->getIso2() . " " . $i;

            $enTranslatableContent = new ProductTranslatableContent($enTitle, $enSummary, $enDescription, $product, $enLanguage);
            $csTranslatableContent = new ProductTranslatableContent($csTitle, $csSummary, $csDescription, $product, $csLanguage);

            $usPrice = $i;
            $czPrice = $i * 25;
            $usTax = 7.25;
            $czTax = 21;
            $usDiscount = 0;
            $czDiscount = 0;
            $usCurrency = CurrencyEnum::USD;
            $czCurrency = CurrencyEnum::CZK;

            $usCountryContent = new ProductCountryContent($usPrice, $usTax, $usDiscount, $usCurrency, false, $product, $usCountry);
            $czCountryContent = new ProductCountryContent($czPrice, $czTax, $czDiscount, $czCurrency, false, $product, $czCountry);

            $product->addCategory($categories[(int) floor($i / 25)]);
            $product->addTranslatableContent($enTranslatableContent);
            $product->addTranslatableContent($csTranslatableContent);
            $product->addCountryContent($usCountryContent);
            $product->addCountryContent($czCountryContent);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            CategoryFixture::class,
            CountryFixture::class,
            LanguageFixture::class
        ];
    }
}