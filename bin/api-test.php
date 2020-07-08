<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "console.php");

$arguments = $argv;
$options = getopt("", ["data:", "schema:"]);

$data = $options["data"] ?? __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "api.json";
$schema = $options["schema"] ?? __DIR__ . DIRECTORY_SEPARATOR . "api-schema.json";

$apiService = $container->get(\App\Api\Service\ApiService::class);

echo $apiService->validateApiDefinition(json_decode(file_get_contents($data)), $schema);