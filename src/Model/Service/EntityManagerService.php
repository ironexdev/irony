<?php

namespace App\Model\Service;

use App\Config\Config;
use App\Enum\EnvironmentEnum;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\PhpFileCache;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

class EntityManagerService extends DoctrineEntityManager
{
    /**
     * EntityManagerService constructor.
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct()
    {
        $databaseConnectionConfig = Config::getDatabase();
        $doctrineConfig = Setup::createAnnotationMetadataConfiguration([
                                                                           APPLICATION_DIRECTORY . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "Model" . DIRECTORY_SEPARATOR . "Entity"
                                                                       ], true, null, null, false);

        if (Config::getEnvironment() !== EnvironmentEnum::DEVELOPMENT)
        {
            $cache = new PhpFileCache(APPLICATION_DIRECTORY . DIRECTORY_SEPARATOR . "var" . DIRECTORY_SEPARATOR . "cache" . DIRECTORY_SEPARATOR . "doctrine");
            $doctrineConfig->setMetadataCacheImpl($cache);
            $doctrineConfig->setQueryCacheImpl($cache);
        }
        else
        {
            $cache = new Arraycache();
            $doctrineConfig->setMetadataCacheImpl($cache);
            $doctrineConfig->setQueryCacheImpl($cache);
        }

        $connection = [
            "dbname" => $databaseConnectionConfig["name"],
            "user" => $databaseConnectionConfig["user"],
            "password" => $databaseConnectionConfig["password"],
            "host" => $databaseConnectionConfig["host"],
            "driver" => $databaseConnectionConfig["driver"],
            "serverVersion" => $databaseConnectionConfig["serverVersion"]
        ];

        if (!$doctrineConfig->getMetadataDriverImpl())
        {
            throw ORMException::missingMappingDriverImpl();
        }

        $connection = static::createConnection($connection, $doctrineConfig, null);

        parent::__construct($connection, $doctrineConfig, $connection->getEventManager());
    }
}