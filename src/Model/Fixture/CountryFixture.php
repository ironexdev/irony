<?php

namespace App\Model\Fixture;

use App\Enum\CountryEnum;
use App\Model\Entity\Country;
use App\Model\Repository\CountryFactory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixture extends AbstractFixture
{
    /**
     * @var CountryFactory
     */
    private $countryFactory;

    /**
     * CountryFixture constructor.
     * @param \App\Model\Repository\CountryFactory $countryFactory
     */
    public function __construct(CountryFactory $countryFactory)
    {
        $this->countryFactory = $countryFactory;
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $usCountry = $this->countryFactory->create(CountryEnum::US);
        $manager->persist($usCountry);

        $czCountry = $this->countryFactory->create(CountryEnum::CZ);
        $manager->persist($czCountry);

        $manager->flush();
        $manager->clear();

        echo static::class . " done.\n";
    }
}