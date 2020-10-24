<?php

namespace App\Model\Fixture;

use App\Enum\CountryEnum;
use App\Enum\CurrencyEnum;
use App\Enum\LanguageEnum;
use App\Model\Entity\Category;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductCountryContent;
use App\Model\Entity\ProductTranslatableContent;
use App\Model\Repository\CategoryFactory;
use App\Model\Repository\CountryRepository;
use App\Model\Repository\LanguageRepository;
use App\Model\Repository\ProductAttributeRepository;
use App\Model\Repository\ProductCountryContentFactory;
use App\Model\Repository\ProductFactory;
use App\Model\Repository\ProductTranslatableContentFactory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @var CategoryFactory
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
     * @var ProductCountryContentFactory
     */
    private $productCountryContentFactory;

    /**
     * @var ProductFactory
     */
    private $productFactory;

    /**
     * @var ProductTranslatableContentFactory
     */
    private $productTranslatableContentFactory;

    /**
     * @var ProductAttributeRepository
     */
    private $productAttributeRepository;

    /**
     * ProductFixture constructor.
     * @param \App\Model\Repository\CategoryFactory $categoryRepository
     * @param \App\Model\Repository\CountryRepository $countryRepository
     * @param \App\Model\Repository\LanguageRepository $languageRepository
     * @param \App\Model\Repository\ProductCountryContentFactory $productCountryContentFactory
     * @param \App\Model\Repository\ProductFactory $productFactory
     * @param \App\Model\Repository\ProductTranslatableContentFactory $productTranslatableContentFactory
     * @param \App\Model\Repository\ProductAttributeRepository $productAttributeRepository
     */
    public function __construct(CategoryFactory $categoryRepository, CountryRepository $countryRepository, LanguageRepository $languageRepository, ProductCountryContentFactory $productCountryContentFactory, ProductFactory $productFactory, ProductTranslatableContentFactory $productTranslatableContentFactory, ProductAttributeRepository $productAttributeRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->countryRepository = $countryRepository;
        $this->languageRepository = $languageRepository;
        $this->productCountryContentFactory = $productCountryContentFactory;
        $this->productFactory = $productFactory;
        $this->productTranslatableContentFactory = $productTranslatableContentFactory;
        $this->productAttributeRepository = $productAttributeRepository;
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
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

        $relatedProducts = [];

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

            $product = $this->productFactory->create($enTitle, $enSummary, $enDescription, $usPrice, $usTax, $usDiscount, $usCurrency, true, false, $category, $usCountry, $enLanguage);
            $product->addCountryContent($this->productCountryContentFactory->create($czPrice, $czTax, $czDiscount, $czCurrency, true, false, $product, $czCountry));
            $product->addTranslatableContent($this->productTranslatableContentFactory->create($csTitle, $csSummary, $csDescription, $product, $csLanguage));
            $product->addAttributes(array_slice($productAttributes, ceil($i / 50) + 50, 50));

            if(count($relatedProducts) <= 100)
            {
                $relatedProducts[] = $product;
            }
            else
            {
                foreach($relatedProducts as $relatedProduct)
                {
                    $product->addAccessory($relatedProduct);
                    $product->addAlternative($relatedProduct);
                    $product->addVariant($relatedProduct);
                }
            }
        }
    }
}