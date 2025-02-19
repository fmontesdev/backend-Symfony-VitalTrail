<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\DeleteRoute;

use App\Shared\Application\Command\BaseCommand;

final class DeleteRouteCommand implements BaseCommand
{
    public function __construct(
        public readonly string $slug,
    ) {}
}