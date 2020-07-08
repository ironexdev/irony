<?php

namespace App\Enum;

class ResponseHeaderEnum
{
    use EnumTrait;

    const ACCESS_CONTROL_ALLOW_METHODS = "Access-Control-Allow-Methods";
    const ALLOW = "Allow";
    const CONTENT_LENGTH = "Content-Length";
    const CONTENT_TYPE = "Content-Type";
    const LOCATION = "Location";
}