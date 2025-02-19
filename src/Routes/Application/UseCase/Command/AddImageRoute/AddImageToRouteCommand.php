<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\AddImageRoute;

use App\Shared\Application\Command\BaseCommand;
use App\Routes\Application\Dto\ImageRouteDto;

final class AddImageToRouteCommand implements BaseCommand
{
    public function __construct(
        public readonly ImageRouteDto $data,
        public readonly int $idRoute,
    ) {}
}