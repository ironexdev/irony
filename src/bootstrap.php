<?php

use App\Api\Api;
use App\Config\Config;
use App\Enum\ResponseHeaderEnum;
use DI\ContainerBuilder;

const APPLICATION_DIRECTORY = __DIR__ . DIRECTORY_SEPARATOR . "..";

$config = array_merge(
    require_once(APPLICATION_DIRECTORY . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php"),
    require_once(APPLICATION_DIRECTORY . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config-local.php")
);

if ($config["environment"] === "development")
{
    ini_set("error_reporting", E_ALL);
    ini_set("display_errors", "On");
}
else
{
    if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] === "off")
    {
        echo "Website can only be accessed via HTTPS protocol";
        die();
    }
}

require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

date_default_timezone_set("UTC");

$containerBuilder = new ContainerBuilder();
$containerBuilder->enableCompilation(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "var" . DIRECTORY_SEPARATOR . "cache" . DIRECTORY_SEPARATOR . "php-di");
$containerBuilder->useAutowiring(true);
$containerBuilder->useAnnotations(true);
$containerBuilder->addDefinitions(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config-di.php");

$container = $containerBuilder->build();

try
{
    Config::init($config);

    $container->make(Api::class, ["container" => $container]);
}
catch (Throwable $e)
{
    $errorCode = $e->getCode() ?: 500;

    if ($config["environment"] === "development")
    {
        http_response_code($errorCode);
        throw $e;
    }
    else
    {
        if ($errorCode < 500)
        {
            http_response_code($errorCode);
        }
        else
        {
            http_response_code(500);
        }
    }
}