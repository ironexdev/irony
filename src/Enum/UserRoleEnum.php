<?php

namespace App\Enum;

class UserRoleEnum extends AccountRoleEnum
{
    use EnumTrait;

    const VISITOR = "visitor";
}