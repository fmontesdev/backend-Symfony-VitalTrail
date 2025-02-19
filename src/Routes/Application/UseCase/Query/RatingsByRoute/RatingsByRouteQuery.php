<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\RatingsByRoute;

use App\Shared\Application\Query\BaseQuery;

final class RatingsByRouteQuery implements BaseQuery
{
    public function __construct(
        public readonly string $slugRoute
    ) {}
}