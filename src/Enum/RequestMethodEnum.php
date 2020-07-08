<?php

namespace App\Enum;

class RequestMethodEnum
{
    use EnumTrait;

    const DELETE = "DELETE";
    const GET = "GET";
    const HEAD = "HEAD";
    const OPTIONS = "OPTIONS";
    const PATCH = "PATCH";
    const POST = "POST";
    const PUT = "PUT";
}