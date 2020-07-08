<?php

namespace App\Api\Exception\Http;

use App\Translator\Translator;

class UnprocessableEntityException extends AbstractHttpClientException
{
    /**
     * @var int
     */
    protected $code = 422;

    /**
     * @return string
     */
    protected function getDefaultMessage(): string
    {
        return Translator::__("__x__Unprocessable Entity__/x__");
    }
}