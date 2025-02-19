<?php

declare(strict_types=1);

namespace App\Profiles\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

class ProfileNotFoundException extends AbstractException
{
    public function __construct(?string $username)
    {
        parent::__construct('Profile "' . $username . '" does not exist', 404);
    }
}