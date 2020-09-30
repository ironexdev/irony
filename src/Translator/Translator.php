<?php

namespace App\Translator;

use App\Config\Config;
use App\Enum\LanguageEnum;
use App\Enum\RequestHeaderEnum;
use App\FileSystem\Filesystem;
use Error;

class Translator
{
    /**
     * @var string
     */
    private static $languageIso2;

    /**
     * @var array
     */
    private static $translations = [];

    /**
     * @param string $index
     * @param int|null $countable
     * @param array|null $variables
     * @return string
     */
    public static function __(string $index, ?int $countable = 1, ?array $variables = []): string
    {
        $index = preg_replace("/__(\/x|x)__/", "", $index);

        if ($countable === 1)
        {
            $translation = static::getTranslations()[$index][0] ?? $index;
        }
        else
        {
            $translation = static::getTranslations()[$index][static::getPluralFormIndex($countable, static::getLanguageIso2())] ?? $index;
        }

        if ($variables)
        {
            $newVariables = [];
            foreach ($variables as $key => $value)
            {
                $newVariables["{{" . $key . "}}"] = $value;
            }

            return strtr($translation, $newVariables);
        }

        return $translation;
    }

    /**
     * @return string
     */
    private static function getLanguageIso2(): string
    {
        if(!static::$languageIso2)
        {
            static::$languageIso2 = getallheaders()[RequestHeaderEnum::ACCEPT_LANGUAGE] ?? "en";
        }

        return static::$languageIso2;
    }

    /**
     * @param int $countable
     * @param string $language
     * @return int
     */
    private static function getPluralFormIndex(int $countable, string $language): int
    {
        if ($countable === 1)
        {
            return 0;
        }

        if ($language === LanguageEnum::EN)
        {
            return $countable === 1 ? 0 : 1;
        }
        else if ($language === LanguageEnum::CS)
        {
            return $countable === 1 ? 0 : ($countable >= 2 && $countable <= 4) ? 1 : 2;
        }
        else
        {
            throw new Error("Plural form for language " . $language . " not found.");
        }
    }

    /**
     * @return array
     */
    private static function getTranslations(): array
    {
        if (!static::$translations)
        {
            static::$translations = json_decode(Filesystem::readFile(Config::getTranslationsDirectory() . DIRECTORY_SEPARATOR . static::getLanguageIso2() . ".json"), true);
        }

        return static::$translations;
    }
}