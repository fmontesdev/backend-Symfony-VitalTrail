<?php

declare(strict_types=1);

namespace App\Sessions\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

final class SessionNotFoundException extends AbstractException
{
    public function __construct(?int $idSession)
    {
        parent::__construct('Session "' . $idSession . '" does not exist', 404);
    }
}
