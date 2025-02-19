<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\DeleteImageRoute;

use App\Shared\Application\Command\BaseCommand;

final class DeleteImageRouteCommand implements BaseCommand
{
    public function __construct(
        public readonly int $idImg,
    ) {}
}