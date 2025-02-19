<?php

namespace App\Auth\Domain\Enum;

enum RolUserEnum: string
{
    case ROLE_ADMIN = 'ROLE_ADMIN';
    case ROLE_CLIENT = 'ROLE_CLIENT';
}
