<?php

namespace App\Api\Exception\Http;

use App\Translator\Translator;

class ConflictException extends AbstractHttpClientException
{
    /**
     * @var int
     */
    protected $code = 409;

    /**
     * @return string
     */
    protected function getDefaultMessage(): string
    {
        return Translator::__("__x__Conflict__/x__");
    }
}