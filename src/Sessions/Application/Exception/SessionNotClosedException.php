<?php

declare(strict_types=1);

namespace App\Sessions\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

final class SessionNotClosedException extends AbstractException
{
    public function __construct(int $idSession)
    {
        parent::__construct('Session "' . $idSession . '" is not closed yet', 409);
    }
}
