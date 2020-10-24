<?php

namespace App\Model\Fixture;

use App\Enum\CountryEnum;
use App\Enum\LanguageEnum;
use App\Model\Entity\CategoryCountryContent;
use App\Model\Entity\CategoryTranslatableContent;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Repository\CategoryCountryContentFactory;
use App\Model\Repository\CategoryFactory;
use App\Model\Repository\CategoryRepository;
use App\Model\Repository\CategoryTranslatableContentFactory;
use App\Model\Repository\CountryRepository;
use App\Model\Repository\LanguageRepository;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @var CategoryCountryContentFactory
     */
    private $categoryCountryContentFactory;

    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * @var CategoryTranslatableContentFactory
     */
    private $categoryTranslatableContentFactory;

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
     * CategoryFixture constructor.
     * @param \App\Model\Repository\CategoryCountryContentFactory $categoryCountryContentFactory
     * @param \App\Model\Repository\CategoryFactory $categoryFactory
     * @param \App\Model\Repository\CategoryTranslatableContentFactory $categoryTranslatableContentFactory
     * @param \App\Model\Repository\CategoryRepository $categoryRepository
     * @param \App\Model\Repository\CountryRepository $countryRepository
     * @param \App\Model\Repository\LanguageRepository $languageRepository
     */
    public function __construct(CategoryCountryContentFactory $categoryCountryContentFactory, CategoryFactory $categoryFactory, CategoryTranslatableContentFactory $categoryTranslatableContentFactory, CategoryRepository $categoryRepository, CountryRepository $countryRepository, LanguageRepository $languageRepository)
    {
        $this->categoryCountryContentFactory = $categoryCountryContentFactory;
        $this->categoryFactory = $categoryFactory;
        $this->categoryTranslatableContentFactory = $categoryTranslatableContentFactory;
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

        $previousCategory = null;

        for($i = 0; $i < 500; $i++)
        {
            if($i % 25 === 0)
            {
                $previousCategory = null;
            }

            $enTitle = "Title " . " " . $enLanguage->getIso2() . " " . $i;
            $csTitle = "Title " . " " . $csLanguage->getIso2() . " " . $i;

            $category = $this->categoryFactory->create($enTitle, true, $previousCategory, $usCountry, $enLanguage);

            $csTranslatableContent = $this->categoryTranslatableContentFactory->create($csTitle, $category, $csLanguage);
            $czCountryContent = $this->categoryCountryContentFactory->create(true, $category, $czCountry);

            $category->addTranslatableContent($csTranslatableContent);
            $category->addCountryContent($czCountryContent);

            $previousCategory = $category;

            $manager->persist($category);
        }

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
            CountryFixture::class,
            LanguageFixture::class
        ];
    }
}