<?php

namespace App\Api\Exception\Http;

use App\Translator\Translator;

class NotFoundException extends AbstractHttpClientException
{
    /**
     * @var int
     */
    protected $code = 404;

    /**
     * @return string
     */
    protected function getDefaultMessage(): string
    {
        return Translator::__("__x__Not Found__/x__");
    }
}