<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Command\CloseSession;

use App\Shared\Application\Command\BaseCommand;
use DateTimeImmutable;

final class CloseSessionCommand implements BaseCommand
{
    public function __construct(
        public readonly int $idSession,
        public readonly DateTimeImmutable $endAt,
        public readonly ?int $distance = null,
    ) {
    }
}
