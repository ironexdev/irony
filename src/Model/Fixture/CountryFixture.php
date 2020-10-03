<?php

namespace App\Model\Fixture;
use App\Enum\CountryEnum;
use App\Model\Entity\Country;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixture extends AbstractFixture
{
    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $usCountry = new Country();
        $usCountry->setIso2(CountryEnum::US);
        $manager->persist($usCountry);

        $czCountry = new Country();
        $czCountry->setIso2(CountryEnum::CZ);
        $manager->persist($czCountry);

        $manager->flush();
    }
}