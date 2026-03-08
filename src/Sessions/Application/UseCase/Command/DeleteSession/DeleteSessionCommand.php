<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Command\DeleteSession;

use App\Shared\Application\Command\BaseCommand;

final class DeleteSessionCommand implements BaseCommand
{
    public function __construct(
        public readonly int $idSession,
    ) {
    }
}
