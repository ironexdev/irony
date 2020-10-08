<?php

namespace App\Model\Fixture;

use App\Model\Entity\Address;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class AddressFixture extends AbstractFixture
{
    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 10000; $i++)
        {
            $address = new Address("Street " . $i, "Street Number " . $i, "City " . $i, "Zip Code " . $i, "Country " . $i, "Note " . $i);

            $manager->persist($address);
        }

        $manager->flush();
    }
}