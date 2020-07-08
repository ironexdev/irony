<?php

use App\Config\Config;
use App\FileSystem\Filesystem;

require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "console.php");

$arguments = $argv;
$options = getopt("", ["search-directory:", "translation-directory:", "remove-unused:"]);

if (!isset($options["search-directory"], $options["translation-directory"], $options["remove-unused"]))
{
    echo "--search-directory, --translation-directory and --remove-unused options are required";
    exit;
}

$collectedTranslationIndexes = collectTranslationIndexes($options["search-directory"]);
createOrUpdateIndexFile($collectedTranslationIndexes, $options["remove-unused"], $options["translation-directory"]);
createOrUpdateTranslations($collectedTranslationIndexes, $options["remove-unused"], $options["translation-directory"]);

/**
 * @param string $searchDirectory
 * @return array
 */
function collectTranslationIndexes(string $searchDirectory): array
{
    $translationIndexes = [];

    foreach (Filesystem::readDirectory($searchDirectory) as $path)
    {
        $translationPrefix = "__x__";
        $translationSuffix = "__/x__";

        $fileContent = Filesystem::readFile($path);
        preg_match_all("/" . str_replace("/", "\/", $translationPrefix) . "(.*?)" . str_replace("/", "\/", $translationSuffix) . "/", $fileContent, $matches);

        foreach ($matches[0] as $translationIndex)
        {
            $translationIndex = str_replace($translationPrefix, "", $translationIndex);
            $translationIndex = str_replace($translationSuffix, "", $translationIndex);

            if (array_key_exists($translationIndex, $translationIndexes))
            {
                if (gettype($translationIndexes[$translationIndex]) === "string")
                {
                    $translationIndexes[$translationIndex] = [
                        $translationIndexes[$translationIndex],
                        $path
                    ];
                }
                else
                {
                    $translationIndexes[$translationIndex][] = $path;
                }

                continue;
            }

            $translationIndexes[$translationIndex] = $path;
        }
    }

    return $translationIndexes;
}

/**
 * @param array $collectedTranslationIndexes
 * @param bool $removeUnused
 * @param string $translationDirectory
 */
function createOrUpdateIndexFile(array $collectedTranslationIndexes, bool $removeUnused, string $translationDirectory): void
{
    $translationIndexFile = $translationDirectory . DIRECTORY_SEPARATOR . "index.json";
    $translationIndexes = [];

    if (Filesystem::fileExists($translationIndexFile))
    {
        $translationIndexes = json_decode(Filesystem::readFile($translationIndexFile), true);
    }

    if ($removeUnused)
    {
        foreach ($translationIndexes as $index => $path)
        {
            if (!isset($collectedTranslationIndexes[$index]))
            {
                unset($translationIndexes[$index]);
            }
        }
    }

    foreach ($collectedTranslationIndexes as $index => $path)
    {
        $translationIndexes[$index] = $path;
    }

    Filesystem::saveFile($translationIndexFile, json_encode($translationIndexes, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), true);
}

/**
 * @param array $collectedTranslationIndexes
 * @param bool $removeUnused
 * @param string $translationDirectory
 */
function createOrUpdateTranslations(array $collectedTranslationIndexes, bool $removeUnused, string $translationDirectory): void
{
    $supportedLanguages = Config::getSupportedLanguages();

    foreach ($supportedLanguages as $language)
    {
        $translationFile = $translationDirectory . "/" . $language . ".json";
        $translationData = [];

        if (Filesystem::fileExists($translationFile))
        {
            $translationData = json_decode(Filesystem::readFile($translationFile), true);
        }

        if ($removeUnused)
        {
            foreach ($translationData as $key => $value)
            {
                if (!isset($translationIndexes[$key]))
                {
                    unset($translationData[$key]);
                }
            }
        }

        foreach ($collectedTranslationIndexes as $index => $path)
        {
            if (isset($translationData[$index]))
            {
                continue;
            }

            $translationData[$index] = [
                $index
            ];
        }

        Filesystem::saveFile($translationFile, json_encode($translationData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), true);
    }
}
