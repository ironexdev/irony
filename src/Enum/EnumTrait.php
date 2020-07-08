<?php

namespace App\Enum;

use ReflectionClass;
use ReflectionException;

trait EnumTrait
{
    /**
     * @var array
     */
    protected static $constants = [];

    /**
     * @return array
     */
    public static function getConstants(): array
    {
        $calledClass = get_called_class();

        if (isset(static::$constants[$calledClass]))
        {
            return static::$constants[$calledClass];
        }

        try
        {
            $reflection = new ReflectionClass(get_called_class());
        }
        catch (ReflectionException $e)
        {
            return [];
        }

        static::$constants[$calledClass] = $reflection->getConstants();

        return static::$constants[$calledClass];
    }
}