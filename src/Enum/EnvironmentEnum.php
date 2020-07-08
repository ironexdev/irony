<?php

namespace App\Enum;

class EnvironmentEnum
{
    use EnumTrait;

    CONST DEVELOPMENT = "development";
    CONST STAGE = "stage";
    CONST PRODUCTION = "production";
}