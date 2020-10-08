<?php

use App\Model\Fixture\AccountFixture;
use App\Model\Fixture\CategoryFixture;
use App\Model\Fixture\CountryFixture;
use App\Model\Fixture\LanguageFixture;
use App\Model\Fixture\Loader;
use App\Model\Fixture\ProductAttributeFixture;
use App\Model\Fixture\ProductAttributeValueFixture;
use App\Model\Fixture\ProductFixture;
use App\Model\Service\EntityManagerService;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "console.php");

$loader = $container->get(Loader::class);
$loader->addFixture($container->get(AccountFixture::class));
$loader->addFixture($container->get(CategoryFixture::class));
$loader->addFixture($container->get(CountryFixture::class));
$loader->addFixture($container->get(LanguageFixture::class));
$loader->addFixture($container->get(ProductAttributeFixture::class));
$loader->addFixture($container->get(ProductAttributeValueFixture::class));
$loader->addFixture($container->get(ProductFixture::class));

$purger = $container->get(ORMPurger::class);
$entityManagerService = $container->get(EntityManagerService::class);
$executor = $container->make(ORMExecutor::class, ["em" => $entityManagerService, "purger" => $purger]);
$executor->execute($loader->getFixtures());

echo "Done, following is the list of generated Fixtures. \n- " . implode("\n- ", array_keys($loader->getFixtures()));