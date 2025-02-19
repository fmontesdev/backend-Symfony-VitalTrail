<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\ImagesByRoute;

use App\Shared\Application\Query\BaseQuery;

final class ImagesByRouteQuery implements BaseQuery
{
    public function __construct(
        public readonly int $idRoute,
    ) {}
}