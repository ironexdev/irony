<?php

use App\Model\Fixture\AccountFixture;
use App\Model\Fixture\CategoryFixture;
use App\Model\Fixture\ProductFixture;
use App\Model\Service\EntityManagerService;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "console.php");

$loader = new Loader();
$loader->addFixture($container->get(AccountFixture::class));
$loader->addFixture($container->get(CategoryFixture::class));
$loader->addFixture($container->get(ProductFixture::class));

$purger = new ORMPurger();
$entityManagerService = $container->get(EntityManagerService::class);
$executor = new ORMExecutor($entityManagerService, $purger);
$executor->execute($loader->getFixtures());

echo "Done, following is the list of generated Fixtures. \n- " . implode("\n- ", array_keys($loader->getFixtures()));