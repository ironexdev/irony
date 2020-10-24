<?php

namespace App\Model\Fixture;

use App\Enum\LanguageEnum;
use App\Model\Entity\Language;
use App\Model\Repository\LanguageFactory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class LanguageFixture extends AbstractFixture
{
    /**
     * @var LanguageFactory
     */
    private $languageFactory;

    /**
     * LanguageFixture constructor.
     * @param \App\Model\Repository\LanguageFactory $languageFactory
     */
    public function __construct(LanguageFactory $languageFactory)
    {
        $this->languageFactory = $languageFactory;
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $enLanguage = $this->languageFactory->create(LanguageEnum::EN);
        $manager->persist($enLanguage);

        $csLanguage = $this->languageFactory->create(LanguageEnum::CS);
        $manager->persist($csLanguage);

        $manager->flush();
        $manager->clear();

        echo static::class . " done.\n";
    }
}