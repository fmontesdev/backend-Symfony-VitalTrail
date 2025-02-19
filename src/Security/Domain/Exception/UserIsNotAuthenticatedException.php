<?php

declare(strict_types=1);

namespace App\Security\Domain\Exception;

use App\Shared\Domain\Exception\AbstractException;

class UserIsNotAuthenticatedException extends AbstractException
{
    public function __construct()
    {
        parent::__construct('The user is not authenticated', 401);
    }
}