<?php

use App\Config\Config;
use DI\ContainerBuilder;

const APPLICATION_DIRECTORY = __DIR__ . DIRECTORY_SEPARATOR . "..";

$config = array_merge(
    require_once(APPLICATION_DIRECTORY . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php"),
    require_once(APPLICATION_DIRECTORY . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config-local.php")
);

ini_set("error_reporting", E_ALL);
ini_set("display_errors", "On");

require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(true);
$containerBuilder->useAnnotations(true);
$containerBuilder->addDefinitions(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config-di.php");

$container = $containerBuilder->build();
Config::init($config);