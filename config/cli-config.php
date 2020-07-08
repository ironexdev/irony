<?php

use App\Model\Service\EntityManagerService;

require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "console.php";

$entityManager = $container->get(EntityManagerService::class);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
