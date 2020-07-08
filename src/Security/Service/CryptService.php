<?php

namespace App\Security\Service;

use App\Config\Config;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\BadFormatException;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Defuse\Crypto\Key;
use Error;

class CryptService
{
    /**
     * @var Key
     */
    private $key;

    /**
     * CryptService constructor.
     */
    public function __construct()
    {
        try
        {
            $this->key = Key::loadFromAsciiSafeString(Config::getSecurity()["encryption_key"]);
        }
        catch (BadFormatException $e)
        {
            throw new Error($e->getMessage(), 0, $e);
        }
        catch (EnvironmentIsBrokenException $e)
        {
            throw new Error($e->getMessage(), 0, $e);
        }
    }

    /**
     * @param string $encryptedData
     * @return string
     */
    public function decrypt(string $encryptedData): string
    {
        try
        {
            return Crypto::decrypt($encryptedData, $this->key);
        }
        catch (EnvironmentIsBrokenException $e)
        {
            throw new Error($e->getMessage(), 0, $e);
        }
        catch (WrongKeyOrModifiedCiphertextException $e)
        {
            throw new Error($e->getMessage(), 0, $e);
        }
    }

    /**
     * @param string $data
     * @return string
     */
    public function encrypt(string $data): string
    {
        try
        {
            return Crypto::encrypt($data, $this->key);
        }
        catch (EnvironmentIsBrokenException $e)
        {
            throw new Error($e->getMessage(), 0, $e);
        }
    }

    /**
     * @param $value
     * @return string
     */
    public function hash($value): string
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    /**
     * @param $value
     * @param $hash
     * @return bool
     */
    public function verify($value, $hash): bool
    {
        return password_verify($value, $hash);
    }
}