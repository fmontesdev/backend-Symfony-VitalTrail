<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\DeleteRating;

use App\Shared\Application\Command\BaseCommand;

final class DeleteRatingCommand implements BaseCommand
{
    public function __construct(
        public readonly string $slugRoute,
        public readonly int $idRating
    ) {}
}