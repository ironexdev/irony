<?php

namespace App\Model\Fixture;
use App\Enum\LanguageEnum;
use App\Model\Entity\Language;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class LanguageFixture extends AbstractFixture
{
    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $enLanguage = new Language();
        $enLanguage->setIso2(LanguageEnum::EN);
        $manager->persist($enLanguage);

        $csLanguage = new Language();
        $csLanguage->setIso2(LanguageEnum::CS);
        $manager->persist($csLanguage);

        $manager->flush();

        echo static::class . " done.\n";
    }
}