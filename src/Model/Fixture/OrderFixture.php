<?php

namespace App\Model\Fixture;

use App\Enum\CountryEnum;
use App\Enum\LanguageEnum;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Entity\Product;
use App\Model\Repository\CountryRepository;
use App\Model\Repository\LanguageRepository;
use App\Model\Repository\OrderRepository;
use App\Model\Repository\ProductFactory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderFixture extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var ProductFactory
     */
    private $productRepository;

    /**
     * ProductAttributeTextFixture constructor.
     * @param \App\Model\Repository\CountryRepository $countryRepository
     * @param \App\Model\Repository\LanguageRepository $languageRepository
     * @param \App\Model\Repository\OrderRepository $orderRepository
     * @param \App\Model\Repository\ProductFactory $productRepository
     */
    public function __construct(CountryRepository $countryRepository, LanguageRepository $languageRepository, OrderRepository $orderRepository, ProductFactory $productRepository)
    {
        $this->countryRepository = $countryRepository;
        $this->languageRepository = $languageRepository;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
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
        /** @var Product[] $products */
        $products = $this->productRepository->findAll();



        $manager->flush();
        $manager->clear();

        echo static::class . " done.";
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            LanguageFixture::class,
            ProductFixture::class,
            ProductAttributeFixture::class
        ];
    }
}