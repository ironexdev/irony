<?php

namespace App\Enum;

class ResponseHeaderEnum
{
    use EnumTrait;

    const ACCESS_CONTROL_ALLOW_HEADERS = "Access-Control-Allow-Headers";
    const ACCESS_CONTROL_ALLOW_METHODS = "Access-Control-Allow-Methods";
    const ACCESS_ALLOW_CONTROL_ORIGIN = "Access-Control-Allow-Origin";
    const ALLOW = "Allow";
    const CONTENT_LENGTH = "Content-Length";
    const CONTENT_TYPE = "Content-Type";
    const LOCATION = "Location";
}