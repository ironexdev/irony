<?php

namespace App\Enum;

class RequestHeaderEnum
{
    use EnumTrait;

    const ACCEPT = "Accept";
    const ACCEPT_LANGUAGE = "Accept-Language";
    const CONTENT_LENGTH = "Content-Length";
    const CONTENT_TYPE = "Content-Type";
    const X_COUNTRY = "X-Country";
    const X_REQUESTED_WITH = "X-Requested-With";
}