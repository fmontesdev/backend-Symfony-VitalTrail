<?php

declare(strict_types=1);

namespace App\Auth\Application\Config;

final class RefreshTokenConfig
{
    public const TOKEN_LENGTH = 128;
    public const USERNAME_LENGTH = 32;

    public const INPUT = 'RefreshTokenInput';

    public const OUTPUT = 'RefreshTokenOutput';

    public const VALID = 'RefreshTokenValid';
}
