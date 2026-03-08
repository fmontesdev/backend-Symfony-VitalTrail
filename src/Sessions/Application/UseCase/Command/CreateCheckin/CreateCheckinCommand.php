<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Command\CreateCheckin;

use App\Shared\Application\Command\BaseCommand;

final class CreateCheckinCommand implements BaseCommand
{
    public function __construct(
        public readonly int $idSession,
        public readonly int $energy,
        public readonly int $stress,
        public readonly int $mood,
        public readonly ?string $notes,
    ) {
    }
}
