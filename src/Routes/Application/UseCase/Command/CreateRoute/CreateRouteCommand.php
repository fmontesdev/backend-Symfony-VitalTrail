<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\CreateRoute;

use App\Shared\Application\Command\BaseCommand;
use App\Routes\Application\Dto\RouteDto;

final class CreateRouteCommand implements BaseCommand
{
    public function __construct(
        public readonly RouteDto $data,
    ) {}
}