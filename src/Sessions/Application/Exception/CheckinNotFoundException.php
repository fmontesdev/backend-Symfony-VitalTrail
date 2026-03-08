<?php

declare(strict_types=1);

namespace App\Sessions\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

final class CheckinNotFoundException extends AbstractException
{
    public function __construct(?int $idSession)
    {
        parent::__construct('No check-in found for session "' . $idSession . '"', 404);
    }
}
