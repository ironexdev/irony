<?php

namespace App\FileSystem;

class Filesystem
{
    /**
     * @param string $path
     * @return bool
     */
    public static function fileExists(string $path): bool
    {
        return file_exists($path);
    }

    /**
     * @param string $directory
     * @return array
     */
    public static function readDirectory(string $directory): array
    {
        $content = scandir($directory);
        $files = [];

        foreach ($content as $key => $value)
        {
            $path = realpath($directory . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path))
            {
                $files[] = $path;
            }
            else if ($value !== "." && $value !== "..")
            {
                $files = array_merge($files, static::readDirectory($path));
            }
        }

        return $files;
    }

    /**
     * @param string $filePath
     * @return null|string
     */
    public static function readFile(string $filePath): ?string
    {
        $content = @file_get_contents($filePath);

        return $content;
    }

    /**
     * @param string $filePath
     * @param string $data
     * @param bool $overwrite
     * @return bool
     */
    public static function saveFile(string $filePath, string $data, bool $overwrite = false): bool
    {
        $flags = $overwrite ? 0 : FILE_APPEND;

        if (@file_put_contents($filePath, $data, $flags))
        {
            return true;
        }

        return false;
    }
}