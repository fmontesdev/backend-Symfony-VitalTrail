<?php

declare(strict_types=1);

namespace App\Auth\Application\Config;

final class UserConfig
{
    public const EMAIL_LENGTH = 180;
    public const USERNAME_LENGTH = 32;
    public const NAME_LENGTH = 64;
    public const SURNAME_LENGTH = 132;
    public const BIO_LENGTH = 255;
    public const IMAGE_LENGTH = 255;

    public const INPUT_REGISTER = 'UserInputRegister';
    public const INPUT_LOGIN = 'UserInputLogin';
    public const INPUT_UPDATE = 'UserInputUpdate';

    public const OUTPUT = 'UserOutput';
    public const OUTPUT_LOGIN = 'UserOutputLogin';

    public const VALID_REGISTER = 'UserValidRegister';
    public const VALID_LOGIN = 'UserValidLogin';
    public const VALID_UPDATE = 'UserValidUpdate';
}
