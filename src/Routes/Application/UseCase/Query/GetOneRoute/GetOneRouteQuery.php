<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\GetOneRoute;

use App\Shared\Application\Query\BaseQuery;

final class GetOneRouteQuery implements BaseQuery
{
    public function __construct(
        public readonly string $slug,
    ) {}
}

