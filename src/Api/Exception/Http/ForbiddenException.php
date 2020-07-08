<?php

namespace App\Api\Exception\Http;

use App\Translator\Translator;

class ForbiddenException extends AbstractHttpClientException
{
    /**
     * @var int
     */
    protected $code = 403;

    /**
     * @return string
     */
    protected function getDefaultMessage(): string
    {
        return Translator::__("__x__Forbidden__/x__");
    }
}