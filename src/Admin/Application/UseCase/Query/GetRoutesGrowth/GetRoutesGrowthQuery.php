<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\GetRoutesGrowth;

use App\Shared\Application\Query\BaseQuery;

final class GetRoutesGrowthQuery implements BaseQuery
{
    public function __construct(
        public readonly int $months,
    ) {
    }
}
