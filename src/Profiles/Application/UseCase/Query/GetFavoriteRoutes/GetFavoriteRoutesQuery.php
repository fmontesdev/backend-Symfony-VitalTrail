<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\GetFavoriteRoutes;

use App\Shared\Application\Query\BaseQuery;

final class GetFavoriteRoutesQuery implements BaseQuery
{
    public function __construct(
        public readonly string $username,
    ) {
    }
}
