<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\CountRoutes;

use App\Shared\Application\Query\BaseQuery;

final class CountRoutesQuery implements BaseQuery
{
    public function __construct(
        public readonly string|null $category,
        public readonly string|null $location,
        public readonly string|null $title,
        public readonly int|null $distance,
        public readonly string|null $difficulty,
        public readonly string|null $typeRoute,
        public readonly string|null $author,
    ) {}
}