<?php

return [
    "appDirectory" => __DIR__ . DIRECTORY_SEPARATOR . "..",
    "database" => [
        "charset" => "UTF8",
        "driver" => "pdo_mysql",
        "host" => "127.0.0.1",
        "name" => "irony",
        "port" => "3306",
        "user" => "root",
        "password" => "",
        "serverVersion" => "mariadb-10.4.12"
    ],
    "emails" => [
        "admin" => "admin@ironexdev.com"
    ],
    "environment" => "production", // bootstrap.php does not use this configuration
    "language" => "cs", // bootstrap.php does not use this configuration
    "mailer" => [
        "host" => "smtp.onebit.cz",
        "port" => 587,
        "username" => "admin@ironexdev.com",
        "password" => "147258369vv"
    ],
    "redis" => [
        "allowed" => true,
        "host" => "127.0.0.1",
        "port" => "6379",
        "scheme" => "tcp",
        "timeout" => "0.1"
    ],
    "security" => [
        "encryption_key" => "def000004aef1b95639bf3873f9c7a773285c8d166939cfaa48c1a3e896d2e27e8e973540302132ddb0aaf397378c0be2c4a24e9ac23f216855161b7cd99a4fee6d8b4c9"
    ],
    "siteName" => "Irony",
    "supportedLanguages" => ["cs","en"],
    "translationDirectory" => __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "translation"
];