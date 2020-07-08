<?php

namespace App\Api\Exception\Http;

use App\Translator\Translator;

class BadRequestException extends AbstractHttpClientException
{
    /**
     * @var int
     */
    protected $code = 400;

    /**
     * @return string
     */
    protected function getDefaultMessage(): string
    {
        return Translator::__("__x__Bad Request__/x__");
    }
}