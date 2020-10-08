<?php

namespace App\Model\Fixture;

use DI\Container;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader as DoctrineFixtureLoader;

class Loader extends DoctrineFixtureLoader
{
    /**
     * @var Container $container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Creates the fixture object from the class.
     * @param string $class
     * @return FixtureInterface
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    protected function createFixture($class)
    {
        return $this->container->get($class);
    }
}