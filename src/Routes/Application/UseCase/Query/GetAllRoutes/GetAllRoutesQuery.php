<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\GetAllRoutes;

use App\Shared\Application\Query\BaseQuery;

final class GetAllRoutesQuery implements BaseQuery
{
    public function __construct(
        public readonly int $limit,
        public readonly int $offset,
        public readonly string|null $category,
        public readonly string|null $location,
        public readonly string|null $title,
        public readonly int|null $distance,
        public readonly string|null $difficulty,
        public readonly string|null $typeRoute,
        public readonly string|null $author,
    ) {}
}