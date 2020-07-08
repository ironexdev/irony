<?php

namespace App\Api\Exception\Http;

use App\Translator\Translator;

class UnsupportedMediaTypeException extends AbstractHttpClientException
{
    /**
     * @var int
     */
    protected $code = 415;

    /**
     * @return string
     */
    protected function getDefaultMessage(): string
    {
        return Translator::__("__x__Unsupported Media Type__/x__");
    }
}