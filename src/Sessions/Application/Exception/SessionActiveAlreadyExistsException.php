<?php

declare(strict_types=1);

namespace App\Sessions\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

final class SessionActiveAlreadyExistsException extends AbstractException
{
    public function __construct()
    {
        parent::__construct('There is already an active session in progress', 409);
    }
}
