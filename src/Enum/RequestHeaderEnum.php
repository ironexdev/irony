<?php

namespace App\Enum;

class RequestHeaderEnum
{
    use EnumTrait;

    const ACCEPT = "Accept";
    const CONTENT_LENGTH = "Content-Length";
    const CONTENT_TYPE = "Content-Type";
    const X_REQUESTED_WITH = "X-Requested-With";
}