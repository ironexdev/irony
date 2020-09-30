<?php

namespace App\Config;

use Error;
use ReflectionClass;

class Config
{
    /**
     * @var string
     */
    private static $accessControlAllowOrigin;

    /**
     * @var string
     */
    private static $appDirectory;

    /**
     * @var array
     */
    private static $database;

    /**
     * @var array
     */
    private static $emails;

    /**
     * @var string
     */
    private static $environment;

    /**
     * @var array
     */
    private static $mailer;

    /**
     * @var array
     */
    private static $redis;

    /**
     * @var array
     */
    private static $security;

    /**
     * @var string
     */
    private static $siteName;

    /**
     * @var string
     */
    private static $translationsDirectory;

    /**
     * @param array $config
     */
    public static function init(array $config): void
    {
        try
        {
            $reflectionClass = new ReflectionClass(static::class);
        }
        catch (\ReflectionException $e)
        {
            throw new Error($e->getMessage(), $e->getCode());
        }

        $properties = $reflectionClass->getStaticProperties();
        foreach ($config as $key => $value)
        {
            if (!array_key_exists($key, $properties))
            {
                throw new Error("Property " . $key . " does not exist in " . __CLASS__ . ".");
            }

            self::${$key} = $value;
        }
    }

    /**
     * @return string
     */
    public static function getAccessControlAllowOrigin(): string
    {
        return self::$accessControlAllowOrigin;
    }

    /**
     * @return string
     */
    public static function getAppDirectory(): string
    {
        return self::$appDirectory;
    }

    /**
     * @return array
     */
    public static function getDatabase(): array
    {
        return static::$database;
    }

    /**
     * @return array
     */
    public static function getEmails(): array
    {
        return static::$emails;
    }

    /**
     * @return string
     */
    public static function getEnvironment(): string
    {
        return static::$environment;
    }

    /**
     * @return array
     */
    public static function getMailer(): array
    {
        return static::$mailer;
    }

    /**
     * @return array
     */
    public static function getRedis(): array
    {
        return static::$redis;
    }

    /**
     * @return array
     */
    public static function getSecurity(): array
    {
        return static::$security;
    }

    /**
     * @return string
     */
    public static function getSiteName(): string
    {
        return static::$siteName;
    }

    /**
     * @return string
     */
    public static function getTranslationsDirectory(): string
    {
        return self::$translationsDirectory;
    }
}