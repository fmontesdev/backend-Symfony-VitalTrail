<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\CountFavoriteRoutes;

use App\Shared\Application\Query\BaseQuery;

final class CountFavoriteRoutesQuery implements BaseQuery
{
    public function __construct(
        public readonly string $username,
    ) {
    }
}
