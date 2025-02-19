<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\UpdateRoute;

use App\Shared\Application\Command\BaseCommand;
use App\Routes\Application\Dto\RouteDto;

final class UpdateRouteCommand implements BaseCommand
{
    public function __construct(
        public readonly string $slug,
        public readonly RouteDto $data,
    ) {}
}