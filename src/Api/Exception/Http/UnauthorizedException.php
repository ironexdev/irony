<?php

namespace App\Api\Exception\Http;

use App\Translator\Translator;

class UnauthorizedException extends AbstractHttpClientException
{
    /**
     * @var int
     */
    protected $code = 401;

    /**
     * @return string
     */
    protected function getDefaultMessage(): string
    {
        return Translator::__("__x__Unauthenticated__/x__"); // HTTP status message is incorrectly names - it should be unauthenticated
    }
}