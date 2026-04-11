<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\GetUsersGrowth;

use App\Shared\Application\Query\BaseQuery;

final class GetUsersGrowthQuery implements BaseQuery
{
    public function __construct(
        public readonly int $months,
    ) {
    }
}
