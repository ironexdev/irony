<?php

namespace App\Model\Fixture;

use App\Model\Repository\AddressFactory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class AddressFixture extends AbstractFixture
{
    /**
     * @var \App\Model\Repository\AddressFactory
     */
    private $addressFactory;

    /**
     * AddressFixture constructor.
     * @param \App\Model\Repository\AddressFactory $addressFactory
     */
    public function __construct(AddressFactory $addressFactory)
    {
        $this->addressFactory = $addressFactory;
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 10000; $i++)
        {
            $address = $this->addressFactory->create("Street " . $i, "Street Number " . $i, "City " . $i, "Zip Code " . $i, "Country " . $i, "Note " . $i);

            $manager->persist($address);
        }

        $manager->flush();
        $manager->clear();

        echo static::class . " done.\n";
    }
}