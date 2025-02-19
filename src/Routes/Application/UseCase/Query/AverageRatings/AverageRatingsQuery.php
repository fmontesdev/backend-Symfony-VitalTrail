<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\AverageRatings;

use App\Shared\Application\Query\BaseQuery;

final class AverageRatingsQuery implements BaseQuery
{
    public function __construct(
        public readonly string $slugRoute
    ) {}
}