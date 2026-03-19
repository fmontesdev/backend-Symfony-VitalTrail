<?php

declare(strict_types=1);

namespace App\Sessions\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

final class ActiveSessionNotFoundException extends AbstractException
{
    public function __construct()
    {
        parent::__construct('No active session found', 404);
    }
}
