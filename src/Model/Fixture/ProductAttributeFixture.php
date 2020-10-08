<?php

namespace App\Model\Fixture;

use App\Enum\LanguageEnum;
use App\Model\Entity\Language;
use App\Model\Entity\ProductAttributeTranslatableContent;
use App\Model\Repository\LanguageRepository;
use App\Model\Repository\ProductAttributeRepository;
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
     * @var ProductAttributeRepository
     */
    private $productAttributeRepository;

    /**
     * ProductAttributeFixture constructor.
     * @param \App\Model\Repository\LanguageRepository $languageRepository
     * @param \App\Model\Repository\ProductAttributeRepository $productAttributeRepository
     */
    public function __construct(LanguageRepository $languageRepository, ProductAttributeRepository $productAttributeRepository)
    {
        $this->languageRepository = $languageRepository;
        $this->productAttributeRepository = $productAttributeRepository;
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     * @throws \Doctrine\ORM\ORMException
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

            $productAttribute = $this->productAttributeRepository->create($type, $enTitle, $enUnits, $enLanguage);
            $productAttribute->addTranslatableContent(new ProductAttributeTranslatableContent($csTitle, $csUnits, $productAttribute, $csLanguage));
        }

        $manager->flush();

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