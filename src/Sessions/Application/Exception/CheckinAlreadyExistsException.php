<?php

declare(strict_types=1);

namespace App\Sessions\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

final class CheckinAlreadyExistsException extends AbstractException
{
    public function __construct(?int $idSession)
    {
        parent::__construct('A check-in already exists for session "' . $idSession . '"', 409);
    }
}
