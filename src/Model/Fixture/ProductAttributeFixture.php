<?php

namespace App\Model\Fixture;

use App\Enum\LanguageEnum;
use App\Model\Entity\Language;
use App\Model\Entity\ProductAttributeTranslatableContent;
use App\Model\Repository\LanguageRepository;
use App\Model\Repository\ProductAttributeFactory;
use App\Model\Repository\ProductAttributeTranslatableContentFactory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductAttributeFixture extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @var ProductAttributeFactory
     */
    private $productAttributeFactory;

    /**
     * @var ProductAttributeTranslatableContentFactory
     */
    private $productAttributeTranslatableContentFactory;

    /**
     * ProductAttributeFixture constructor.
     * @param \App\Model\Repository\LanguageRepository $languageRepository
     * @param \App\Model\Repository\ProductAttributeFactory $productAttributeFactory
     * @param \App\Model\Repository\ProductAttributeTranslatableContentFactory $productAttributeTranslatableContentFactory
     */
    public function __construct(LanguageRepository $languageRepository, ProductAttributeFactory $productAttributeFactory, ProductAttributeTranslatableContentFactory $productAttributeTranslatableContentFactory)
    {
        $this->languageRepository = $languageRepository;
        $this->productAttributeFactory = $productAttributeFactory;
        $this->productAttributeTranslatableContentFactory = $productAttributeTranslatableContentFactory;
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

        for ($i = 0; $i < 500; $i++)
        {
            $enTitle = "Title " . " " . $enLanguage->getIso2() . " " . $i;
            $csTitle = "Title " . " " . $csLanguage->getIso2() . " " . $i;
            $enUnits = "x" . $i . "-" . $enLanguage->getIso2();
            $csUnits = "x" . $i . "-" . $csLanguage->getIso2();

            $types = ["text", "int", "boolean", "decimal"];
            $type = $types[$i % 4];

            $productAttribute = $this->productAttributeFactory->create($type, $enTitle, $enUnits, $enLanguage);
            $productAttribute->addTranslatableContent($this->productAttributeTranslatableContentFactory->create($csTitle, $csUnits, $productAttribute, $csLanguage));

            $manager->persist($productAttribute);
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
            LanguageFixture::class
        ];
    }
}