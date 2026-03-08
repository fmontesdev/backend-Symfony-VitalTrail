<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Command\CreateSession;

use App\Shared\Application\Command\BaseCommand;

final class CreateSessionCommand implements BaseCommand
{
    public function __construct(
        public readonly int $idRoute,
        public readonly ?\DateTimeImmutable $startAt,
    ) {
    }
}
